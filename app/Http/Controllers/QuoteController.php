<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class QuoteController extends Controller
{
    public function index(): Response
    {
        return new Response('json string', 200);
    }

    public function listQuotes(string $username): Response
    {
        $rawQuotes = $this->getRawQuotes($username);

        $quotes = [];
        foreach ($rawQuotes as $rawQuote) {
            $quotes[$username] = [
                'quotes: ' => $rawQuote->quotation,
            ];
        }

        return new Response(json_encode($quotes), 200);
    }

    public function addQuote(string $username, string $quote): Response
    {
        $userId = $this->getUserId($username);

        DB::table('quotations')->insert([
            'user_id' => $userId,
            'quotation' => $quote
        ]);

        return new Response(
            sprintf('Updated quotations for citizen %s with quote "%s"', $username, $quote),
            200
        );
    }

    private function getUserId(string $username): int
    {
        $userId = DB::table('users')
            ->select('id')
            ->where('username', '=', $username)
            ->get();

        if ($userId === null) {
            throw new ModelNotFoundException('User not found by ID ' . $userId);
        }

        return (int)$userId[0]->id;
    }

    private function getRawQuotes(string $username): Collection
    {
        $quotes =  DB::table('quotations')
            ->join('users', 'quotations.user_id', '=', 'users.id')
            ->select('quotations.quotation')
            ->where('users.username', '=', $username)
            ->get();

        if ($quotes === null) {
            throw new ModelNotFoundException('No quotes present in table quotations.');
        }

        return $quotes;
    }
}
