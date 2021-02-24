<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

final class UserController
{
    public function update(Request $request): Response
    {

        return new Response('json string', 200);
    }

    public function listCitizens(): Response
    {
        $rawUsers = DB::table('users')->distinct()->get();

        $users = [];
        foreach ($rawUsers as $rawUser) {
            $users[$rawUser->id] = [
                'firstname: ' => $rawUser->firstname,
                'lastname: ' => $rawUser->surname,
                'address: ' => $rawUser->address
            ];
        }

        return new Response(json_encode($users), 200);
    }
}
