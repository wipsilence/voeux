<?php
// src/OC/PlatformBundle/Controller/AgentController.php

namespace AV\ListeVoeuBundle\Controller;

use AV\ListeVoeuBundle\Entity\Agent;
use AV\ListeVoeuBundle\Form\AgentEditType;
use AV\ListeVoeuBundle\Form\AgentAddType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AgentController extends Controller
{

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
	public function indexAction()
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			throw new AccessDeniedException('Accès limité aux administrateurs.');
		} else {
			$em = $this->getDoctrine()->getManager();
			$liste_agent = $em->getRepository('AVListeVoeuBundle:Agent')->findAll();
			return $this->render('AVListeVoeuBundle:Agent:index.html.twig',array(
				'liste_agent'=>$liste_agent));
		}
	}
    
	public function addAction (Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$agent = new Agent();
		$formulaire = $this->get('form.factory')->create(AgentAddType::class, $agent);

		if ($request->isMethod('POST') && $formulaire->handleRequest($request)->isValid()) {

			//~ // récupérer les données du champs domicile
			$domicilenom = $formulaire['domicile']-> getData();
			$domicile= $em -> getRepository('AVListeVoeuBundle:Ville')->findOneBy(array('nom' => $domicilenom));

			if ($domicile) {
				$agent->setDomicile($domicile);
				$em->persist($agent);
				$em->flush();
			}
			else {

			}

			$request->getSession()->getFlashBag()->add('notice', 'Agent bien enregistré.');
			return $this->redirectToRoute('av_liste_agent_view');
		}

		$touteslesvilles = $em -> getRepository('AVListeVoeuBundle:Ville')->findAll();

		return $this->render('AVListeVoeuBundle:Agent:add.html.twig', array(
			'formulaire' => $formulaire->createView(),
			'domicile'=> $formulaire['domicile'],
			'touteslesvilles'=>$touteslesvilles,
		));

	}
	
	public function editAction(Request $request, $agent_id)
	{
		$em = $this->getDoctrine()->getManager();
		$agent = $em->getRepository('AVListeVoeuBundle:Agent')->find($agent_id);

		if (empty($agent)){
			$request->getSession()->getFlashBag()->add('notice', "Agent $agent_id non créé");
			return $this->redirectToRoute('add_agent');
		}
		else{

			$formulaire = $this->get('form.factory')->create(AgentEditType::class, $agent);

			$id_ville=$agent->getDomicile();
			$ville= $em->getRepository('AVListeVoeuBundle:Ville')->find($id_ville);
			$nomville=$ville->getNom();
			$formulaire['domicile']->setData($nomville);
		}
		if ($request->isMethod('POST') && $formulaire->handleRequest($request)->isValid()) {

			//~ // récupérer les données du champs domicile
			$domicilenom = $formulaire['domicile']-> getData();
			$domicile= $em -> getRepository('AVListeVoeuBundle:Ville')->findOneBy(array('nom' => $domicilenom));

			if ($domicile) {
				$agent->setDomicile($domicile);
				$em->persist($agent);
				$em->flush();
			}
			else {

			}

			$request->getSession()->getFlashBag()->add('notice', 'Agent bien enregistré.');
			return $this->redirectToRoute('av_liste_agent_view');
		}

		$touteslesvilles = $em -> getRepository('AVListeVoeuBundle:Ville')->findAll();
		return $this->render('AVListeVoeuBundle:Agent:edit.html.twig', array(
			'formulaire' => $formulaire->createView(),
			'domicile' => $nomville,
			'touteslesvilles'=>$touteslesvilles,
			'agent' => $agent
		));
	}
	
	public function testAction(){
		$em = $this->getDoctrine()->getManager();
		$touteslesvilles = $em -> getRepository('AVListeVoeuBundle:Ville')->findAll();
		return $this->render('AVListeVoeuBundle:Agent:test.html.twig', array('touteslesvilles'=>$touteslesvilles));	
	}
	public function supAction(Request $request, $agent_id)
	{
        $em = $this->getDoctrine()->getManager();
        # Récupération de l'agent
        $agent = $em->getRepository('AVListeVoeuBundle:Agent')->find($agent_id);
        $nomAgent=$agent->getNom();
        # récupération des listes liées à $agent
        $listes = $agent->getListes();
        foreach ($listes as $list) {
                $em->remove($list);
                $em->flush();
		}
		$em->remove($agent);
        $em->flush();

        $session = $this->get('session');
        $session->getFlashBag()->add('info', 'Agent "'.$nomAgent.'" bien supprimé');
        return $this->redirectToRoute('av_liste_agent_view');
    }
	
}

