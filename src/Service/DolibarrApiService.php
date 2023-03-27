<?php

namespace App\Service;

use App\Entity\Task;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Intervention;
use Error;
use App\Entity\Client;

class DolibarrApiService
{
    private HttpClientInterface $client;
    private ContainerBagInterface $params;

    public function __construct(HttpClientInterface $dolibarrApi, ContainerBagInterface $params)
    {
        $this->client = $dolibarrApi;
        $this->params = $params;
    }

    public function getThirdPartyIdPerName(string $name): ?int
    {
        $dolibarrSqlReq = "t.nom = $name";
        $query = ["limit" => "1", "sqlfilters" => $dolibarrSqlReq];
        $response = $this->client->request("GET", $this->params->get("app.dolibarr_api_url") . "/thirdparties", ['query' => $query]);
        $decodedPayload = $response->toArray();
        $thirdParty = $decodedPayload[0];
        if (isset($thirdParty)) {
            return (int) $thirdParty["id"];
        }

        return null;
    }

    public function getThirdPartyIdPerPhoneNumber(string $phoneNumber): ?int
    {
        $dolibarrSqlReq = "t.phone = $phoneNumber";
        $query = ["limit" => "1", "sqlfilters" => $dolibarrSqlReq];
        $response = $this->client->request("GET", $this->params->get("app.dolibarr_api_url") . "/thirdparties", ['query' => $query]);
        $decodedPayload = $response->toArray();
        $thirdParty = $decodedPayload[0];

        if (isset($thirdParty)) {
            return (int) $thirdParty["id"];
        }

        return null;
    }

    public function getThirdParty(int $id): ?array
    {
        $response = $this->client->request("GET", $this->params->get("app.dolibarr_api_url") . "/thirdparties/$id");
        if ($response->getStatusCode() == 200) {
            return $response->toArray();
        }
        return null;
    }

    public function createThirdParty(Client $client): void
    {
        $body = ["firstname" => $client->getFirstName(), "lastname" => $client->getLastName(), "name" => $client->getFirstName() . " " . $client->getLastName(), "phone" => $client->getPhone(), "client" => 1];
        $response = $this->client->request("POST", $this->params->get("app.dolibarr_api_url") . "/thirdparties", [
            'json' =>
            $body,
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return;
        }
        throw new Error("Impossible to create the client : got a $statusCode response from the server.");
    }

    public function sendInvoiceToDolibarr(Intervention $intervention): ?int
    {
        $client = $intervention->getClient();

        if (!isset($client)) {
            throw new Error("A client was not set in your query.");
        }

        if (!$this->doesThirdPartyExists($intervention->getClient())) {
            $this->createThirdParty($client);
        }

        $clientId = $this->getThirdPartyIdPerPhoneNumber($client->getPhone());

        if (!isset($clientId)) {
            throw new Error("Impossible to get third party id with phone number.");
        }

        $body = ["socid" => "$clientId", 'date' => $intervention->getDepositDate()->format('Y-m-d'), "type" => 0];

        $tasks = $intervention->getTasks();

        $lines = [];
        
        if ($tasks) {
            foreach ($tasks as $task) {
                $productId = $this->getProductIdPerDesc($task->getTitle());
                if (!isset($productId)) {
                    $productId = $this->createProduct($task);
                }
                $lines[] = ["desc" => $task->getTitle(), "qty" => 1, "tva_tx" => 20.0, "subprice" => $task->getPrice(), "fk_product" => $productId];
            }
            $body["lines"] = $lines;
            var_dump($body["lines"]);
        }

        $response = $this->client->request("POST", $this->params->get("app.dolibarr_api_url") . "/invoices", [
            'json' =>
            $body
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            throw new Error("Impossible to send the invoice to Dolibarr : got $statusCode");
        }

        return $response->getContent();
    }

    public function getProductIdPerDesc(string $desc): ?int {
        $query = ["sqlfilters" => "t.label='" . $desc . "'"];
        $response = $this->client->request("GET", $this->params->get("app.dolibarr_api_url"). "/products", ['query' => $query]);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $decodedPayload = $response->toArray();
        $product = $decodedPayload[0];

        if (isset($product)) {
            return (int) $product["id"];
        }

        return null;
    }

    public function createProduct(Task $task) {
        $body = [
            "name" => $task->getTitle(),
            "desc" => $task->getTitle(),
            "price" => $task->getPrice(),
        ];
        $response = $this->client->request("POST", $this->params->get("app.dolibarr_api_url"). "/products", [
            'json' =>
            $body
        ]);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return $response->toArray();
        }
        return null;
    }

    public function getInvoice(int $id): ?array
    {
        $response = $this->client->request("GET", $this->params->get("app.dolibarr_api_url") . "/invoices/$id");
        if ($response->getStatusCode() !== 200) {
            return null;
        }
        return $response->toArray();
    }

    public function doesThirdPartyExists(Client $client): bool
    {
        $isClientNameSet = $client->getLastName() !== null and $client->getFirstName() !== null;
        $clientPhoneNumber = $client->getPhone();

        $query = [];

        if ($isClientNameSet and isset($clientPhoneNumber)) {
            $clientfullName = $client->getFirstName() . " " . $client->getLastName();
            $query = ["sqlfilters" => "t.nom='" . $clientfullName . "' AND t.phone='" . $clientPhoneNumber . "'"];
        } elseif (!$isClientNameSet and isset($clientPhoneNumber)) {
            $query = ["sqlfilters" => "t.phone=" . $client->getPhone()];
        } else {
            throw new Error("Impossible to send third party to Dolibarr since client name and/or phone are null.");
        }

        $response = $this->client->request("GET", $this->params->get("app.dolibarr_api_url") . "/thirdparties", [
            'query' => $query
        ]);

        if ($response->getStatusCode() == 404) {
            return false;
        }

        return true;
    }
}