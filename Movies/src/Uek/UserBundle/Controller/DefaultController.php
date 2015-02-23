<?php

namespace Uek\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UekUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
