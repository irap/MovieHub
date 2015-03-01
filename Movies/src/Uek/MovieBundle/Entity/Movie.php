<?php
// src/Uek/MovieBundle/Entity/Movie.php
namespace Uek\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Uek\MovieBundle\Entity\Genre;

/**
 * Uek\MovieBundle\Entity\Movie
 *
 * @ORM\Entity(repositoryClass="Uek\MovieBundle\Entity\MovieRepository")
 * @ORM\Table(name="movies")
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
	protected $description;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $actors;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $coverArt;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $video;
	
    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="movies")
     **/	
	private $genres;

	/**
	 * @ORM\Column(type="integer", nullable=false, options={"default" = 0})
	 */
	protected $watchNumber = 0;
	
	/**
	 * @ORM\Column(type="integer", nullable=false, options={"default" = 0})
	 */
	protected $borrowNumber = 0;
	
	public function __construct() {
		$this->genres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param string $description
     * @return Movie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
     * @param string $coverArt
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

    /**
     * Set video
     *
     * @param string $video
     * @return Movie
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Add genre
     *
     * @param \Uek\MovieBundle\Entity\Genre $genre
     * @return Movie
     */
    public function addGenre(\Uek\MovieBundle\Entity\Genre $genre)
    {
    	$genre->addMovie($this);
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \Uek\MovieBundle\Entity\Genre $genre
     */
    public function removeGenre(\Uek\MovieBundle\Entity\Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenres()
    {
        return $this->genres;
    }
    
    /**
     * Get genres as string
     *
     * @return string
     */
    public function getGenresAsString()
    {
    	$genre_names = array();
    	foreach ($this->genres as $genre)
    	{
    		$genre_names[] = $genre->getName();
    	}
    	
    	return implode(", ", $genre_names);
    }
    
    /**
     * Add genres
     *
     * @param array of \Uek\MovieBundle\Entity\Genre $genres
     * @return Movie
     */
    public function addGenres($array_of_genres)
    {
    	foreach($array_of_genres as $genre)
    	{
    		$this->addGenre($genre);
    	}

        return $this;
    }

    /**
     * Called on watched movie
     */
    public function watched()
    {
    	$this->setWatchNumber($this->watchNumber + 1);
    }

    /**
     * Called on borrowed movie
     */
    public function borrowed()
    {
    	$this->setBorrowedNumber($this->borrowNumber + 1);
    }
    
    /**
     * Set watchNumber
     *
     * @param integer $watchNumber
     * @return Movie
     */
    public function setWatchNumber($watchNumber)
    {
        $this->watchNumber = $watchNumber;

        return $this;
    }

    /**
     * Get watchNumber
     *
     * @return integer 
     */
    public function getWatchNumber()
    {
        return $this->watchNumber;
    }

    /**
     * Set borrowNumber
     *
     * @param integer $borrowNumber
     * @return Movie
     */
    public function setBorrowNumber($borrowNumber)
    {
        $this->borrowNumber = $borrowNumber;

        return $this;
    }

    /**
     * Get borrowNumber
     *
     * @return integer 
     */
    public function getBorrowNumber()
    {
        return $this->borrowNumber;
    }
}
