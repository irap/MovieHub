<?php

namespace Uek\MovieBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Uek\MovieBundle\Entity;
use Uek\StoreBundle\Entity\OrderStatus;

/**
 * MovieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MovieRepository extends EntityRepository
{
	/**
	 * Find most borrowed movies.
	 * 
	 * @param number $count max count of the returned results.
	 * @return array of movies
	 */
	public function findMostBorrowed($count = 1)
	{
		$qb = $this->createQueryBuilder('m')
		->addSelect('COUNT(o.id) AS HIDDEN orderCount')
		->leftJoin('m.orders', 'o')
		->leftJoin('o.status', 'os')
		->groupBy('m')
		->having('orderCount > 0')
		->orderBy('orderCount', 'DESC')
		->where('os.id = ?1')
		->setMaxResults($count)
		->setParameter(1, OrderStatus::PAID);
		
		$moives = $qb->getQuery()->getResult();
		return $moives;
	}

	/**
	 * Find most reviewed movies.
	 * 
	 * @param number $count max count of the returned results.
	 * @return array of movies
	 */
	public function findMostReviewed($count = 1)
	{
		$qb = $this->createQueryBuilder('m')
		->addSelect('COUNT(r.id) AS HIDDEN reviewCount')
		->leftJoin('m.reviews', 'r')
		->groupBy('m')
		->having('reviewCount > 0')
		->orderBy('reviewCount', 'DESC')
		->setMaxResults($count);

		$moives = $qb->getQuery()->getResult();
		return $moives;
	}

	/**
	 * Find movies of the specified genre.
	 * @param Genre genre 
	 * @return array of movies
	 */
	public function findByGenre(Genre $genre)
	{
		return $genre->getMovies();
	}

	/**
	 * Find movies borrowed by a user.
	 * 
	 * @param User user
	 * @return array of movies
	 */
	public function findBorrowedByUser($user)
	{
		$qb = $this->createQueryBuilder('m')
		->addSelect('COUNT(o.id) AS HIDDEN orderCount')
		->leftJoin('m.orders', 'o')
		->leftJoin('o.user', 'u')
		->leftJoin('o.status', 'os')
		->groupBy('m')
		->having('orderCount > 0')
		->where('u.id = :user_id')
		->andwhere('os.id = :paid_id')
		->setParameters(array('user_id' => $user->getId(), 'paid_id' =>OrderStatus::PAID));
		
		$moives = $qb->getQuery()->getResult();
		return $moives;
	}

	/**
	 * Find movies borrowed by a user and filtered by genre
	 * 
	 * @param User user
	 * @param Genre genre
	 * @return array of movies
	 */
	public function findBorrowedByUserFilteredByGenre($user, $genre)
	{
		$qb = $this->createQueryBuilder('m')
		->addSelect('COUNT(o.id) AS HIDDEN orderCount')
		->leftJoin('m.orders', 'o')
		->leftJoin('o.user', 'u')
		->leftJoin('m.genres', 'g')
		->leftJoin('o.status', 'os')
		->groupBy('m')
		->having('orderCount > 0')
		->where('u.id = :user_id')
		->andwhere('g.id = :genre_id')
		->andWhere('os.id = :paid_id')
		->setParameter('user_id', $user->getId())
		->setParameter('paid_id', OrderStatus::PAID)
		->setParameter('genre_id', $genre->getId());
		
		$moives = $qb->getQuery()->getResult();
		return $moives;
	}
}
