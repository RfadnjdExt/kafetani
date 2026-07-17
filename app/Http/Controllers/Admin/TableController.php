<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TableController extends Controller
{
    /**
     * Daftar meja + link generate QR (fitur pemesanan mandiri via QR, SRS 3.4.1)
     */
    public function index()
    {
        $tables = Table::orderByRaw('CAST(nomor AS INTEGER)')->orderBy('nomor')->get();

        return view('admin.tables.index', compact('tables'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nomor'      => ['required', 'string', 'max:20', 'unique:tables,nomor'],
            'keterangan' => ['nullable', 'string', 'max:100'],
        ], [
            'nomor.unique' => 'Nomor meja itu sudah ada.',
        ]);

        Table::create($data);

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function toggle(Table $table): RedirectResponse
    {
        $table->update(['is_active' => ! $table->is_active]);

        return redirect()->route('admin.tables.index');
    }

    public function destroy(Table $table): RedirectResponse
    {
        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Meja dihapus.');
    }

    /**
     * Generate gambar QR asli (bukan cuma link) yang mengarah ke halaman
     * menu khusus meja ini (/meja/{nomor}). Pakai ?download=1 untuk unduh
     * sebagai file, kalau tidak akan ditampilkan langsung (buat preview).
     */
    public function qr(Table $table, Request $request): Response
    {
        require_once app_path('Support/QrCode/qrcode.php');

        $url = route('public.meja', $table->nomor);

        $qr = \QRCode::getMinimumQRCode($url, QR_ERROR_CORRECT_LEVEL_H);
        $image = $qr->createImage(8, 4); // module size 8px, margin 4 modul

        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        imagedestroy($image);

        $headers = ['Content-Type' => 'image/png'];
        if ($request->boolean('download')) {
            $headers['Content-Disposition'] = 'attachment; filename="qr-meja-' . $table->nomor . '.png"';
        }

        return response($png, 200, $headers);
    }
}
