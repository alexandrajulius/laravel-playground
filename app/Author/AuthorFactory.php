<?php

declare(strict_types=1);

namespace App\Author;

use App\Author\Model\Business\Author;

final class AuthorFactory
{
    public function createAuthor(): Author
    {
        return new Author();
    }
}
