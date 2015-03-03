<?php

namespace Uek\MovieBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Uek\MovieBundle\Entity\Movie;


// /**
//  * @Route("/movie")
//  */
class MovieController extends Controller
{
    /**
     * @Route("/movie/{id}", name="_movie")
     */
    public function movieAction($id)
    {
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    	return $this->render('UekMovieBundle:Movie:movie.html.twig', array('movie' => $movie));
    }

    /**
     * @Route("/movie/{id}/watch", name="_watch_movie")
     */
    public function watchMovieAction($id)
    {
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    	
    	if ($movie)
    	{
    		return $this->render('UekMovieBundle:Movie:watch.movie.html.twig', array('movie' => $movie));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('_homepage'));
    	}
    }

    /**
     * @Route("/movie/{id}/review", name="_add_movie_review")
     */
    public function addMovieReviewAction($id)
    {
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    
    	if ($movie)
    	{
    		return $this->render('UekMovieBundle:Movie:review.movie.html.twig', array('movie' => $movie));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('_homepage'));
    	}
    }

    /**
     * @Route("/movie/{id}/borrow", name="_borrow_movie")
     */
    public function borrowMovieAction($id)
    {
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    
    	if ($movie)
    	{
    		return $this->render('UekMovieBundle:Movie:borrow.movie.html.twig', array('movie' => $movie));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('_homepage'));
    	}
    }
}
