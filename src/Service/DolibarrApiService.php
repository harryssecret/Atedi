<?php

namespace App\Service;

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
        var_dump($thirdParty);

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
        $body = ["firstname" => $client->getFirstName(), "lastname" => $client->getLastName(), "name" => $client->getLastName() . " " . $client->getFirstName(), "phone" => $client->getPhone(), "client" => 1];
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

    public function sendInvoiceToDolibarr(Intervention $intervention): void
    {
        $client = $intervention->getClient();

        if (!isset($client)) {
            throw new Error("A client was not set in your query.");
        }

        if (!$this->doesThirdPartyExists($intervention->getClient())) {
            $this->createThirdParty($client);
        }

        $body = [];
        $response = $this->client->request("POST", $this->params->get("app.dolibarr_api_url") . "/invoices", ['json' => [
            $body
        ]]);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            echo "Facture créée.";
            return;
        }

        throw new Error("Impossible to send the invoice to Dolibarr : got $statusCode");
    }

    public function doesThirdPartyExists(Client $client): bool
    {
        $query = ["sqlfilters" => "t.nom='" . $client->getLastName() . " " . $client->getFirstName() . "' AND t.phone='" . $client->getPhone() . "'"];


        $response = $this->client->request("GET", $this->params->get("app.dolibarr_api_url") . "/thirdparties", [
            'query' => $query
        ]);

        if ($response->getStatusCode() == 404) {
            return false;
        }

        return true;
    }
}
