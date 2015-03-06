<?php

namespace Uek\StoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\StoreBundle\Entity\OrderStatus;
use Uek\StoreBundle\Entity\Order;

class StoreController extends Controller
{

	/**
	 * @Route("/store/order/all", name="uek_store_show_all_orders")
	 */
	public function showAllOrdersAction()
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->render('UekUserBundle:Security:please.login.html.twig');
		}
		 
		$user= $this->get('security.context')->getToken()->getUser();
		$em = $this->getDoctrine()->getManager();
		$orders = $em->getRepository('UekStoreBundle:Order')->findByUser($user);
		 
		return $this->render('UekStoreBundle:Store:orders.html.twig', array('orders' => $orders));
	}
	
	/**
	 * @Route("/store/order/movie/{id}", name="uek_order_movie")
	 */
	public function orderMovieAction($id)
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->render('UekUserBundle:Security:please.login.html.twig');
		}
		 
		$em = $this->getDoctrine()->getManager();
		$user = $this->get('security.token_storage')->getToken()->getUser();
		 
		$movie = $this->getDoctrine()
		->getRepository('UekMovieBundle:Movie')
		->findOneById($id);
	
		$status_in_progress = $this->getDoctrine()
		->getRepository('UekStoreBundle:OrderStatus')
		->findOneById(OrderStatus::IN_PROGRESS);
		 
		$status_paid = $this->getDoctrine()
		->getRepository('UekStoreBundle:OrderStatus')
		->findOneById(OrderStatus::PAID);
	
		if ($movie)
		{
			$order = new Order();
			$order->setUser ( $user );
			$order->addMovie ( $movie );
			$order->setStatus ( $status_in_progress );
	
			$form = $this->createFormBuilder($order)
			->add('confirm', 'submit', array('label' => 'Confirm'))
			->add('cancel', 'submit', array('label' => 'Cancel'))
			->getForm();
	
			$form->handleRequest($this->getRequest());
	
			if ($form->isValid()) {
				// perform some action, such as saving the task to the database
				 
				if ($form->get('confirm')->isClicked())
				{

					// Simulate rundom time order processing for debug purposes
					if (rand(0,1))
					{
						$order->setStatus ( $status_paid );
					}
					
					$em->persist ( $order );
					$em->flush();
	
					return $this->redirect($this->generateUrl('uek_confirmed_order', ['id' => $order->getId()]));
 				}
	
				// cancel otherwise
				return $this->redirect($this->generateUrl('uek_movie', ['id' => $movie->getId()]));
			}
	
			return $this->render('UekStoreBundle:Store:borrow.movie.html.twig',
					array('movie' => $movie, 'order' => $order, 'form' => $form->createView()));
		}
		else
		{
			return $this->redirect($this->generateUrl('uek_homepage'));
		}
	}
	
	
	/**
	 * @Route("/store/order/{id}/confirmed", name="_confirmed_order")
	 */
	public function confirmedOrderAction($id)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    		return $this->render('UekUserBundle:Security:please.login.html.twig');
    	}
    	
//     	$user= $this->get('security.context')->getToken()->getUser();
    	$em = $this->getDoctrine()->getManager();
    	$order = $em->getRepository('UekStoreBundle:Order')->findOneById($id);
    	
    	$orderInfo = 'Order number: ' . $order->getId() .PHP_EOL;
    	$orderInfo = $orderInfo . 'Total sum: $' . $order->getTotalSum() . PHP_EOL;
    	 
    	return $this->render('UekStoreBundle:Store:confirmed.order.html.twig', 
    			array('order' => $order, 'order_information' =>$orderInfo));
    }
}
