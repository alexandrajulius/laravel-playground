<?php

declare(strict_types=1);

namespace Tests\Context;

use App\Http\Kernel;
use Exception;
use Laracasts\Behat\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Illuminate\Foundation\Application;

abstract class AbstractContext implements KernelAwareContext
{
    private $kernel;

    public function setApp(HttpKernelInterface $kernel)
    {
        $this->kernel = $kernel;
        set_exception_handler(null);
    }
    public function getSession($name = null)
    {
    }

    protected function kernel(): Application
    {
        if ($this->kernel) {
            return $this->kernel;
        }

        throw new Exception('Kernel not set.');
    }
}
