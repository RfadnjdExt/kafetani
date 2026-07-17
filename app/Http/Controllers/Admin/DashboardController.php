<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pendapatan' => Order::where('status', 'completed')->sum('total'),
            'total_pesanan'    => Order::count(),
            'total_produk'     => Product::count(),
            'total_petani'     => Farmer::count(),
        ];

        // --- Chart 1: Tren pendapatan 7 hari terakhir ---
        $revenueTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenueTrend[] = [
                'label' => $date->translatedFormat('D, d M'),
                'total' => (int) Order::where('status', 'completed')
                    ->whereDate('created_at', $date)
                    ->sum('total'),
            ];
        }

        // --- Chart 2: Breakdown status pesanan ---
        $statusBreakdown = Order::selectRaw('status, COUNT(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        // --- Chart 3: 5 produk terlaris (berdasarkan quantity terjual) ---
        $topProducts = OrderItem::selectRaw('product_id, SUM(quantity) as total_terjual')
            ->with('product:id_product,nama_produk')
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get()
            ->map(fn ($item) => [
                'nama'    => $item->product->nama_produk ?? 'Produk Dihapus',
                'terjual' => (int) $item->total_terjual,
            ]);

        $charts = [
            'revenue_trend'    => $revenueTrend,
            'status_breakdown' => $statusBreakdown,
            'top_products'     => $topProducts,
        ];

        return view('admin.dashboard', compact('stats', 'charts'));
    }
}
