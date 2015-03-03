<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Entity\Review;
use Uek\MovieBundle\Entity\Movie;
use Uek\UserBundle\Entity\User;
use Uek\StoreBundle\Entity\Order;
use Uek\StoreBundle\Entity\OrderStatus;
use Doctrine\DBAL\Types\DecimalType;


// /**
//  * @Route("/demo")
//  */
class DemoController extends Controller
{
	/**
	 * @Route("/create", name="_create_demo")
	 */
	public function createDemoAction()
	{
		// First, reset the previous demo movies
		$this->resetDemoAction();
		
		$this->createOrderStatusesAction();
		
		// Second, add new ones
		$demo_list = [
			['These Final Hours',
			 'A self-obsessed young man makes his way to the party-to-end-all-parties on the last day on Earth, but ends up saving the life of a little girl searching for her father. Their relationship ultimately leads him on the path to redemption.',
			 'Sarah Snook, Jessica De Gouw, Nathan Phillips',
			 'http://static.hd-trailers.net/images/these-final-hours-122456-poster-xlarge-resized.jpg',
			 'http://www.imdb.com/video/imdb/vi1426370073/imdb/embed?autoplay=false&width=480',
			  '15.2',		
			],

			['Unfinished Business',
			 'A hard-working small business owner and his two associates travel to Europe to close the most important deal of their lives. But what began as a routine business trip goes off the rails in every way imaginable - and unimaginable - way, including unplanned stops at a massive sex fetish event and a global economic summit.',
			 'Vince Vaughn, Dave Franco, Tom Wilkinson',
			 'http://ia.media-imdb.com/images/M/MV5BNjg5NzU5ODE5OV5BMl5BanBnXkFtZTgwMjM1MjE2NDE@._V1_SY317_CR0,0,214,317_AL_.jpg',
			 'http://www.imdb.com/video/imdb/vi1415687705/imdb/embed?autoplay=false&width=480',
			  '11.4',		
			],
		];

		$em = $this->getDoctrine()->getManager();
		foreach ($demo_list as list($title, $description, $actors, $coverArt, $videoUri, $price)) 
		{
			$movie = new Movie();
			$movie->setTitle($title);
			$movie->setDescription($description);
			$movie->setActors($actors);
			$movie->setCoverArt($coverArt);
			$movie->setVideoUri($videoUri);
			$movie->setPrice((float)$price);
				
			$em->persist($movie);
		}

		$em->flush();
		
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
		{
			$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
			foreach ($movies as $movie)
			{
				$this->addReviewAction(rand(1, 10), $movie->getId());
				$this->addOrderAction(rand(1, 10), $movie->getId());
			}
		}
		
		return $this->redirect($this->generateUrl('_homepage'));
	}

	/**
	 * @Route("/reset", name="_reset_demo")
	 */
	public function resetDemoAction()
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->render('UekUserBundle:Security:please.login.html.twig');
		}
		
		$em = $this->getDoctrine()->getManager();

		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		foreach ($movies as $movie) {
			$em->remove($movie);
		}

		$reviews = $em->getRepository('UekMovieBundle:Review')->findAll();
		foreach ($reviews as $review) {
			$em->remove($review);
		}

		$orders = $em->getRepository('UekStoreBundle:Order')->findAll();
		foreach ($orders as $order) {
			$em->remove($order);
		}
		
		$em->flush();

		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		return $this->redirect($this->generateUrl('_homepage'));
	}

	/**
	 * @Route("/add/review/{count}/to/movie/{id}", name="_add_demo_review")
	 */
	public function addReviewAction($count, $id)
	{
	    if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    		return $this->render('UekUserBundle:Security:please.login.html.twig');
    	}
    	$username= $this->get('security.context')->getToken()->getUser();
    	
    	$em = $this->getDoctrine()->getManager();
    	$user = $em->getRepository('UekUserBundle:User')->findOneByUsername($username);
    	$movie = $em->getRepository('UekMovieBundle:Movie')->findOneById($id);
     	if ($user != null && $movie != null)
     	{
     		for ($i=0; $i < $count; ++$i)
     		{
    			$review = new Review();
    			$review->setReviewText("This is a review #" . $review->getId() ."for " . $movie->getTitle());
    				
				$review->setUser($user);
				$review->setMovie($movie);
    			$em->persist($review);
     		}
    		
     		$em->flush();

     		return $this->redirect($this->generateUrl('_movie', array('id' => $movie->getId())));
     	}
    	
    	return $this->redirect($this->generateUrl('_homepage'));
	}    	 

	/**
	 * @Route("/add/order/{count}/to/movie/{id}", name="_add_demo_order")
	 */
	public function addOrderAction($count, $id)
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->render('UekUserBundle:Security:please.login.html.twig');
		}
		$username= $this->get('security.context')->getToken()->getUser();
	
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('UekUserBundle:User')->findOneByUsername($username);
		$movie = $em->getRepository('UekMovieBundle:Movie')->findOneById($id);
		if ($user != null && $movie != null)
		{
			$in_progress = $em->getRepository('UekStoreBundle:OrderStatus')->findOneById(OrderStatus::IN_PROGRESS);
			
			for ($i=0; $i < $count; ++$i)
			{
				$order = new Order();
				$order->setStatus($in_progress);
				$em->persist($order);
	
				$order->setUser($user);
				$order->addMovie($movie);
			}
	
			$em->flush();
	
    		return $this->redirect($this->generateUrl('_movie', array('id' => $movie->getId())));
		}
		 
		return $this->redirect($this->generateUrl('_homepage'));
	}
	
	
	/**
	 * @Route("/create/order_statuses", name="_create_demo_order_statuses")
	 */
	
	public function createOrderStatusesAction()
	{
		$em = $this->getDoctrine()->getManager();
		$ostatuses = $em->getRepository('UekStoreBundle:OrderStatus')->findAll();
		if (count($ostatuses) == 0)
		{
			$status_list = [
					['id' => OrderStatus::IN_PROGRESS, 'name' => 'In progress'],
					['id' => OrderStatus::PAID, 'name' => 'Paid']	];
			
			foreach ($status_list as $status)
			{
				$ostatus = new OrderStatus();
				$ostatus->setId($status['id']);
				$ostatus->setName($status['name']);
				$em->persist($ostatus);
			}
			
			$em->flush();
		}
		
		return $this->redirect($this->generateUrl('_homepage'));
	}
}
