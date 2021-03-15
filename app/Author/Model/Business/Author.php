<?php

declare(strict_types=1);

namespace App\Author\Model\Business;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

final class Author
{
    public function update(Request $request, string $username): Response
    {
        if ($this->authorExists($username)) {
            $payload = json_decode($request->getContent(), true);
            $this->updateAuthor($payload, $username);

            return new Response('Author ' . $username . ' has been updated.', 200);
        }

        return new Response('Author ' . $username . ' not found', 404);
    }

    public function listAuthors(): Response
    {
        $rawUsers = DB::table('authors')->distinct()->get();

        $users = [];
        foreach ($rawUsers as $rawUser) {
            $users[$rawUser->id] = [
                'firstname' => $rawUser->firstname,
                'surname' => $rawUser->surname,
                'country' => $rawUser->country
            ];
        }

        return new Response(json_encode($users), 200);
    }

    private function authorExists(string $username): bool
    {
        $user = DB::table('authors')
            ->where('username', '=', $username)
            ->get();

        return $user !== null;
    }

    private function updateAuthor(array $payload, string $username): void
    {
        foreach ($payload as $column => $value) {
            DB::table('authors')
                ->where('username', '=', $username)
                ->update([
                    $column => $value
                ]);
        }
    }
}
