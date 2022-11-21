<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Messagerie;
use App\Form\MessagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagerieController extends AbstractController
{
    /**
     * @Route("/messagerie", name="messagerie")
     */
    public function index(): Response
    {
        return $this->render('messagerie/index.html.twig', [
            'controller_name' => 'MessagerieController',
        ]);
    }

    /**
     * @Route ("/send" , name="send")
     */
    public function send(Request $request): Response
    {
        $message = new Messagerie();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message successfully sent");
            return $this->redirectToRoute("messagerie");
        }
        return $this->render("messagerie/send.html.twig", ["form" => $form->createView()]);

    }

    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        return $this->render('messagerie/received.html.twig', [
        ]);
    }

    /**
     * @Route("/sent", name="sent")
     */
    public function sent(): Response
    {
        return $this->render('messagerie/sent.html.twig', [
        ]);
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Messagerie $message): Response
    {
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('messagerie/read.html.twig',compact('message')
        );
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Messagerie $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("received");
    }
}
