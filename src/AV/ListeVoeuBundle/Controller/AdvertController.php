<?php

namespace AV\ListeVoeuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
//	public function indexAction()
//	{
//		$content = $this 
//			-> get('templating') 
//			-> render('AVListeVoeuBundle:Advert:index.html.twig', array('nom' => 'winzou'));
//		return new Response ($content);
//		// utiliser un service
//		$mailer = $this->container->get('mailer');
//	}
	public function addAction(Request $request)
	{
	// On récupère le service
	$antispam = $this->container->get('av_listevoeu.antispam');
	// Je pars du principe que $text contient le texte d'un message quelconque
	$text = 'blabla...';
	if ($antispam->isSpam($text)) {
	      throw new \Exception('Votre message a été détecté comme spam !');
	}
	// Ici le message n'est pas un spam
	}
}
