<?php

namespace MacoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MacoBundle\Entity\Books;

class HomeController extends Controller
{
    public function indexAction()
    {
        $book = $this->getDoctrine()
            ->getRepository('MacoBundle:Books')
            ->findAll();

        if (!$book){
            throw $this->createNotFoundException(
                'Nie znaleziono żadnych ksiązek'
            );
        }
        return $this->render('MacoBundle:Home:index.html.twig', array('book' => $book));
    }
}
