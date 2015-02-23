<?php

namespace Uek\MovieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UekMovieBundle:Default:index.html.twig', array('name' => $name));
    }
}
