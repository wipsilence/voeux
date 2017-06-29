<?php
// src/OC/PlatformBundle/Controller/AgentController.php

namespace AV\ListeVoeuBundle\Controller;

use AV\ListeVoeuBundle\Entity\Ville;
use AV\ListeVoeuBundle\Form\AgentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListeController extends Controller
{
	//Conversion des degrés en radian et calcul distance
    private function convertRad($input) {
        return (M_PI * $input) / 180;
    }

    private function distance($lat_a_degre, $lon_a_degre, $lat_b_degre, $lon_b_degre){

        $R = 6378000; //Rayon de la terre en mètre

        $lat_a = $this->convertRad($lat_a_degre);
        $lon_a = $this->convertRad($lon_a_degre);
        $lat_b = $this->convertRad($lat_b_degre);
        $lon_b = $this->convertRad($lon_b_degre);

        $d = $R * (M_PI/2 - asin( sin($lat_b) * sin($lat_a) + cos($lon_b - $lon_a) * cos($lat_b) * cos($lat_a)));
        return round($d/1000); # Distance arrondie en kilomètre
    }

    public function indexAction($list_id)
	{
        $prefixeURL = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=';
        $destination = '&destinations=';
        $cleAPI = '&key=AIzaSyAn7YFWX2VJ147j4AXX1kvD7rnLpGIpNaA';

        $em = $this->getDoctrine()->getManager();
        # Récupération de l'agent
		$agent = $em->getRepository('AVListeVoeuBundle:Agent')->find(1);
        # Récupération de son domicile
		$domicile = $agent->getDomicile();
        # Récupération des résidences
        $residences = $em->getRepository('AVListeVoeuBundle:Residence')->findAll();
        # Récupération des villes associées aux résidences
        $chVilles = '';
        foreach ($residences as $res) {
            //~ $villes[] = $res->getVille();
            //~ $chVilles .= '|' . $res->getVille()->getNom();
            $villes[$res->getVille()->getNom()] = $this->distance($domicile->getLattitude(),        $domicile->getLongitude(),
                                                                  $res->getVille()->getLattitude(), $res->getVille()->getLongitude());
        }
        # Tri des villes
        asort($villes);
        //~ $chVilles = substr($chVilles, 1); # Suppression du premier '|' inutile
        # Tri de ce tableau
        //~ $retourJson = file_get_contents($prefixeURL . $domicile->getNom() . $destination . $chVilles . $cleAPI);
        $retourJson = $prefixeURL . $domicile->getNom() . $destination . $chVilles . $cleAPI;
		return $this->render('AVListeVoeuBundle:Liste:index.html.twig',array(
			'agent'=>$agent,
            'domicile'=>$domicile,
            'villes'=>$villes,
            'retour'=>$retourJson
            )
        );
	}
}
