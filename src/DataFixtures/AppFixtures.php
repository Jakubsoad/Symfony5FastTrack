<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $amsterdam = new Conference();
        $amsterdam->setCity('Amsterdam');
        $amsterdam->setIsInternational(true);
        $amsterdam->setSlug('amsterdam-2001');
        $amsterdam->setYear('2001');
        $manager->persist($amsterdam);

        $paris = new Conference();
        $paris->setCity('Paris');
        $paris->setIsInternational(false);
        $paris->setSlug('paris-2019');
        $paris->setYear('2019');
        $manager->persist($paris);

        $comment = new Comment();
        $comment->setConference($amsterdam);
        $comment->setAuthor('Jakub');
        $comment->setEmail('jkasd@dasasd.com');
        $comment->setState('published');
        $comment->setText('Truly unique experience');
        $manager->persist($comment);

        $comment2 = new Comment();
        $comment2->setConference($amsterdam);
        $comment2->setAuthor('Lucas');
        $comment2->setEmail('lucas@example.com');
        $comment2->setText('I think this one is going to be moderated.');
        $manager->persist($comment2);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));

        $manager->flush();
    }
}
