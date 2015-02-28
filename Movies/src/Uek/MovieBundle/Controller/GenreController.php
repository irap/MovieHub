<?php

namespace Uek\MovieBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Entity\Movie;
use Uek\MovieBundle\Entity\Genre;

// /**
//  * @Route("/genres")
//  */
class GenreController extends Controller
{
	/**
	 * @Route("/genre/create/{name}")
	 */
	public function createGenreAction($name)
	{
		$em = $this->getDoctrine()->getManager();
		
		// check for duplicates
		$genre = $em->getRepository('UekMovieBundle:Genre')->findOneByName($name);
		if (!$genre) 
		{
			$genre = new Genre();
			$genre->setName($name);
			$em->persist($genre);
			$em->flush();
		}
		
		return $this->render('UekMovieBundle:Genre:genre.html.twig', array('genre' => $genre));
	}

	/**
	 * @Route("/all")
	 */
    public function allAction()
    {
    	$genres = $this->getDoctrine()
    				->getRepository('UekMovieBundle:Genre')
    				->findAll();
        return $this->render('UekMovieBundle:Genre:all.html.twig', array('genres' => $genres));
    }

    /**
     * @Route("/genre/{id}")
     */
    public function genreAction($id)
    {
    	$genre = $this->getDoctrine()
    	->getRepository('UekMovieBundle:Genre')
    	->findOneById($id);
    	return $this->render('UekMovieBundle:Genre:genre.html.twig', array('genre' => $genre));
    }

}
