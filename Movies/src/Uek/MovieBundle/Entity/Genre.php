<?php
// src/Uek/MovieBundle/Entity/Movie.php
namespace Uek\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Uek\MovieBundle\Entity\Movie;

/**
 * Uek\MovieBundle\Entity\Movie
 *
 * @ORM\Entity()
 * @ORM\Table(name="genres")* 
 *
 * @ORM\HasLifecycleCallbacks
 */
class Genre {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", nullable=false, unique=true)
	 */
	protected $name;
	
	/**
	 * Inverse Side
	 *
	 * @ORM\ManyToMany(targetEntity="Movie", mappedBy="genres")
	 */
	private $movies;
	
    public  function __construct() {
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Genre
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Remove movie
     *
     * @param \Uek\MovieBundle\Entity\Movies $movie
     */
    public function removeMovie(\Uek\MovieBundle\Entity\Movie $movie)
    {
        $this->movies->removeElement($movie);
    }

    /**
     * Add movie
     *
     * @param \Uek\MovieBundle\Entity\Movie $movie
     * @return Genre
     */
    public function addMovie(\Uek\MovieBundle\Entity\Movie $movie)
    {
        $this->movies[] = $movie;

        return $this;
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies()
    {
        return $this->movies;
    }
}
