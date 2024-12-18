<?php

namespace App\Http\Controllers;

use Turahe\SEOTools\Contracts\Tools;

class DashboardController extends Controller
{
    public function __construct(private Tools $meta) {}

    public function __invoke()
    {
        $this->meta->setTitle('Dashboard ');

        return view('dashboard', []);
    }
}
