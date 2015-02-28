<?php

namespace Uek\MovieBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Entity\Movie;
use Uek\MovieBundle\Entity\Genre;

// /**
//  * @Route("/movies")
//  */
class MovieController extends Controller
{
	/**
	 * @Route("/demo/create")
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
		foreach ($demo_list as list($title, $description, $actors, $coverArt, $video)) {
			$movie = new Movie();
			$movie->setTitle($title);
			$movie->setDescription($description);
			$movie->setActors($actors);
			$movie->setCoverArt($coverArt);
			$movie->setVideo($video);
				
			$em->persist($movie);
		}
		$em->flush();
		
		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		return $this->render('UekMovieBundle:Movie:all.html.twig', array('movies' => $movies));
	}

	/**
	 * @Route("/demo/reset")
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
		return $this->render('UekMovieBundle:Movie:all.html.twig', array('movies' => $movies));
	}
	
	/**
	 * @Route("/movie/create")
	 */
	public function createMovieAction()
	{
		$genre = new Genre();
		$genre->setName('Demo genre');
		$genre2 = new Genre();
		$genre2->setName('Demo genre2');
		
		$movie = new Movie();
		$movie->setTitle('Demo movie');
		$movie->setDescription('Demo movie description');
		$movie->setActors('Demo actro1, demo actor2');
		$movie->setCoverArt("demo cover");
		$movie->setVideo('demo video');
		
		// relate this movie to the genre
		$movie->addGenre($genre);
		$movie->addGenre($genre2);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($genre);
		$em->persist($movie);
		$em->flush();
		
		return $this->render('UekMovieBundle:Movie:movie.html.twig', array('movie' => $movie));
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

    /**
     * @Route("/movie/watch/{id}")
     */
    public function watch_movieAction($id)
    {
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    	return $this->render('UekMovieBundle:Movie:watch.movie.html.twig', array('movie' => $movie));
    }
    
}
