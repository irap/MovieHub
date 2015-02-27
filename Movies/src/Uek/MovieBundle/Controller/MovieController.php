<?php

namespace Uek\MovieBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Entity\Movie;

/**
 * @Route("/movies")
 */
class MovieController extends Controller
{
	/**
	 * @Route("/demo/create")
	 */
	public function demo_createAction()
	{
		// First, reset the previous demo movies
		$this->demo_resetAction();
		
		// Second, add new ones
		$demo_list = [
			['Hot Tub Time Machine 2', 
			 'Craig Robinson, Rob Corddry, Clark Duke, Chevy Chase, Collette Wolfe',
			 'http://images.fandango.com//ImageRenderer/94/141/mdcwebsite/images/global/still_looking94x141.jpg/179847/images/masterrepository/fandango/179847/hot-tub-time-machine-2-r.jpg'],
			
			['McFarland', 
			 'Kevin Costner, Maria Bello, Morgan Saylor, Martha Higareda, John Ortiz',
			 'http://images.fandango.com//ImageRenderer/94/141/mdcwebsite/images/global/still_looking94x141.jpg/167669/images/masterrepository/fandango/167669/mcfarlandusa-ps-4.jpg'],

			['The DUFF',
		     'Mae Whitman, Robbie Amell, Bella Thorne, Skyler Samuels, Ken Jeong',
			 'http://images.fandango.com//ImageRenderer/94/141/mdcwebsite/images/global/still_looking94x141.jpg/179547/images/masterrepository/fandango/179547/the-duff-poster.jpg'],
				
		];
		
		$em = $this->getDoctrine()->getManager();
		foreach ($demo_list as list($title, $actors, $coverArt)) {
			$movie = new Movie();
			$movie->setTitle($title);
			$movie->setActors($actors);
			$movie->setCoverArt($coverArt);
			
			$em->persist($movie);
		}
		$em->flush();
		
		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		return $this->render('UekMovieBundle:Movie:all.html.twig', array('movies' => $movies));
	}

	/**
	 * @Route("/demo/reset")
	 */
	public function demo_resetAction()
	{
		$em = $this->getDoctrine()->getManager();

		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		foreach ($movies as $movie) {
			$em->remove($movie);
		}
		
		$em->flush();

		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		return $this->render('UekMovieBundle:Movie:all.html.twig', array('movies' => $movies));
	}
	
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
