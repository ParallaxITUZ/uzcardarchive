<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DatabaseRefreshAction extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request): string
    {
        if (app()->environment('local')) {
            Artisan::call('migrate:fresh --seed');
        }

        return "Refreshed Database";
    }
}
