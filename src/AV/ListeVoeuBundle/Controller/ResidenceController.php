<?php
// src/OC/PlatformBundle/Controller/AgentController.php

namespace AV\ListeVoeuBundle\Controller;

use AV\ListeVoeuBundle\Entity\Residence;
use AV\ListeVoeuBundle\Form\ResidenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ResidenceController extends Controller
{

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
		$liste_residence = $em->getRepository('AVListeVoeuBundle:Residence')->findAll();
		return $this->render('AVListeVoeuBundle:Residence:list.html.twig',array(
			'liste_residence'=>$liste_residence));
	}

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
	public function addAction (Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$residence = new Residence();
		$formulaire = $this->get('form.factory')->create(ResidenceType::class, $residence);

		if ($request->isMethod('POST') && $formulaire->handleRequest($request)->isValid()) {
			$villenom = $formulaire['ville']-> getData();
			$ville= $em -> getRepository('AVListeVoeuBundle:Ville')->findOneBy(array('nom' => $villenom));
			$directionnom = $formulaire['direction']-> getData();
			$direction= $em -> getRepository('AVListeVoeuBundle:Direction')->findOneBy(array('nom' => $directionnom));
			if ($ville and $direction) {
				$residence->setVille($ville);
				$residence->setDirection($direction);
				$em->persist($residence);
				$em->flush();
				$request->getSession()->getFlashBag()->add('notice', 'Résidence bien enregistrée.');
			}
			else {
				$request->getSession()->getFlashBag()->add('error', 'Résidence pas enregistrée.');
			}
			
			return $this->redirectToRoute('list_residence');
			
		} else {
			$touteslesvilles = $em -> getRepository('AVListeVoeuBundle:Ville')->findAll();
			$touteslesdirections = $em -> getRepository('AVListeVoeuBundle:Direction')->findAll();
			
			return $this->render('AVListeVoeuBundle:Residence:add.html.twig', array(
				'formulaire' => $formulaire->createView(),
				'touteslesvilles'=>$touteslesvilles,
				'touteslesdirections'=>$touteslesdirections,
			));
		}
	}

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
    public function delAction(Request $request, $residence_id)
	{
		$em = $this->getDoctrine()->getManager();
		$residence = $em->getRepository('AVListeVoeuBundle:Residence')->find($residence_id);
		$em->remove($residence);
		$em->flush();
		
		return $this->redirectToRoute('list_residence');
    }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
	public function editAction(Request $request, $residence_id)
	{
		$em = $this->getDoctrine()->getManager();
		$residence = $em->getRepository('AVListeVoeuBundle:Residence')->find($residence_id);

		if (empty($residence)){
			$request->getSession()->getFlashBag()->add('notice', "Résidence $residence_id non créée");
			return $this->redirectToRoute('add_residence');
		} else {
			$formulaire = $this->get('form.factory')->create(ResidenceType::class, $residence);

			$id_ville=$residence->getVille();
			$ville= $em->getRepository('AVListeVoeuBundle:Ville')->find($id_ville);
			$nomville=$ville->getNom();
			$formulaire['ville']->setData($nomville);
			
			$id_direction=$residence->getDirection();
			$direction= $em->getRepository('AVListeVoeuBundle:Direction')->find($id_direction);
			$nomdirection=$direction->getNom();
			$formulaire['direction']->setData($nomdirection);
		}
		
		if ($request->isMethod('POST') && $formulaire->handleRequest($request)->isValid()) {
			$villenom = $formulaire['ville']-> getData();
			$ville= $em -> getRepository('AVListeVoeuBundle:Ville')->findOneBy(array('nom' => $villenom));
			$directionnom = $formulaire['direction']-> getData();
			$direction= $em -> getRepository('AVListeVoeuBundle:Direction')->findOneBy(array('nom' => $directionnom));

			if ($ville and $direction) {
				$residence->setVille($ville);
				$residence->setDirection($direction);
				$em->persist($residence);
				$em->flush();
				$request->getSession()->getFlashBag()->add('notice', 'Résidence bien enregistré.');
			} else {
				$request->getSession()->getFlashBag()->add('error', 'Résidence pas enregistré.');
			}

			return $this->redirectToRoute('list_residence');
		} else {
			$touteslesvilles = $em -> getRepository('AVListeVoeuBundle:Ville')->findAll();
			$touteslesdirections = $em -> getRepository('AVListeVoeuBundle:Direction')->findAll();
			
			return $this->render('AVListeVoeuBundle:Residence:add.html.twig', array(
				'formulaire' => $formulaire->createView(),
				'touteslesvilles'=>$touteslesvilles,
				'touteslesdirections'=>$touteslesdirections,
			));
		}
	}
}

