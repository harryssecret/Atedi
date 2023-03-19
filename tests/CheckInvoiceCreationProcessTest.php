<?php

namespace App\Tests;

use App\Entity\Client;
use App\Entity\Intervention;
use App\Service\DolibarrApiService;
use DateTimeImmutable;
use Error;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function PHPUnit\Framework\assertEquals;

class CheckInvoiceCreationProcessTest extends KernelTestCase
{
    public function testIfAbleToCreateCustomer(): void
    {
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

        assertEquals($clientId, $clientInDolibarr["id"], "can query third party");
    }

    public function testIfAbleToCreateInvoice(): void
    {
        $dolibarrApiService = static::getContainer()->get(DolibarrApiService::class);

        if (!isset($dolibarrApiService)) {
            throw new Error("Impossible to get Dolibarr API Service.");
        }

        $newClient = new Client();
        $newClient->setPhone("0612345678");

        $intervention = new Intervention();
        $intervention->setDepositDate(new DateTimeImmutable());
        $intervention->setTotalPrice("10.00€");
        $intervention->setClient($newClient);

        $invoiceId = $dolibarrApiService->sendInvoiceToDolibarr($intervention);

        if (!isset($invoiceId)) {
            throw new Error("Invoice was not inserted.");
        }

        $invoice = $dolibarrApiService->getInvoice($invoiceId);

        $this->assertArrayHasKey("ref", $invoice);
    }
}
