<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Quotation\QuotationFacade;
use Illuminate\Http\Response;

final class QuoteController extends Controller
{
    public $quotation;

    public function __construct(QuotationFacade $quotation)
    {
        $this->quotation = $quotation;
    }

    public function index(): Response
    {
        return new Response('json string', 200);
    }

    public function listQuotes(string $username): Response
    {
        return $this->quotation->listQuotes($username);
    }

    public function addQuote(string $username, string $quote, string $book): Response
    {
        return $this->quotation->addQuote($username, $quote, $book);
    }
}
