<?php

namespace MacoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MacoBundle\Entity\Books;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UpdatebookController extends Controller
{
    public function getRepo(){
        $book = $this->getDoctrine()
            ->getRepository('MacoBundle:Books')
            ->findAll();

        if (!$book) {
            throw $this->createNotFoundException(
                'Nie ma książek.'
            );
        }

        $booksTitles[] = Array();
        $AllBooksQuantity = count($book);
        for($i=0;$i<$AllBooksQuantity;$i++){
            $booksTitles[$i] = $book[$i]->getTitle();
        }
        return $booksTitles;
    }

    public function indexAction(Request $request)
    {
        $bookChoices = $this->getRepo();
        $bookUpdate = new Books();
        $form = $this->createFormBuilder($bookUpdate)
            ->add('title', ChoiceType::class, array('choices' => array_flip($bookChoices),'label' => 'Tytuł'))
            ->add('newtitle', TextType::class, array('label' => 'Nowy tytuł', 'mapped' => false))
            ->add('newauthor', TextType::class, array('label' => 'Nowy autor', 'mapped' => false))
            ->add('newquantity', IntegerType::class, array('label' => 'Nowa ilość magazynowa', 'mapped' => false))
            ->add('save', SubmitType::class, array('label' => 'Wyślij'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->all();
            $bookTitle = $data['title']->getData();
            $bookNewTitle = $data['newtitle']->getData();
            $bookNewAuthor = $data['newauthor']->getData();
            $bookNewQuantity = $data['newquantity']->getData();

            $em = $this->getDoctrine()->getManager();
            $bookToUpdate = $em->getRepository('MacoBundle:Books')->findOneByTitle($bookChoices[$bookTitle]);
            $bookToUpdate->setTitle($bookNewTitle);
            $bookToUpdate->setAuthor($bookNewAuthor);
            $bookToUpdate->setQuantity($bookNewQuantity);
            $em->flush();
            return $this->redirectToRoute('maco_homepage');
        }
        return $this->render('MacoBundle:Updatebook:index.html.twig', array('form' => $form->createView()));
    }


}
