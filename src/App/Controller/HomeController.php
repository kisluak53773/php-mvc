<?php

declare(strict_types=1);

namespace App\Controller;

class HomeController
{
    public function home(): void
    {
        echo "Hello World!";
    }

    public function about(): void
    {
        phpinfo();
    }
}