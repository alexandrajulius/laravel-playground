<?php

namespace Tests\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Assert;
use RuntimeException;

final class QuotationContext extends AbstractContext implements Context
{
    public Response $response;

    public string $quote;

    public string $citizen;

    /**
     * @Given I want to add the quote :quote to the quotations of :citizen
     */
    public function iWantToAddTheQuoteToTheQuotationsOf($quote, $citizen)
    {
        $this->quote = $quote;
        $this->citizen = $citizen;

        $url = '/api/add-quote/' . $citizen . '/'. $quote;
        $request = Request::create($url, 'POST');
        $this->response = $this->kernel()->handle($request);

        Assert::assertEquals(
            200,
            $this->response->getStatusCode(),
            'Status code is not 200'
        );
    }

    /**
     * @Then the quote should be added to the citizen's quotations
     */
    public function theQuoteShouldBeAddedToTheCitizensQuotations()
    {
        $expected = 'Updated quotations for citizen ' . $this->citizen . ' with quote "' . $this->quote . '"';

        Assert::assertEquals($expected, $this->response->getContent());

        $this->rollbackQuotation();
    }

    public function rollbackQuotation(): void
    {
        $rawQuotes = $this->getAllQuotes();

        foreach ($rawQuotes as $rawQuote) {
            if ($rawQuote->quotation === $this->quote) {
                DB::table('quotations')->where('quotation', $this->quote)->delete();
                return;
            }
        }

        throw new RuntimeException(
            sprintf(
                'Quote "%s" has not been added to quotations.',
                $this->quote
            )
        );
    }

    public function getAllQuotes(): Collection
    {
        return DB::table('quotations')
            ->join('users', 'quotations.user_id', '=', 'users.id')
            ->select('quotations.quotation')
            ->where('users.username', '=', $this->citizen)
            ->get();
    }
}
