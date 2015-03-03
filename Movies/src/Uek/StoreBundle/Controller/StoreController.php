<?php

namespace Uek\StoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StoreController extends Controller
{
	/**
	 * @Route("/orders/all")
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
}
