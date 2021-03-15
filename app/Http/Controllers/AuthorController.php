<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Author\AuthorFacade;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class AuthorController
{
    public $author;

    public function __construct(AuthorFacade $author)
    {
        $this->author = $author;
    }

    public function update(Request $request, string $username): Response
    {
        return $this->author->updateAuthor($request, $username);
    }

    public function listAuthors(): Response
    {
        return $this->author->listAuthors();
    }
}
