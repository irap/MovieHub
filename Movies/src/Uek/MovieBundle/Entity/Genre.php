<?php
namespace Uek\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Uek\MovieBundle\Entity\GenreRepository")
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
	 *
	 * @ORM\ManyToMany(targetEntity="Movie", inversedBy="genres")
	 */
	private $movies;

    public  function __construct() {
    	$this->movies = new \Doctrine\Common\Collections\ArrayCollection();
    	 
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
     * Remove movie
     *
     * @param \Uek\MovieBundle\Entity\Movie $movie
     */
    public function removeMovie(\Uek\MovieBundle\Entity\Movie $movie)
    {
        $this->movies->removeElement($movie);
    }

    /**
     * Get movie
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies()
    {
        return $this->movies;
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
}
