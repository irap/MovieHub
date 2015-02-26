<?php

namespace Uek\MovieBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/movies")
 */
class MovieController extends Controller
{
	/**
	 * @Route("/all")
	 */
    public function allAction()
    {
    	$movies = $this->getDoctrine()
    				->getRepository('UekMovieBundle:Movie')
    				->findAll();
        return $this->render('UekMovieBundle:Movie:all.html.twig', array('movies' => $movies));
    }

    /**
     * @Route("/movie/{id}")
     */
    public function movieAction($id)
    {
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    	return $this->render('UekMovieBundle:Movie:movie.html.twig', array('movie' => $movie));
    }
    
}
