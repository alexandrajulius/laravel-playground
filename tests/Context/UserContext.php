<?php

declare(strict_types=1);

namespace Tests\Context;

use App\Http\Controllers\UserController;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Kernel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Assert;

final class UserContext extends AbstractContext implements Context
{
    /**
     * @Given :username exists in the database
     */
    public function existsInTheDatabase($username)
    {

    }

    /**
     * @Given I want to put the following payload on :column
     */
    public function iWantToPutTheFollowingPayloadOn($url, PyStringNode $citizen)
    {
        $payload = $citizen->getRaw();
        var_dump($url);

        $request = Request::create($url, 'PUT', [], [], [], [], $payload);

        $this->response = $this->kernel()->handle($request);
    }

    /**
     * @Then I should get :arg1 with the updated data
     */
    public function iShouldGetWithTheUpdatedData($arg1, PyStringNode $string)
    {
        throw new PendingException();
    }
}
