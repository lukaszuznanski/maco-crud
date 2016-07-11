<?php

namespace MacoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MacoBundle\Entity\Books;

class BookController extends Controller
{
    public function indexAction($slug)
    {
        $book = $this->getDoctrine()
            ->getRepository('MacoBundle:Books')
            ->findByTitle($slug);

        if (!$book){
            throw $this->createNotFoundException(
                'Nie ma książki o takim tytule.'
            );
        }
        return $this->render('MacoBundle:Book:index.html.twig', array('book' => $book));
    }
}
