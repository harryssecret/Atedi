<?php

namespace App\Tests;

use App\Entity\Client;
use App\Service\DolibarrApiService;
use Error;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function PHPUnit\Framework\assertEquals;

class CheckInvoiceCreationProcessTest extends KernelTestCase
{
    public function testIfAbleToCreateCustomer(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());

        $dolibarrApiService = static::getContainer()->get(DolibarrApiService::class);

        if (!isset($dolibarrApiService)) {
            throw new Error("Impossible to get Dolibarr API Service.");
        }

        $client = new Client();

        $client->setFirstName("Mickael");
        $client->setLastName("Jordan");

        $phoneNumber = "0612345678";

        $client->setPhone($phoneNumber);

        $dolibarrApiService->createThirdParty($client);

        $this->assertTrue($dolibarrApiService->doesThirdPartyExists($client), "third party is added");

        $clientId = $dolibarrApiService->getThirdPartyIdPerPhoneNumber($phoneNumber);
        $clientInDolibarr = $dolibarrApiService->getThirdParty($clientId);

        if (!isset($clientInDolibarr)) {
            throw new Error("Impossible to get user from Dolibarr");
        }

        var_dump($clientInDolibarr);

        assertEquals($clientId, $clientInDolibarr["id"], "can query third party");
    }
}
