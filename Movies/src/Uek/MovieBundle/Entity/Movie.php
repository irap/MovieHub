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
	 * @ORM\ManyToMany(targetEntity="Genre", mappedBy="movies")
	 **/
	protected $genres;
	
	/**
	 * @ORM\Column(type="float", precision=4, scale=2, nullable=false, options={"unsigned":true, "default":0})
	 */
	protected $price;
	
    /**
     * @ORM\ManyToMany(targetEntity="Uek\StoreBundle\Entity\Order", inversedBy="movies")
     **/	
	protected $orders;

	/**
	 * @ORM\OneToMany(targetEntity="Review", mappedBy="movie")
	 **/
	private $reviews;
	
	public function __construct() {
		$this->orders = new \Doctrine\Common\Collections\ArrayCollection();
		$this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
		$this->genres = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function getGenresNames()
	{
		$gnames = array();
		foreach ($this->genres as $genre)
		{
			$gnames[] = $genre->getName();
		}
		return implode(", ", $gnames);
	}
	
	public function isOrderedByUser($user)
	{
		foreach($this->orders as $order)
		{
			if ($order->getUser() == $user)
			{
				return true;
			}
		}
		
		return false;
	}

	public function isPaidByUser($user)
	{
		$paid_orders = $this->getPaidOrders();
		foreach($paid_orders as $order)
		{
			if ($order->getUser() == $user)
			{
				return true;
			}
		}
	
		return false;
	}
	
	public function getPaidOrders()
	{
		$paid_orders = array();
		foreach($this->orders as $order)
		{
			if ($order->isPaid())
			{
				$paid_orders[] = $order;
			}
		}
	
		return $paid_orders;
	}
	
	public function getReviewNumber()
	{
		return $this->reviews->count();
	}

	public function getOrderNumber()
	{
		return $this->orders->count();
	}

	public function getPaidOrderNumber()
	{
		return count($this->getPaidOrders());
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
     * @param \Uek\MovieBundle\Entity\Review $review
     * @return Movie
     */
    public function addReview(\Uek\MovieBundle\Entity\Review $review)
    {
        $this->reviews[] = $review;
        return $this;
    }

    /**
     * Remove reviews
     *
     * @param \Uek\MovieBundle\Entity\Review $review
     */
    public function removeReview(\Uek\MovieBundle\Entity\Review $review)
    {
        $this->reviews->removeElement($review);
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
    

    /**
     * Set price
     *
     * @param \float $price
     * @return Movie
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return \float 
     */
    public function getPrice()
    {
        return $this->price;
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
        $genres->addMovie($this);
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
        $genres->removeMovie($this);
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
}
