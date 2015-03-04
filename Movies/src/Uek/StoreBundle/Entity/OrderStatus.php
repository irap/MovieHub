<?php
// src/Uek/StoreBundle/Entity/OrderStatus.php
namespace Uek\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Uek\StoreBundle\Entity\OrderStatus
 *
 * @ORM\Entity()
 * @ORM\Table(name="orderstatuses")* 
 *
 * @ORM\HasLifecycleCallbacks
 */
class OrderStatus {
	
	const IN_PROGRESS = 1;
	const PAID = 2;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 */
	//@ORM\GeneratedValue(strategy="AUTO")
	protected $id;

	/**
	 * @ORM\Column(type="string", nullable=false, unique=true)
	 */
	private $name;
	
	/**
	 * @ORM\OneToMany(targetEntity="Uek\StoreBundle\Entity\Order", mappedBy="status")
	 **/
	private $orders;

	function __construct() {
		$this->orders = new \Doctrine\Common\Collections\ArrayCollection();
	}

    /**
     * Set id
     *
     * @param integer $id
     * @return OrderStatus
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set name
     *
     * @param string $name
     * @return OrderStatus
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

    /**
     * Add orders
     *
     * @param \Uek\StoreBundle\Entity\Order $orders
     * @return OrderStatus
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
}
