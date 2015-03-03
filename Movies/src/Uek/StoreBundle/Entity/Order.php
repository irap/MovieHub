<?php
// src/Uek/StoreBundle/Entity/Order.php
namespace Uek\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Uek\StoreBundle\Entity\Order
 *
 * @ORM\Entity(repositoryClass="Uek\StoreBundle\Entity\OrderRepository")
 * @ORM\Table(name="orders")* 
 *
 * @ORM\HasLifecycleCallbacks
 */
class Order {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
 	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="date")
	 */
	private $createdAt;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Uek\UserBundle\Entity\User", inversedBy="orders", cascade={"persist", "remove"})
	 **/
	private $user;

	/**
	 * @ORM\ManyToMany(targetEntity="Uek\MovieBundle\Entity\Movie", mappedBy="orders")
	 **/
	private $movies;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Uek\StoreBundle\Entity\OrderStatus", inversedBy="orders")
	 **/
	private $status;
	
	
	function __construct() {
	}

	/**
	 * @ORM\PrePersist
	 */
	public function setCreatedAtValue()
	{
		$this->createdAt = new \DateTime('NOW');
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
     * Set user
     *
     * @param \Uek\UserBundle\Entity\User $user
     * @return Order
     */
    public function setUser(\Uek\UserBundle\Entity\User $user)
    {
        $this->user = $user;
        $user->addOrder($this);

        return $this;
    }

    /**
     * Get user
     *
     * @return \Uek\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Order
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add movies
     *
     * @param \Uek\MovieBundle\Entity\Movie $movie
     * @return Order
     */
    public function addMovie(\Uek\MovieBundle\Entity\Movie $movie)
    {
        $this->movies[] = $movie;
        $movie->addOrder($this);

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Uek\MovieBundle\Entity\Movie $movie
     */
    public function removeMovie(\Uek\MovieBundle\Entity\Movie $movie)
    {
        $this->movies->removeElement($movies);
        $movie->removeOrder($this);
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

    /**
     * Set status
     *
     * @param \Uek\StoreBundle\Entity\OrderStatus $status
     * @return Order
     */
    public function setStatus(\Uek\StoreBundle\Entity\OrderStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Uek\StoreBundle\Entity\OrderStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
