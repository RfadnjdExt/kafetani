<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * GET /api/admin/orders?status=pending|processing|ready|completed|cancelled|all
     */
    public function index(Request $request): JsonResponse
    {
        $statusFilter = $request->query('status', 'all');

        $orders = Order::with(['user', 'items.product'])
            ->when($statusFilter !== 'all', fn ($q) => $q->where('status', $statusFilter))
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'orders'  => OrderResource::collection($orders),
        ]);
    }

    /**
     * POST /api/admin/orders/{order}/status
     */
    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,processing,ready,completed,cancelled'],
        ]);

        $order->update(['status' => $request->input('status')]);

        return response()->json([
            'success' => true,
            'message' => "Status pesanan #{$order->id} berhasil diperbarui!",
            'order'   => new OrderResource($order->load(['user', 'items.product'])),
        ]);
    }
}
