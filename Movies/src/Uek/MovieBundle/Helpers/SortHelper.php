<?php

namespace Uek\MovieBundle\Helpers;

use Doctrine\ORM\EntityManager;
use Uek\MovieBundle\Entity\Genre;
use Uek\MovieBundle\Entity\Movie;
use Uek\MovieBundle\Helpers\GenreHelper;

class SortHelper 
{
	const SortByTitle = 0;
    const SortByMostWatchNumber = 1;
	const SortByMostBorrowNumber = 2;
	
	protected $em;
	protected $choices;
	protected $lables;

	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		$this->em = $em;
		$this->choices = [SortHelper::SortByTitle, SortHelper::SortByMostWatchNumber, SortHelper::SortByMostBorrowNumber];
		$this->lables = ['Title', 'Most Watched', 'Most Borrowed'];
	}
	
   public function getChoices()
   {
   		return $this->choices;
   }

   public function getLables()
   {
   	return $this->lables;
   }

   public function getCurrentChoice()
   {
		$em = $this->em;
		$filter = $em->getRepository('UekMovieBundle:Filter')->findOneById(1);
		if ($filter != null)
		{
			return $filter->getSortItem();
		}
		
		return SortHelper::SortByTitle;
   }
   
   public function setCurrentChoice($choice)
   {
   	 	$em = $this->em;
		$filter = $em->getRepository('UekMovieBundle:Filter')->findOneById(1);
		if ($filter == null)
		{
			$filter = new Filter();
			$em->persist($filter);
		}
		
		$filter->setSortItem($choice);
		$em->flush();
   }
    
}
