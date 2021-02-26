<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

final class UserController
{
    public function update(Request $request, string $username): Response
    {
        if ($this->citizenExists($username)) {
            $payload = json_decode($request->getContent(), true);
            $this->updateCitizen($payload, $username);

            return new Response('Citizen ' . $username . ' has been updated.', 200);
        }

        return new Response('Citizen ' . $username . ' not found', 404);
    }

    private function citizenExists(string $username): bool
    {
        $user = DB::table('users')
            ->where('username', '=', $username)
            ->get();

        return $user !== null;
    }

    private function updateCitizen(array $payload, string $username): void
    {
        foreach ($payload as $column => $value) {
            DB::table('users')
                ->where('username', '=', $username)
                ->update([
                    $column => $value
                ]);
        }
    }

    public function listCitizens(): Response
    {
        $rawUsers = DB::table('users')->distinct()->get();

        $users = [];
        foreach ($rawUsers as $rawUser) {
            $users[$rawUser->id] = [
                'firstname: ' => $rawUser->firstname,
                'surname: ' => $rawUser->surname,
                'address: ' => $rawUser->address
            ];
        }

        return new Response(json_encode($users), 200);
    }
}
