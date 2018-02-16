<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrdersListController extends Controller
{
    /**
     * @Route("/orderslist", name="orders")
     */
    public function ordersListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $queryBuilder = $em->getRepository('AppBundle:Order')->createQueryBuilder('orders');

        if($request->query->getAlnum('filter')){
        $queryBuilder->where('orders.firstName LIKE :firstName')
            ->setParameter('firstName', '%'.$request->query->getAlnum('filter').'%');
        }

        $query = $queryBuilder->getQuery();


        // $dql = "SELECT orders FROM AppBundle:Order orders";
        // $query = $em->createQuery($dql);

        /**
        *  @var $paginator \Knp\Component\Pager\Paginator
        */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        dump(get_class($paginator));

        return $this->render('orders_list/index.html.twig', array('orders' => $result));
    }
    
}
