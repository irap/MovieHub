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
	 * @ORM\ManyToOne(targetEntity="Uek\UserBundle\Entity\User", inversedBy="orders")
	 **/
	private $user;

	/**
	 * @ORM\ManyToMany(targetEntity="Uek\MovieBundle\Entity\Movie", inversedBy="orders")
	 **/
	private $movies;
	
	
	function __construct() {
	}

	/**
	 * @ORM\PrePersist
	 */
	public function setCreatedAtValue()
	{
		$this->createdAt = new \DateTime();
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
     * @param \Uek\StoreBundle\Entity\User $user
     * @return Order
     */
    public function setUser(\Uek\StoreBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Uek\StoreBundle\Entity\User 
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
     * @param \Uek\UserBundle\Entity\Movie $movies
     * @return Order
     */
    public function addMovie(\Uek\UserBundle\Entity\Movie $movies)
    {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Uek\UserBundle\Entity\Movie $movies
     */
    public function removeMovie(\Uek\UserBundle\Entity\Movie $movies)
    {
        $this->movies->removeElement($movies);
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
