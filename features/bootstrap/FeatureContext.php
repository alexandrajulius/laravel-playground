<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I send a GET request :arg1
     */
    public function iSendAGetRequest($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should get the following response
     */
    public function iShouldGetTheFollowingResponse(PyStringNode $string)
    {
        throw new PendingException();
    }

}
