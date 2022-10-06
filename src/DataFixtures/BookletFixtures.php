<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Booklet;

class BookletFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = new Booklet();
        $data->setTitle('Avast');
        $manager->persist($data);

        $data = new Booklet();
        $data->setTitle('MSE');
        $manager->persist($data);

        $data = new Booklet();
        $data->setTitle('Windows Defender');
        $manager->persist($data);

        $data = new Booklet();
        $data->setTitle('Windows 10');
        $manager->persist($data);

        $manager->flush();
    }
}
