<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="info")
     */
    public function productAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('product/index.html.twig');
    }
    
    /**
     * @Route("/product/order", name="order")
     */
    public function orderAction(Request $request)
    {
        $order = new Order;
        
        $form = $this->createFormBuilder($order)
            -> add('firstname', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'marign-bottom:15px'), 'label' => 'Vardas'))
            -> add('lastname', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'marign-bottom:15px' ), 'label' => 'Pavarde'))
            -> add('email', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'marign-bottom:15px' ), 'label' => 'E. paštas'))
            -> add('address', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'marign-bottom:15px' ), 'label' => 'Adresas'))
            -> add('phone', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'marign-bottom:15px' ), 'label' => 'Tel. numeris'))
            -> add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top:15px'), 'label' => 'Užsakyti'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $firstname = $form['firstname']->getData();
            $lastname = $form['lastname']->getData();
            $email = $form['email']->getData();
            $address = $form['address']->getData();
            $phone = $form['phone']->getData();
            $now = new\DateTime('now');

            $order->setDate($now);
            $order->setFirstName($firstname);
            $order->setLastName($lastname);
            $order->setEmail($email);
            $order->setAddress($address);
            $order->setPhone($phone);

            $em = $this->getDoctrine()->getManager();

            $em->persist($order);
            $em->flush();

            $this -> addFlash(
                'notice',
                'Užsakymas atliktas!'
            );

            return $this->redirectToRoute('info');
        }

        // replace this example code with whatever you need
        return $this->render('product/order.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
