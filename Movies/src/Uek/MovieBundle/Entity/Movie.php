<?php
// src/Uek/MovieBundle/Entity/Movie.php
namespace Uek\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Uek\MovieBundle\Entity\Movie
 *
 * @ORM\Entity()
 * @ORM\Table(name="movies")* 
 *
 * @ORM\HasLifecycleCallbacks
 */
class Movie {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $coverArt;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $actors;
	public 

	function __construct() {
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
     * Set title
     *
     * @param string $title
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set actors
     *
     * @param string $actors
     * @return Movie
     */
    public function setActors($actors)
    {
        $this->actors = $actors;

        return $this;
    }

    /**
     * Get actors
     *
     * @return string 
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Set coverArt
     *
     * @param string $coverImageRef
     * @return Movie
     */
    public function setCoverArt($coverArt)
    {
        $this->coverArt = $coverArt;

        return $this;
    }

    /**
     * Get coverArt
     *
     * @return string 
     */
    public function getCoverArt()
    {
        return $this->coverArt;
    }
}
