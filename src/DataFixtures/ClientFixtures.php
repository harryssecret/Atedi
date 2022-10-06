<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Client;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = new Client();
        $data->setLastName('HOCHET');
        $data->setFirstName('Dylan');
        $data->setPhone('0602030405');
        $data->setEmail('dylanhochet@gmail.com');
        $data->setStreet('6 Avenue de Plymouth, porte 1');
        $data->setCity('Cherbourg');
        $data->setPostalCode('50100');
        $manager->persist($data);

        $data = new Client();
        $data->setLastName('MAYAUX');
        $data->setFirstName('Frank');
        $data->setPhone('0601010101');
        $data->setEmail('mayauxf@orange.fr');
        $data->setStreet('46 rue de la paix');
        $data->setCity('Coutances');
        $data->setPostalCode('50200');
        $manager->persist($data);

        $data = new Client();
        $data->setLastName('LEFEVRE');
        $data->setFirstName('Sabrina');
        $data->setPhone('0746568961');
        $data->setStreet('8 rue de la constitution');
        $data->setCity('Avranches');
        $data->setPostalCode('50300');
        $manager->persist($data);

        $data = new Client();
        $data->setLastName('BARRE');
        $data->setFirstName('Albert');
        $data->setPhone('0233665588');
        $manager->persist($data);

        $manager->flush();
    }
}
