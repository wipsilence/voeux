<?php

namespace AV\ListeVoeuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
	public function indexAction()
	{
		return $this->render('AVListeVoeuBundle:Home:homepage.html.twig');
	}
}
