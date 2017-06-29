<?php

namespace AV\ListeVoeuBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AVListeVoeuBundle extends Bundle
{
	public function indexAction()
	{
		return new Response("Notre propre Hello World !");

	}
}
