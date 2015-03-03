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
	protected $videoUri;
	
    /**
     * @ORM\ManyToMany(targetEntity="Uek\StoreBundle\Entity\Order", mappedBy="movies")
     **/	
	protected $orders;

	/**
	 * @ORM\OneToMany(targetEntity="Review", mappedBy="movie")
	 **/
	private $reviews;
	
	public function __construct() {
		$this->orders = new \Doctrine\Common\Collections\ArrayCollection();
		$this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function getReviewNumber()
	{
		return $this->reviews->count();
	}

	public function getOrderNumber()
	{
		return $this->orders->count();
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
     * Set videoUri
     *
     * @param string $videoUri
     * @return Movie
     */
    public function setVideoUri($videoUri)
    {
        $this->videoUri = $videoUri;

        return $this;
    }

    /**
     * Get videoUri
     *
     * @return string 
     */
    public function getVideoUri()
    {
        return $this->videoUri;
    }

    /**
     * Add orders
     *
     * @param \Uek\StoreBundle\Entity\Order $orders
     * @return Movie
     */
    public function addOrder(\Uek\StoreBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \Uek\StoreBundle\Entity\Order $orders
     */
    public function removeOrder(\Uek\StoreBundle\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add reviews
     *
     * @param \Uek\MovieBundle\Entity\Review $reviews
     * @return Movie
     */
    public function addReview(\Uek\MovieBundle\Entity\Review $reviews)
    {
        $this->reviews[] = $reviews;

        return $this;
    }

    /**
     * Remove reviews
     *
     * @param \Uek\MovieBundle\Entity\Review $reviews
     */
    public function removeReview(\Uek\MovieBundle\Entity\Review $reviews)
    {
        $this->reviews->removeElement($reviews);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReviews()
    {
        return $this->reviews;
    }
    
}
