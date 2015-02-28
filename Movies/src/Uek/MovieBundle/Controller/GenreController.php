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
		$ganre_service = $this->get('uek.moviebundle.genre.helper');
		$genre = $ganre_service->createGenre($name);
		
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
