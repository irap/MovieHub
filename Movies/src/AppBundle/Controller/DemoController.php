<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Helpers\GenreHelper;
use Uek\MovieBundle\Helpers\MovieHelper;
use Uek\MovieBundle\Helpers\SortHelper;

use Uek\MovieBundle\Entity\Movie;
use Uek\MovieBundle\Entity\Genre;


// /**
//  * @Route("/demo")
//  */
class DemoController extends Controller
{
	/**
	 * @Route("/create", name="_create_demo")
	 */
	public function createDemoAction()
	{
		// First, reset the previous demo movies
		$this->resetDemoAction();
		
		// Second, add new ones
		$demo_list = [
			['These Final Hours',
			 'A self-obsessed young man makes his way to the party-to-end-all-parties on the last day on Earth, but ends up saving the life of a little girl searching for her father. Their relationship ultimately leads him on the path to redemption.',
			 'Sarah Snook, Jessica De Gouw, Nathan Phillips',
			 'http://static.hd-trailers.net/images/these-final-hours-122456-poster-xlarge-resized.jpg',
			 'http://www.imdb.com/video/imdb/vi1426370073/imdb/embed?autoplay=false&width=480'],

			['Unfinished Business',
			 'A hard-working small business owner and his two associates travel to Europe to close the most important deal of their lives. But what began as a routine business trip goes off the rails in every way imaginable - and unimaginable - way, including unplanned stops at a massive sex fetish event and a global economic summit.',
			 'Vince Vaughn, Dave Franco, Tom Wilkinson',
			 'http://ia.media-imdb.com/images/M/MV5BNjg5NzU5ODE5OV5BMl5BanBnXkFtZTgwMjM1MjE2NDE@._V1_SY317_CR0,0,214,317_AL_.jpg',
			 'http://www.imdb.com/video/imdb/vi1415687705/imdb/embed?autoplay=false&width=480'],
		];

		$em = $this->getDoctrine()->getManager();
		foreach ($demo_list as list($title, $description, $actors, $coverArt, $videoUri)) 
		{
			$movie = new Movie();
			$movie->setTitle($title);
			$movie->setDescription($description);
			$movie->setActors($actors);
			$movie->setCoverArt($coverArt);
			$movie->setVideoUri($videoUri);
				
			$em->persist($movie);
			$em->flush();
		}
		
		return $this->redirect($this->generateUrl('_homepage'));
	}

	/**
	 * @Route("/reset", name="_rest_demo")
	 */
	public function resetDemoAction()
	{
		$em = $this->getDoctrine()->getManager();

		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		foreach ($movies as $movie) {
			$em->remove($movie);
		}
		
		$em->flush();

		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		return $this->redirect($this->generateUrl('_homepage'));
	}
}
