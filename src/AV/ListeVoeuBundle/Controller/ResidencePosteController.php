<?php
// src/OC/PlatformBundle/Controller/AgentController.php

namespace AV\ListeVoeuBundle\Controller;

use AV\ListeVoeuBundle\Entity\ResidencePoste;
use AV\ListeVoeuBundle\Form\ResidencePosteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ResidencePosteController extends Controller
{

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
		$liste_residence_poste = $em->getRepository('AVListeVoeuBundle:ResidencePoste')->findBy(array(), array('residence' => 'ASC', 'poste' => 'ASC'));
		return $this->render('AVListeVoeuBundle:ResidencePoste:list.html.twig',array(
			'liste_residence_poste'=>$liste_residence_poste));
	}

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
	public function addAction (Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$residence_poste = new ResidencePoste();
		$formulaire = $this->get('form.factory')->create(ResidencePosteType::class, $residence_poste);

		if ($request->isMethod('POST') && $formulaire->handleRequest($request)->isValid()) {
			$residence_nom = $formulaire['residence']-> getData();
			$residence= $em -> getRepository('AVListeVoeuBundle:Residence')->findOneBy(array('nom' => $residence_nom));
			$poste_nom = $formulaire['poste']-> getData();
			$poste= $em -> getRepository('AVListeVoeuBundle:Poste')->findOneBy(array('nom' => $poste_nom));
			if ($residence and $poste) {
				$residence_poste->setResidence($residence);
				$residence_poste->setPoste($poste);
				$em->persist($residence_poste);
				$em->flush();
				$request->getSession()->getFlashBag()->add('notice', 'Relation Résidence<->Poste bien enregistrée.');
			}
			else {
				$request->getSession()->getFlashBag()->add('error', 'Relation Résidence<->Poste pas enregistrée.');
			}
			
			return $this->redirectToRoute('list_residence_poste');
			
		} else {
			$toutes_residences = $em -> getRepository('AVListeVoeuBundle:Residence')->findAll();
			$tous_postes = $em -> getRepository('AVListeVoeuBundle:Poste')->findAll();
			
			return $this->render('AVListeVoeuBundle:ResidencePoste:add.html.twig', array(
				'formulaire' => $formulaire->createView(),
				'toutes_residences'=>$toutes_residences,
				'tous_postes'=>$tous_postes,
			));
		}
	}

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
    public function delAction(Request $request, $residence_id, $poste_id)
	{
		$em = $this->getDoctrine()->getManager();
		$residence_poste = $em->getRepository('AVListeVoeuBundle:ResidencePoste')->findOneBy(array('residence' => $residence_id, 'poste' => $poste_id));
		//$residence_poste = $em->getRepository('AVListeVoeuBundle:ResidencePoste')->find($residence_id, $poste_id);
		$em->remove($residence_poste);
		$em->flush();
		
		return $this->redirectToRoute('list_residence_poste');
    }
}

