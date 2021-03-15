<?php

declare(strict_types=1);

namespace App\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Facade;

final class AuthorFacade extends Facade
{
    public $authorFactory;

    public function __construct(
        AuthorFactory $authorFactory
    ) {
        $this->authorFactory = $authorFactory;
    }

    public function updateAuthor(Request $request, string $username): Response
    {
        return $this->authorFactory->createAuthor()->update($request, $username);
    }

    public function listAuthors(): Response
    {
        return $this->authorFactory->createAuthor()->listAuthors();
    }
}
