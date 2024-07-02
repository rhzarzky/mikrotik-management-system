<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Router;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getStats()
    {
        $userCount = User::count();
        $routerCount = Router::count();

        return response()->json([
            'users' => $userCount,
            'routers' => $routerCount,
        ]);
    }
}
