<?php

namespace Uek\StoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StoreController extends Controller
{
	/**
	 * @Route("/orders/all")
	 */
	public function allOrdersAction()
    {
    	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    		return $this->render('UekStoreBundle:Store:please.login.html.twig');
    	}
    	
    	$orders = array();
        return $this->render('UekStoreBundle:Store:orders.html.twig', array('orders' => $orders));
    }
}
