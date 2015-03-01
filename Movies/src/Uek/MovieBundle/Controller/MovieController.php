<?php

namespace Uek\MovieBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Helpers\GenreHelper;
use Uek\MovieBundle\Helpers\MovieHelper;
use Uek\MovieBundle\Helpers\SortHelper;

use Uek\MovieBundle\Entity\Movie;
use Uek\MovieBundle\Entity\Genre;
use Uek\MovieBundle\Form\Filter\MovieFilterType;
use Uek\MovieBundle\Form\Sort\MovieSortType;


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
			  ['Drama', 'Thriller'],
			 'A self-obsessed young man makes his way to the party-to-end-all-parties on the last day on Earth, but ends up saving the life of a little girl searching for her father. Their relationship ultimately leads him on the path to redemption.',
			 'Sarah Snook, Jessica De Gouw, Nathan Phillips',
			 'http://static.hd-trailers.net/images/these-final-hours-122456-poster-xlarge-resized.jpg',
			 'http://www.imdb.com/video/imdb/vi1426370073/imdb/embed?autoplay=false&width=480'],

			['Unfinished Business',
			  ['Comedy'],
			 'A hard-working small business owner and his two associates travel to Europe to close the most important deal of their lives. But what began as a routine business trip goes off the rails in every way imaginable - and unimaginable - way, including unplanned stops at a massive sex fetish event and a global economic summit.',
			 'Vince Vaughn, Dave Franco, Tom Wilkinson',
			 'http://ia.media-imdb.com/images/M/MV5BNjg5NzU5ODE5OV5BMl5BanBnXkFtZTgwMjM1MjE2NDE@._V1_SY317_CR0,0,214,317_AL_.jpg',
			 'http://www.imdb.com/video/imdb/vi1415687705/imdb/embed?autoplay=false&width=480'],
		];

		$movie_helper = $this->get('uek.moviebundle.movie.helper');
		foreach ($demo_list as $movie_params) 
		{
			$movie_helper->createMovie($movie_params);
		}
		
		return $this->redirect($this->generateUrl('_all_movies'));
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
		return $this->redirect($this->generateUrl('_all_movies'));
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
	 * @Route("/all", name="_all_movies")
	 */
    public function allAction()
    {
    	$sort_helper = $this->getSortHelper();
    	$genre_helper = $this->getGenreHelper();

    	$filter_form = $this->get('form.factory')->create(new MovieFilterType($genre_helper));
    	$sort_form = $this->get('form.factory')->create(new MovieSortType($sort_helper));
    	    	 
    	$movies = $this->getDoctrine()
    		->getRepository('UekMovieBundle:Movie')
    		->findAllByAndSort($genre_helper->getFilterGenre(), $sort_helper);
    	
    	
    	return $this->render('UekMovieBundle:Movie:all.html.twig', array(
    			'movies' => $movies, 'filter_form' => $filter_form->createView(),
    			'sort_form' => $sort_form->createView()
    	));
    }

    /**
     * Displays filtered items.
     *
     * @Route("/filter/by/genre/{name}", name="_filter_by_genre")
     *
     */
    public function filterMovieByGenreAction($name)
    {
    	$sort_helper = $this->getSortHelper();
    	$genre_helper = $this->getGenreHelper();
    	 
    		// initialize a query builder
    	$em = $this->getDoctrine()->getManager();
    	$genre = $em->getRepository('UekMovieBundle:Genre')->findOneByName($name);
    	if ($genre != null)
    	{
    		$form = $this->get('form.factory')->create(new MovieFilterType($genre_helper));
    		$movies = $em->getRepository('UekMovieBundle:Movie')->findByGenre($genre);
    
    		return $this->render('UekMovieBundle:Movie:all.html.twig', array(
    				'movies' => $movies, 'filter_form' => $form->createView()));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('_all_movies'));
    	}
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
    public function watchMovieAction($id)
    {
    	$movie = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Movie')
    	->findOneById($id);
    	
    	if ($movie)
    	{
    		$movie->watched();
    		$this->getDoctrine()->getManager()->flush();
    		return $this->render('UekMovieBundle:Movie:watch.movie.html.twig', array('movie' => $movie));
    	}
    	else
    	{
    		return $this->redirect($this->generateUrl('_all_movies'));
    	}
    }
    
    /**
     * Handler filer form submit.
     *
     * @Route("/filter", name="_filter")
     *
     */
    public function filterMovieAction()
    {
    	$genre_helper = $this->getGenreHelper();
     	$form = $this->get('form.factory')->create(new MovieFilterType($genre_helper));
    	 
    	$genre = null;
    	
    	if ($this->get('request')->isMethod('POST')) 
    	{
    		$form->submit($this->get('request')->request->get($form->getName()));
    	
    		if ($form->isValid()) {
    		   	$genre_filter = $form->get('filter_by')->getData();
    			if ($genre_filter != -1)
    			{
    				$em = $this->getDoctrine()->getManager();
    				$genre = $em->getRepository('UekMovieBundle:Genre')->findOneById($genre_filter);
    			}
    		}
    	}
    	
    	$genre_helper->setFilterGenre($genre);
    	
    	return $this->redirect($this->generateUrl('_all_movies'));
    }

    /**
     * Handler sort form submit.
     *
     * @Route("/sort", name="_sort")
     *
     */
    public function sortMovieAction()
    {
    	$sort_helper = $this->getSortHelper();
    	$sort_form = $this->get('form.factory')->create(new MovieSortType($sort_helper));
    	 
    	$choice = SortHelper::SortByTitle;
   	
    	$sort = null;
    	 
    	if ($this->get('request')->isMethod('POST')) {
    		$sort_form->submit($this->get('request')->request->get($sort_form->getName()));
    		if ($sort_form->isValid()) {
    			$choice = $sort_form->get('sort_by')->getData();
    		}
    	}

    	$sort_helper->setCurrentChoice($choice);
   		return $this->redirect($this->generateUrl('_all_movies'));
    }

    
    protected function getSortHelper()
    {
    	$sort_helper = $this->get('uek.moviebundle.sort.helper');
    	return $sort_helper;
    }

    protected function getGenreHelper()
    {
  		$genre_helper = $this->get('uek.moviebundle.genre.helper');
    	return $genre_helper;
    }
}
