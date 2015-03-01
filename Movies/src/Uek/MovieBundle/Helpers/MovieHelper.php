<?php

namespace Uek\MovieBundle\Helpers;

use Doctrine\ORM\EntityManager;
use Uek\MovieBundle\Entity\Genre;
use Uek\MovieBundle\Entity\Movie;
use Uek\MovieBundle\Helpers\GenreHelper;

class MovieHelper
{
	/**
	 * Entity manager
	 * @var EntityManager
	 */
	protected $em;
	
	protected $genre_helper;
	
	public function __construct(\Doctrine\ORM\EntityManager $em, \Uek\MovieBundle\Helpers\GenreHelper $gh)
	{
		$this->em = $em;
		$this->genre_helper = $gh;
	}
	
	/**
	 * Create a new movie. If movie with the same name is found,
	 * it is updated with the new values
	 * @retrun Movie object
	 */
	public function createMovie($params)
	{
		list($title, $genres_name, $description, $actors, $coverArt, $video) = $params;
		
		$em = $this->em;

		$movie = new Movie();
		$movie->setTitle($title);
		$movie->setDescription($description);
		$movie->setActors($actors);
		$movie->setCoverArt($coverArt);
		$movie->setVideo($video);
			
		$genres = $this->genre_helper->createGenres($genres_name);
		$movie->addGenres($genres);

		$em->persist($movie);
		$em->flush();
	}

	/**
	 * Get all movies currently defined in our db
	 * @retrun array of Movie objects
	 */
	public function getMovies()
	{
		$em = $this->em;
		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		return $movies;
	}
}
