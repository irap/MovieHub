<?php
// src/Uek/MovieBundle/Entity/Movie.php
namespace Uek\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Uek\MovieBundle\Entity\Genre;

/**
 * Uek\MovieBundle\Entity\Movie
 *
 * @ORM\Entity()
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
	 * @ORM\ManyToMany(targetEntity="Genre")
	 * @ORM\JoinTable(name="movies_genres",
	 *      joinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $genres;
	
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
     * Add genres
     *
     * @param \Uek\MovieBundle\Entity\Genre $genres
     * @return Movie
     */
    public function addGenre(\Uek\MovieBundle\Entity\Genre $genres)
    {
        $this->genres[] = $genres;

        return $this;
    }

    /**
     * Remove genres
     *
     * @param \Uek\MovieBundle\Entity\Genre $genres
     */
    public function removeGenre(\Uek\MovieBundle\Entity\Genre $genres)
    {
        $this->genres->removeElement($genres);
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
}
