<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Equipment;

class EquipmentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = new Equipment();
        $data->setTitle('PC Portable');
        $manager->persist($data);

        $data = new Equipment();
        $data->setTitle('PC Fixe');
        $manager->persist($data);

        $data = new Equipment();
        $data->setTitle('Tablette');
        $manager->persist($data);

        $data = new Equipment();
        $data->setTitle('Téléphone');
        $manager->persist($data);

        $manager->flush();
    }
}
