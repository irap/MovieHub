<?php

namespace Uek\MovieBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Uek\MovieBundle\Entity\Movie;
use Uek\MovieBundle\Entity\Review;
use Uek\StoreBundle\Entity\OrderStatus;
use Uek\StoreBundle\Entity\Order;


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
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    	return $this->render('UekMovieBundle:Movie:movie.html.twig', array('movie' => $movie, 'user' => $user));
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
     * @Route("/movie/{id}/add/review", name="_add_movie_review")
     */
    public function addMovieReviewAction($id)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    		return $this->render('UekUserBundle:Security:please.login.html.twig');
    	}

    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	 
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    
    	if ($movie)
    	{
    		// create a task and give it some dummy data for this example
    		$review = new Review();
			$review->setUser ( $user );
			$review->setMovie ( $movie );
    		
    		$form = $this->createFormBuilder($review)
    		->add('reviewText', 'textarea', array('attr' => array('cols' => '50', 'rows' => '5')))
    		->add('submit', 'submit', array('label' => 'Submit Review'))
    		->getForm();

    		$form->handleRequest($this->getRequest());
    		
    		if ($form->isValid()) {
    			// perform some action, such as saving the task to the database
    			
				$em->persist ( $review );
    			$em->flush();
    			
    			return $this->redirect($this->generateUrl('_movie', ['id' => $movie->getId()]));
    		}
    		
    		return $this->render('UekMovieBundle:Movie:add.review.movie.html.twig',
    				array('movie' => $movie, 'form' => $form->createView()));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('_homepage'));
    	}
    }

    /**
     * @Route("/movie/review/{id}", name="_show_movie_review")
     */
    public function showReviewAction($id)
    {
    	$review = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Review')
    	->findOneById($id);
    
    	if ($review)
    	{
    		return $this->render('UekMovieBundle:Movie:view.review.movie.html.twig',
    				array('review' => $review));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('_homepage'));
    	}
    }

    /**
     * @Route("/movie/{id}/all/reviews", name="_show_all_movie_review")
     */
    public function showAllReviewsAction($id)
    {
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    	 
   		return $this->render('UekMovieBundle:Movie:all.reviews.movie.html.twig',
    				array('movie' => $movie));
    }
    
}