<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\OperatingSystem;

class OperatingSystemFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = new OperatingSystem();
        $data->setTitle('Windows 10');
        $manager->persist($data);

        $data = new OperatingSystem();
        $data->setTitle('Windows 7');
        $manager->persist($data);

        $data = new OperatingSystem();
        $data->setTitle('Linux');
        $manager->persist($data);

        $manager->flush();
    }
}
