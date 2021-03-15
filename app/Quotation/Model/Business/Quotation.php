<?php

declare(strict_types=1);

namespace App\Quotation\Model\Business;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class Quotation
{
    public function listQuotes(string $username): Response
    {
        if ($this->authorExists($username)) {
            $rawQuotes = $this->getRawQuotes($username);
            $quotes = [];
            foreach ($rawQuotes as $rawQuote) {
                $quotes[$username][$rawQuote->book][] = $rawQuote->quotation;
            }

            return new Response(json_encode($quotes), 200);
        }

        return new Response('Author ' . $username . ' not found', 404);
    }

    public function addQuote(string $username, string $quote, string $book): Response
    {
        $userId = $this->getAuthorId($username);

        DB::table('quotations')->insert([
            'user_id' => $userId,
            'quotation' => $quote,
            'book' => $book,
        ]);

        return new Response(
            sprintf(
                'Updated quotations for author %s with quote "%s" for book "%s"',
                $username,
                $quote,
                $book
            ),
            200
        );
    }

    private function getAuthorId(string $username): int
    {
        $userId = DB::table('authors')
            ->select('id')
            ->where('username', '=', $username)
            ->get();

        if ($userId === null) {
            throw new ModelNotFoundException(
                'Author not found by ID ' . $userId
            );
        }

        return (int)$userId[0]->id;
    }

    private function getRawQuotes(string $username): Collection
    {
        $quotes =  DB::table('quotations')
            ->join('authors', 'quotations.user_id', '=', 'authors.id')
            ->select('quotations.quotation', 'quotations.book')
            ->where('authors.username', '=', $username)
            ->get();

        if ($quotes === null) {
            throw new ModelNotFoundException(
                'No quotes present in table quotations for author ' . $username
            );
        }

        return $quotes;
    }

    private function authorExists(string $username): bool
    {
        $user = DB::table('authors')
            ->where('username', '=', $username)
            ->get();

        return $user !== null;
    }
}
