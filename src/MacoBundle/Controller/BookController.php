<?php

namespace MacoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MacoBundle\Entity\Books;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookController extends Controller
{
    public function indexAction($slug, Request $request)
    {
        $book = $this->getDoctrine()
            ->getRepository('MacoBundle:Books')
            ->findByTitle($slug);

        if (!$book){
            throw $this->createNotFoundException(
                'Nie ma książki o takim tytule.'
            );
        }

        $bookDelete = new Books();

        $form = $this->createFormBuilder($bookDelete)
            ->add('save', SubmitType::class, array('label' => 'Usuń'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getEntityManager();
            $repo = $em->getRepository('MacoBundle:Books');
            $bookToDelete = $repo->findOneBy(array('title' => $slug));
            $em->remove($bookToDelete);
            $em->flush();

            return $this->redirectToRoute('maco_homepage');
        }
        return $this->render('MacoBundle:Book:index.html.twig', array('book' => $book, 'form' => $form->createView()));
    }
}
