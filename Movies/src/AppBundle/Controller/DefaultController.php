<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Movie;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_homepage")
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
    	$mostBorrowedMovies = $em->getRepository('UekMovieBundle:Movie')->findMostBorrowed(5);
    	$mostReviewedMovies = $em->getRepository('UekMovieBundle:Movie')->findMostReviewed(5);
    	
        return $this->render('default/index.html.twig', array(
        		'movies' => $movies,
        		'mostBorrowedMovies' => $mostBorrowedMovies,
        		'mostReviewedMovies' => $mostReviewedMovies));
    }
}
