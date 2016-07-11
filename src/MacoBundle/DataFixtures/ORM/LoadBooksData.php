<?php
/**
 * Created by PhpStorm.
 * User: Łukasz Uznański
 * Date: 11.07.2016
 * Time: 21:43
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MacoBundle\Entity\Books;

class LoadBooksData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $book_1 = new Books();
        $book_1->setTitle('Zanim się pojawiłeś');
        $book_1->setAuthor('Moyes Jojo');
        $book_1->setQuantity(5);

        $book_2 = new Books();
        $book_2->setTitle('Więcej krwi');
        $book_2->setAuthor('Nesbo Jo');
        $book_2->setQuantity(3);

        $book_3 = new Books();
        $book_3->setTitle('Małe życie');
        $book_3->setAuthor('Yanagihara Hanya');
        $book_3->setQuantity(7);

        $manager->persist($book_1);
        $manager->flush();

        $manager->persist($book_2);
        $manager->flush();

        $manager->persist($book_3);
        $manager->flush();
    }
}