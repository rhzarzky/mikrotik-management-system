<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Router;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    /**
     * Get user and router count.
     */
    public function getStats()
    {
        try {
            $userCount = User::count();
            $routerCount = Router::count();

            return response()->json([
                'users' => $userCount,
                'routers' => $routerCount,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
