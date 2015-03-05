<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Movie;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="uek_homepage")
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
    	$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
    	$mostBorrowedMovies = $em->getRepository('UekMovieBundle:Movie')->findMostBorrowed(5);
    	$mostReviewedMovies = $em->getRepository('UekMovieBundle:Movie')->findMostReviewed(5);
    	 
        return $this->render('default/index.html.twig', array(
        		'movies' => $movies,
        		'genres' => $genres,
        		'selected_id' => 0, // All genres
        		'mostBorrowedMovies' => $mostBorrowedMovies,
        		'mostReviewedMovies' => $mostReviewedMovies));
    }
    
    /**
     * @Route("/borrowed", name="_borrowed")
     */
    public function borrowedAction()
    {
    	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    		return $this->render('UekUserBundle:Security:please.login.html.twig');
    	}
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	 
    	$em = $this->getDoctrine()->getManager();
    	$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
    	$movies = $em->getRepository('UekMovieBundle:Movie')->findBorrowedByUser($user);
    
    	return $this->render('default/borrowed.html.twig', array(
    			'movies' => $movies,
    			'genres' => $genres,
    			'selected_id' => 0 // All genres
    			));
    }
    
    /**
     * @Route("/filter/by/genre/{id}", name="_filter_by_genre")
     */
    public function rrowedByGenreAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$genre = $em->getRepository('UekMovieBundle:Genre')->findOneById($id);
    	if ($genre == null)
    	{
    		return $this->redirect($this->generateUrl('uek_homepage'));
    	}
    	
    	$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
    	$movies = $em->getRepository('UekMovieBundle:Movie')->findByGenre($genre);
    	$mostBorrowedMovies = $em->getRepository('UekMovieBundle:Movie')->findMostBorrowed(5);
    	$mostReviewedMovies = $em->getRepository('UekMovieBundle:Movie')->findMostReviewed(5);
    
    	return $this->render('default/index.html.twig', array(
    			'movies' => $movies,
    			'genres' => $genres,
    			'selected_id' => $genre->getId(),
    			'mostBorrowedMovies' => $mostBorrowedMovies,
    			'mostReviewedMovies' => $mostReviewedMovies));
    }
    
    /**
     * @Route("/borrowed/filter/by/genre/{id}", name="_borrowed_filter_by_genre")
     */
    public function filterBorrowedByGenreAction($id)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    		return $this->render('UekUserBundle:Security:please.login.html.twig');
    	}
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	
    	$genre = $em->getRepository('UekMovieBundle:Genre')->findOneById($id);
    	if ($genre == null)
    	{
    		return $this->redirect($this->generateUrl('_borrowed'));
    	}
    
    	$em = $this->getDoctrine()->getManager();
    	$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
    	$movies = $em->getRepository('UekMovieBundle:Movie')->findBorrowedByUserFilterByGenre($user, $genre);
    
    	return $this->render('default/borrowed.html.twig', array(
    			'movies' => $movies,
    			'genres' => $genres,
    			'selected_id' => 0 // All genres
    	));
    }
    
}
