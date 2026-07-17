<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

/**
 * Laporan keuangan bulanan (SRS: "meningkatkan efisiensi pengelolaan laporan
 * keuangan bulanan"). Sebelumnya dashboard admin cuma punya tren 7 hari
 * terakhir tanpa laporan per-bulan dan tanpa export — ini melengkapi itu.
 */
class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $periode = $this->resolvePeriode($request);
        [$awalBulan, $akhirBulan] = $this->rentangBulan($periode);

        // Ambil semua order bulan ini sekali saja, lalu agregasi di PHP.
        // Sengaja tidak pakai fungsi tanggal raw SQL (DATE_FORMAT di MySQL vs
        // strftime di SQLite) supaya query tetap portable di semua driver —
        // lihat catatan yang sama di TableController@index.
        $orderBulanIni = Order::with('items.product')
            ->whereBetween('created_at', [$awalBulan, $akhirBulan])
            ->get();

        $orderSelesai = $orderBulanIni->where('status', 'completed');

        $summary = [
            'total_pendapatan'      => (int) $orderSelesai->sum('total'),
            'total_pesanan_masuk'   => $orderBulanIni->count(),
            'total_pesanan_selesai' => $orderSelesai->count(),
            'total_item_terjual'    => (int) $orderSelesai->flatMap->items->sum('quantity'),
            'rata_rata_transaksi'   => $orderSelesai->count() > 0
                ? (int) round($orderSelesai->sum('total') / $orderSelesai->count())
                : 0,
        ];

        // Tren harian dalam bulan yang dipilih (untuk chart)
        $trenHarian = [];
        $kursor = $awalBulan->copy();
        while ($kursor->lte($akhirBulan)) {
            $tanggal = $kursor->toDateString();
            $trenHarian[] = [
                'label' => $kursor->translatedFormat('d M'),
                'total' => (int) $orderSelesai
                    ->filter(fn ($o) => $o->created_at->toDateString() === $tanggal)
                    ->sum('total'),
            ];
            $kursor->addDay();
        }

        // Breakdown status pesanan bulan ini (semua status, bukan cuma selesai)
        $statusBreakdown = $orderBulanIni->countBy(fn ($o) => $o->status);

        // 5 produk terlaris bulan ini (dari order yang sudah selesai)
        $topProduk = $orderSelesai->flatMap->items
            ->groupBy('product_id')
            ->map(fn (Collection $items) => [
                'nama'    => $items->first()->product->nama_produk ?? 'Produk Dihapus',
                'terjual' => (int) $items->sum('quantity'),
                'omzet'   => (int) $items->sum('subtotal'),
            ])
            ->sortByDesc('terjual')
            ->take(5)
            ->values();

        return view('admin.laporan-keuangan', [
            'summary'         => $summary,
            'trenHarian'      => $trenHarian,
            'statusBreakdown' => $statusBreakdown,
            'topProduk'       => $topProduk,
            'daftarBulan'     => $this->daftarBulanTersedia(),
            'periodeAktif'    => $periode->format('Y-m'),
            'periodeLabel'    => $periode->translatedFormat('F Y'),
        ]);
    }

    /**
     * Export laporan sebagai CSV (bisa dibuka langsung di Excel/Sheets).
     * Tidak butuh dependency tambahan.
     */
    public function exportCsv(Request $request): Response
    {
        $periode = $this->resolvePeriode($request);
        [$awalBulan, $akhirBulan] = $this->rentangBulan($periode);

        $orders = Order::with('items')
            ->whereBetween('created_at', [$awalBulan, $akhirBulan])
            ->where('status', 'completed')
            ->orderBy('created_at')
            ->get();

        $namaFile = 'laporan-keuangan-' . $periode->format('Y-m') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $out = fopen('php://output', 'w');

            // BOM supaya karakter dibaca benar oleh Excel
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, ['No', 'Tanggal', 'ID Pesanan', 'Pelanggan', 'Jumlah Item', 'Total (Rp)']);

            foreach ($orders as $i => $order) {
                fputcsv($out, [
                    $i + 1,
                    $order->created_at->format('d-m-Y H:i'),
                    $order->id,
                    $order->display_name,
                    (int) $order->items->sum('quantity'),
                    $order->total,
                ]);
            }

            fputcsv($out, []);
            fputcsv($out, ['', '', '', '', 'Total Pendapatan', (int) $orders->sum('total')]);

            fclose($out);
        }, $namaFile, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Export laporan sebagai PDF. Butuh package barryvdh/laravel-dompdf
     * (belum ada di composer.json project ini — lihat catatan di README
     * patch). Kalau belum ter-install, tampilkan pesan yang jelas daripada
     * fatal error supaya halaman lain tetap jalan normal.
     */
    public function exportPdf(Request $request)
    {
        if (! class_exists(Pdf::class)) {
            return back()->with('error', 'Fitur export PDF butuh package tambahan. Jalankan: composer require barryvdh/laravel-dompdf');
        }

        $periode = $this->resolvePeriode($request);
        [$awalBulan, $akhirBulan] = $this->rentangBulan($periode);

        $orders = Order::with('items.product')
            ->whereBetween('created_at', [$awalBulan, $akhirBulan])
            ->where('status', 'completed')
            ->orderBy('created_at')
            ->get();

        $ringkasan = [
            'total_pendapatan'   => (int) $orders->sum('total'),
            'total_pesanan'      => $orders->count(),
            'total_item_terjual' => (int) $orders->flatMap->items->sum('quantity'),
        ];

        $pdf = Pdf::loadView('admin.laporan-keuangan-pdf', [
            'orders'       => $orders,
            'ringkasan'    => $ringkasan,
            'periodeLabel' => $periode->translatedFormat('F Y'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-keuangan-' . $periode->format('Y-m') . '.pdf');
    }

    /**
     * Baca parameter ?bulan=YYYY-MM dari request, fallback ke bulan berjalan
     * kalau kosong atau formatnya tidak valid.
     */
    private function resolvePeriode(Request $request): Carbon
    {
        $bulanInput = $request->query('bulan');

        if ($bulanInput) {
            try {
                return Carbon::createFromFormat('Y-m-d', $bulanInput . '-01')->startOfMonth();
            } catch (\Exception $e) {
                // format tidak valid, jatuh ke default di bawah
            }
        }

        return Carbon::now()->startOfMonth();
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function rentangBulan(Carbon $periode): array
    {
        return [
            $periode->copy()->startOfMonth()->startOfDay(),
            $periode->copy()->endOfMonth()->endOfDay(),
        ];
    }

    /**
     * Daftar bulan (dari order pertama sampai bulan berjalan) untuk dropdown
     * pemilih periode di halaman laporan.
     */
    private function daftarBulanTersedia(): Collection
    {
        $orderPertama = Order::orderBy('created_at')->first();

        if (! $orderPertama) {
            return collect([[
                'value' => Carbon::now()->format('Y-m'),
                'label' => Carbon::now()->translatedFormat('F Y'),
            ]]);
        }

        $daftar = collect();
        $kursor = $orderPertama->created_at->copy()->startOfMonth();
        $bulanIni = Carbon::now()->startOfMonth();

        while ($kursor->lte($bulanIni)) {
            $daftar->push([
                'value' => $kursor->format('Y-m'),
                'label' => $kursor->translatedFormat('F Y'),
            ]);
            $kursor->addMonth();
        }

        return $daftar->reverse()->values();
    }
}
