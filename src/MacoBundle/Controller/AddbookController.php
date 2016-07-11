<?php

namespace MacoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MacoBundle\Entity\Books;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddbookController extends Controller
{
    public function indexAction(Request $request)
    {
        $book = new Books();

        $form = $this->createFormBuilder($book)
            ->add('title', TextType::class, array('label' => 'Tytuł'))
            ->add('author', TextType::class, array('label' => 'Autor'))
            ->add('quantity', IntegerType::class, array('label' => 'Ilość w magazynie'))
            ->add('save', SubmitType::class, array('label' => 'Zapisz'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->all();
            $bookTitle = $data['title']->getData();
            $bookAuthor = $data['author']->getData();
            $bookQuantity = $data['quantity']->getData();



            $newBook = new Books();
            $newBook->setTitle($bookTitle);
            $newBook->setAuthor($bookAuthor);
            $newBook->setQuantity($bookQuantity);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newBook);
            $em->flush();

            return $this->render('MacoBundle:Addbook:success.html.twig', array('book' => $book));
        }
        return $this->render('MacoBundle:Addbook:index.html.twig', array('form' => $form->createView()));
    }
}
