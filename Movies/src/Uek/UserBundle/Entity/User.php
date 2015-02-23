<?php
// src/Uek/UserBundle/Entity/User.php
namespace Uek\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Uek\UserBundle\Entity\User
 * 
 * @ORM\Entity
 * @ORM\Table(name="uek_user")* 
 * 
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="usernameCanonical", errorPath="username", message="fos_user.username.already_used", groups={"Registration", "Profile"})
 * @UniqueEntity(fields="emailCanonical", errorPath="email", message="fos_user.email.already_used", groups={"Registration", "Profile"})
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	public 
function __construct() {
	parent::__construct ();
}

	/**
	 *
	 * @see \Serializable::serialize()
	 */
	public function serialize() {
		return serialize (array(
			'id' => $this->id,
			'parentData' => parent::serialize()	)
		 );
	}

	/**
	 *
	 * @see \Serializable::unserialize()
	 */
	public function unserialize($serialized) {
		$data = unserialize($serialized);
		$this->id = $data['id'];
		parent::unserialize($data['parentData']);
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
}
