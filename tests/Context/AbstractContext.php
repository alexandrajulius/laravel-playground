<?php

declare(strict_types=1);

namespace Tests\Context;

use App\Http\Kernel;

abstract class AbstractContext
{
    private static $kernel;

    public function setUp(): void
    {
        $this->kernel();
    }

    protected function kernel(): Kernel
    {
        if (self::$kernel) {
            return self::$kernel;
        }

        $app = require __DIR__.'/../../bootstrap/app.php';
        self::$kernel = $app->make(Kernel::class);

        return self::$kernel;
    }
}
