<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Entity\Phone;
use AppBundle\Form\PersonType;
use AppBundle\Form\PhoneType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class,$person);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return new Response('Success');
        }


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/phone/{personId}", name="phone")
     */
    public function phoneAction($personId, Request $request) {
        $person = $this->getDoctrine()->getRepository('AppBundle:Person')
            ->find($personId);

        if(!$person) {
            throw new NotFoundHttpException;
        }

        $phone = new Phone();
        $form = $this->createForm(PhoneType::class,$phone);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $phone->setPerson($person);
            $em->persist($phone);
            $em->flush();

            return new Response('Success');
        }

        return $this->render(':default:index.html.twig',[
            'form'=>$form->createView()
        ]);

    }
}
