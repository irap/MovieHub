<?php
// src/Uek/StoreBundle/Entity/Order.php
namespace Uek\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Uek\StoreBundle\Entity\Order
 *
 * @ORM\Entity()
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
	
	function __construct() {
	}
}
