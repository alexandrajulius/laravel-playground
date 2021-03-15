<?php

declare(strict_types=1);

namespace App\Quotation;

use Illuminate\Http\Response;

final class QuotationFacade
{
    public $quotationFactory;

    public function __construct(
        QuotationFactory $quotationFactory
    ) {
        $this->quotationFactory = $quotationFactory;
    }

    public function listQuotes(string $username): Response
    {
        return $this->quotationFactory->createQuotation()->listQuotes($username);
    }

    public function addQuote(string $username, string $quote, string $book): Response
    {
        return $this->quotationFactory->createQuotation()->addQuote($username, $quote, $book);
    }
}
