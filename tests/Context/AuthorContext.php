<?php

namespace Tests\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Assert;

final class AuthorContext extends AbstractContext implements Context
{
    public Response $response;

    public string $payload;

    public Collection $originalUser;

    /**
     * @Given :username exists in the database
     */
    public function existsInTheDatabase(string $username)
    {
        $this->originalUser = $this->getAuthor($username);

        Assert::assertEquals(
            $username,
            $this->originalUser[0]->username,
            'Author ' . $username . ' does not exist.'
        );
    }

    /**
     * @When I want to put the following payload on :requestUrl
     */
    public function iWantToPutTheFollowingPayloadOn(string $requestUrl, PyStringNode $requestPayload)
    {
        $this->payload = $requestPayload->getRaw();
        $request = Request::create($requestUrl, 'PUT', [], [], [], [], $this->payload);
        $this->response = $this->kernel()->handle($request);

        Assert::assertEquals(
            200,
            $this->response->getStatusCode(),
            'Status code is not 200.'
        );
    }

    /**
     * @Then I should get :username with the updated data
     */
    public function iShouldGetWithTheUpdatedData(string $username)
    {
        $updatedUser = $this->getAuthor($username);
        list($user, $payload) = $this->normalize($updatedUser);

        foreach ($user[0] as $column => $columnValue) {
            foreach ($payload as $key => $payloadValue) {
                if ($column === $key) {
                    Assert::assertEquals(
                        $payloadValue,
                        $columnValue,
                        'DB values do not match payload values.'
                    );
                }
            }
        }

        $this->rollbackAuthor($username);
    }

    /**
     * @Given I send a GET request :requestUrl
     */
    public function iSendAGetRequest($requestUrl)
    {
        $request = Request::create($requestUrl);
        $this->response = $this->kernel()->handle($request);

        Assert::assertEquals(
            200,
            $this->response->getStatusCode(),
            'Status code is not 200.'
        );
    }

    /**
     * @Then I should get the following response
     */
    public function iShouldGetTheFollowingResponse(PyStringNode $responsePayload)
    {
        Assert::assertEquals($responsePayload->getRaw(), $this->response->getContent());
    }

    private function normalize(Collection $updatedUser): array
    {
        $user = json_decode($updatedUser->toJson(), true);
        $payload = json_decode($this->payload, true);

        return array($user, $payload);
    }

    private function getAuthor(string $username): Collection
    {
        return DB::table('authors')
            ->where('username', '=', $username)
            ->get();
    }

    private function rollbackAuthor(string $username): void
    {
        list($originalUser, $payload) = $this->normalize($this->originalUser);

        foreach ($originalUser[0] as $column => $value) {
            foreach ($payload as $key => $payloadValue) {
                if ($column === $key) {
                    DB::table('authors')
                        ->where('username', '=', $username)
                        ->update([
                            $column => $value
                        ]);
                }
            }
        }
    }
}

