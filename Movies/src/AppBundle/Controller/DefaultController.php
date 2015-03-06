<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use AppBundle\Form\Fields\GenreChoiceType;
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

    	$filter_form = $this->createForm(new GenreChoiceType($genres, null), null,
    			array(
    			'action' => $this->generateUrl('uek_filter_submit'),
    			'method' => 'POST',));
    	 
        return $this->render('default/index.html.twig', array(
        		'movies' => $movies,
        		'filter_form' => $filter_form->createView(),
        		'mostBorrowedMovies' => $mostBorrowedMovies,
        		'mostReviewedMovies' => $mostReviewedMovies));
    }
    
    /**
     * @Route("/borrowed", name="uek_borrowed")
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

    	$filter_form = $this->createForm(new GenreChoiceType($genres, null), null,
    			array(
    					'action' => $this->generateUrl('uek_filter_borrowed_submit'),
    					'method' => 'POST',));
    	 
    	return $this->render('default/borrowed.html.twig', array(
    			'movies' => $movies,
    			'genres' => $genres,
        		'filter_form' => $filter_form->createView(),
       			));
    }
    
    /**
     * @Route("/filter/by/genre/{id}", name="uek_filter_by_genre")
     */
    public function filterdByGenreAction($id)
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

    	$filter_form = $this->createForm(new GenreChoiceType($genres, $genre), null,
    			array('action' => $this->generateUrl('uek_filter_submit'), 'method' => 'POST',));
    	 
    	return $this->render('default/index.html.twig', array(
    			'movies' => $movies,
    			'filter_form' => $filter_form->createView(),
    			'mostBorrowedMovies' => $mostBorrowedMovies,
    			'mostReviewedMovies' => $mostReviewedMovies));
    }
    
    /**
     * @Route("/borrowed/filter/by/genre/{id}", name="uek_filter_borrowed_by_genre")
     */
    public function filterBorrowedByGenreAction($id)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    		return $this->render('UekUserBundle:Security:please.login.html.twig');
    	}
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	
    	$em = $this->getDoctrine()->getManager();
    	$genre = $em->getRepository('UekMovieBundle:Genre')->findOneById($id);
    	if ($genre == null)
    	{
    		return $this->redirect($this->generateUrl('uek_borrowed'));
    	}
    
    	$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
    	$movies = $em->getRepository('UekMovieBundle:Movie')->findBorrowedByUserFilteredByGenre($user, $genre);

    	$filter_form = $this->createForm(new GenreChoiceType($genres, $genre), null,
    			array('action' => $this->generateUrl('uek_filter_borrowed_submit'), 'method' => 'POST',));
    	 
    	return $this->render('default/borrowed.html.twig', array(
    			'movies' => $movies,
    			'genres' => $genres,
    			'filter_form' => $filter_form->createView(),
    	));
    }

    /**
     * @Route("/filter_submit", name="uek_filter_submit")
     */
    public function filterSubmit()
    {
    	$em = $this->getDoctrine()->getManager();
    	$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
    	 
    	$filter_form = $this->createForm(new GenreChoiceType($genres, null), null,
    			array(	'action' => $this->generateUrl('uek_filter_submit'),
    					'method' => 'POST',));
    	
    	if ($this->getRequest()->getMethod() == 'POST') {
    		$filter_form->bind($this->getRequest());
    	
    		if ($filter_form->isValid()) {
    			$choice = $filter_form['genre_choice']->getData();
    			
    			if ($choice != 0)
    			{
    				return $this->redirect($this->generateUrl('uek_filter_by_genre', array('id'=>$choice)));
    			}
    		}
    	}
    	
    	return $this->redirect($this->generateUrl('uek_homepage'));
    }

    /**
     * @Route("/filter_borrowed_submit", name="uek_filter_borrowed_submit")
     */
    public function filterBorrowedSubmit()
    {
    	$em = $this->getDoctrine()->getManager();
    	$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
    
    	$filter_form = $this->createForm(new GenreChoiceType($genres, null), null,
    			array(	'action' => $this->generateUrl('uek_filter_borrowed_submit'),
    					'method' => 'POST',));
    	 
    	if ($this->getRequest()->getMethod() == 'POST') {
    		$filter_form->bind($this->getRequest());
    		 
    		if ($filter_form->isValid()) {
    			$choice = $filter_form['genre_choice']->getData();
    			 
    			if ($choice != 0)
    			{
    				return $this->redirect($this->generateUrl('uek_filter_borrowed_by_genre', array('id'=>$choice)));
    			}
    		}
    	}
    	 
    	return $this->redirect($this->generateUrl('uek_borrowed'));
    }
    
}
