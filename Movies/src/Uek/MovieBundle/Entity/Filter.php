<?php
// src/Uek/MovieBundle/Entity/Movie.php
namespace Uek\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Uek\MovieBundle\Entity\Movie;

/**
 * This is a service table to store the filtering and sorting settings
 *
 * @ORM\Entity()
 * @ORM\Table(name="filter")* 
 *
 * @ORM\HasLifecycleCallbacks
 */
class Filter {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $filter_genre;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $sort_item;
	
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
     * Set filter_genre
     *
     * @param string $filterGenre
     * @return Filter
     */
    public function setFilterGenre($filterGenre)
    {
        $this->filter_genre = $filterGenre;

        return $this;
    }

    /**
     * Get filter_genre
     *
     * @return string 
     */
    public function getFilterGenre()
    {
        return $this->filter_genre;
    }

    /**
     * Set sort_item
     *
     * @param integer $sortItem
     * @return Filter
     */
    public function setSortItem($sortItem)
    {
        $this->sort_item = $sortItem;

        return $this;
    }

    /**
     * Get sort_item
     *
     * @return integer 
     */
    public function getSortItem()
    {
        return $this->sort_item;
    }
}
