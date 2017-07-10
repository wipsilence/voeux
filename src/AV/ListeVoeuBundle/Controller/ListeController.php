<?php
// src/OC/PlatformBundle/Controller/AgentController.php

namespace AV\ListeVoeuBundle\Controller;

use AV\ListeVoeuBundle\Entity\Ville;
use AV\ListeVoeuBundle\Entity\Liste;
use AV\ListeVoeuBundle\Form\ListeAddType;
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

    public function indexAction(Request $request, $list_id=null, $donneesForm=null)
	{
        $em = $this->getDoctrine()->getManager();
        # Récupération de l'agent
        $agent = $this->getUser();

        if($list_id == null) {
            # Récupération des listes existantes de l'agent
            $listes = $agent->getListes();
            return $this->render('AVListeVoeuBundle:Liste:choix.html.twig',array(
                'listes'=>$listes,
                'agent'=>$agent

                )
            );
        } else {
            # Récupération de la liste
            $liste = $em->getRepository('AVListeVoeuBundle:Liste')->find($list_id);
            # Récupération du domicile de l'agent
            $domicile = $agent->getDomicile();
            # Récupération des résidences
            $residences = $em->getRepository('AVListeVoeuBundle:Residence')->findAll();
            # Récupération des villes associées aux résidences
            $chVilles = '';
            foreach ($residences as $res) {
                $villes[$res->getVille()->getNom()] = $this->distance($domicile->getLattitude(),        $domicile->getLongitude(),
                                                                      $res->getVille()->getLattitude(), $res->getVille()->getLongitude());
            }
            # Tri des villes
            asort($villes);
            return $this->render('AVListeVoeuBundle:Liste:index.html.twig',array(
                'liste'=>$liste,
                'domicile'=>$domicile,
                'villes'=>$villes,
                'donneesForm'=>$donneesForm,
                )
            );
        }
	}

    public function suppAction(Request $request, $list_id)
	{
        $em = $this->getDoctrine()->getManager();
        # Récupération de l'agent
        $agent = $this->getUser();
        # Récupération des listes
        $listes = $agent->getListes();
        foreach ($listes as $list) {
            if($list->getId() == $list_id) {
                $nomList = $list->getNom();
                $em->remove($list);
                $em->flush();

                $session = $this->get('session');
                $session->getFlashBag()->add('info', 'Liste "'.$nomList.'" bien supprimée');
            }
        }
        return $this->redirectToRoute('liste_choix');
    }

    public function ajoutAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

        # Récupération de l'agent
        $agent = $this->getUser();

		$liste = new Liste();
		$formulaire = $this->get('form.factory')->create(ListeAddType::class, $liste);

		if ($request->isMethod('POST') && $formulaire->handleRequest($request)->isValid()) {
            # Formulaire renseigné
            $donneesForm = $formulaire->getData();
            $liste->setAgent($agent);
            $em->persist($liste);
            $em->flush();
            # On affiche la liste des voeux
			return $this->redirectToRoute('liste_agent', array('list_id'=>$liste->getId(),
                                                               'donneesForm'=>$donneesForm,
                                                              ));
        } else {
            # Récupération de la liste des postes
            $postes = $em->getRepository('AVListeVoeuBundle:Poste')->findAll();
            # Appel du formulaire pour saisie
            return $this->render('AVListeVoeuBundle:Liste:add.html.twig', array(
                'formulaire' => $formulaire->createView(),
                'agent' => $agent,
                'postes' => $postes,
		));
        }
    }
}
