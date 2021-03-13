<?php

namespace Tests\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Assert;
use RuntimeException;

final class QuotationContext extends AbstractContext implements Context
{
    const AUTHOR_USERNAME = 'AUTHOR USERNAME';
    const QUOTE = 'QUOTE';
    const BOOK = 'BOOK';
    public Response $response;
    public array $quote;

    /**
     * @Given I want to add a quote with the following properties
     */
    public function iWantToAddAQuoteWithTheFollowingProperties(TableNode $table)
    {
        $quote = $table->getColumnsHash()[0];
        $this->quote = $quote;

        $url = '/api/add-quote/' . $quote[self::AUTHOR_USERNAME] . '/'. $quote[self::QUOTE]. '/'. $quote[self::BOOK];
        $request = Request::create($url, 'POST');
        $this->response = $this->kernel()->handle($request);

        Assert::assertEquals(
            200,
            $this->response->getStatusCode(),
            'Status code is not 200'
        );
    }

    /**
     * @Then the quote should be added to the author's quotations
     */
    public function theQuoteShouldBeAddedToTheAuthorsQuotations()
    {
        $expected = 'Updated quotations for author ' . $this->quote[self::AUTHOR_USERNAME] . ' with quote "' . $this->quote[self::QUOTE] . '" for book "' . $this->quote[self::BOOK] . '"';
        Assert::assertEquals($expected, $this->response->getContent());

        $this->rollbackQuotation();
    }

    public function rollbackQuotation(): void
    {
        $rawQuotes = $this->getAllQuotes();

        foreach ($rawQuotes as $rawQuote) {
            if ($rawQuote->quotation === $this->quote[self::QUOTE]) {
                DB::table('quotations')->where('quotation', $this->quote[self::QUOTE])->delete();
                return;
            }
        }

        throw new RuntimeException(
            sprintf(
                'Quote "%s" has not been added to quotations.',
                $this->quote[self::QUOTE]
            )
        );
    }

    public function getAllQuotes(): Collection
    {
        return DB::table('quotations')
            ->join('authors', 'quotations.user_id', '=', 'authors.id')
            ->select('quotations.quotation')
            ->where('authors.username', '=', $this->quote[self::AUTHOR_USERNAME])
            ->get();
    }
}
