<?php

namespace Uek\MovieBundle\Helpers;

use Doctrine\ORM\EntityManager;
use Uek\MovieBundle\Entity\Genre;

class GenreHelper
{
	/**
	 * Entity manager
	 * @var EntityManager
	 */
	protected $em;
	
	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Create or find genre by the given genre name
	 * @retrun Genre object
	 */
	public function createGenre($name)
	{
		$em = $this->em;
		// check for duplicates
		$genre = $em->getRepository('UekMovieBundle:Genre')->findOneByName($name);
		if (!$genre) 
		{
			$genre = new Genre();
			$genre->setName($name);
			$em->persist($genre);
			$em->flush();
		}
		
		return $genre;
	}

	/**
	 * Create or find genrea by their names
	 * @retrun array of Genre objects
	 */
	public function createGenres($ganre_names)
	{
		$genres = array();
		foreach($ganre_names as $gname)
		{
			$genres[] = $this->createGenre($gname);
		}
		
		return $genres;
	}
	
	/**
	 * Get all genres currently defined in our db
	 * @retrun array of Genre objects
	 */
	public function getGenres()
	{
		$em = $this->em;
		$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
		return $genres;
	}
}
