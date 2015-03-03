<?php
namespace Uek\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Uek\MovieBundle\Entity\ReviewRepository")
 * @ORM\Table(name="reviews")* 
 *
 * @ORM\HasLifecycleCallbacks
 */
class Review {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected $reviewText;
	
	/**
	 * Inverse Side
	 *
	 * @ORM\ManyToOne(targetEntity="Movie", inversedBy="reviews")
	 */
	private $movie;
	
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
     * Set reviewText
     *
     * @param string $reviewText
     * @return Review
     */
    public function setReviewText($reviewText)
    {
        $this->reviewText = $reviewText;

        return $this;
    }

    /**
     * Get reviewText
     *
     * @return string 
     */
    public function getReviewText()
    {
        return $this->reviewText;
    }

    /**
     * Set movie
     *
     * @param \Uek\MovieBundle\Entity\Movie $movie
     * @return Review
     */
    public function setMovie(\Uek\MovieBundle\Entity\Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return \Uek\MovieBundle\Entity\Movie 
     */
    public function getMovie()
    {
        return $this->movie;
    }
}
