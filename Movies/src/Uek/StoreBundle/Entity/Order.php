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
	 * @ORM\OneToOne(targetEntity="Uek\UserBundle\Entity\User", inversedBy="orders")
	 **/
	private $user;
	
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
}
