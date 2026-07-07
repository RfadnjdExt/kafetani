<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * GET /api/admin/dashboard
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'stats'   => [
                'total_pendapatan' => (int) Order::where('status', 'completed')->sum('total'),
                'total_pesanan'    => Order::count(),
                'total_produk'     => Product::count(),
                'total_petani'     => Farmer::count(),
            ],
        ]);
    }
}
