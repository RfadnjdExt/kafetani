<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Keuangan {{ $periodeLabel }}</title>
<style>
  {{-- Dompdf tidak mendukung flexbox/grid, jadi layout di sini sengaja
       pakai table + block element biasa supaya render konsisten. --}}
  body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #2b2b2b; }
  h1 { font-size: 18px; margin: 0 0 2px; }
  .sub { font-size: 12px; color: #666; margin: 0 0 18px; }
  table.ringkasan { width: 100%; border-collapse: collapse; margin-bottom: 22px; }
  table.ringkasan td {
    border: 1px solid #ddd;
    padding: 10px 12px;
    width: 33.33%;
  }
  table.ringkasan .label { display: block; font-size: 10px; color: #777; margin-bottom: 3px; }
  table.ringkasan .value { display: block; font-size: 15px; font-weight: bold; }
  table.rincian { width: 100%; border-collapse: collapse; }
  table.rincian th {
    background: #3B5C42;
    color: #fff;
    text-align: left;
    padding: 7px 8px;
    font-size: 11px;
  }
  table.rincian td {
    padding: 6px 8px;
    border-bottom: 1px solid #eee;
    font-size: 11px;
  }
  table.rincian tr:nth-child(even) td { background: #fafafa; }
  .total-row td { font-weight: bold; border-top: 2px solid #3B5C42; }
  .footer-note { margin-top: 18px; font-size: 10px; color: #999; }
</style>
</head>
<body>
  <h1>Laporan Keuangan — Kafetani</h1>
  <p class="sub">Periode: {{ $periodeLabel }} &middot; Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>

  <table class="ringkasan">
    <tr>
      <td>
        <span class="label">Total Pendapatan</span>
        <span class="value">Rp {{ number_format($ringkasan['total_pendapatan'], 0, ',', '.') }}</span>
      </td>
      <td>
        <span class="label">Total Pesanan Selesai</span>
        <span class="value">{{ $ringkasan['total_pesanan'] }}</span>
      </td>
      <td>
        <span class="label">Total Item Terjual</span>
        <span class="value">{{ $ringkasan['total_item_terjual'] }}</span>
      </td>
    </tr>
  </table>

  <table class="rincian">
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>ID Pesanan</th>
        <th>Pelanggan</th>
        <th>Jumlah Item</th>
        <th style="text-align:right">Total</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $i => $order)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
          <td>#{{ $order->id }}</td>
          <td>{{ $order->display_name }}</td>
          <td>{{ (int) $order->items->sum('quantity') }}</td>
          <td style="text-align:right">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center;color:#999;padding:16px;">Tidak ada pesanan selesai pada periode ini.</td>
        </tr>
      @endforelse
      @if($orders->isNotEmpty())
        <tr class="total-row">
          <td colspan="5" style="text-align:right">Total Pendapatan</td>
          <td style="text-align:right">Rp {{ number_format($orders->sum('total'), 0, ',', '.') }}</td>
        </tr>
      @endif
    </tbody>
  </table>

  <p class="footer-note">Dokumen ini dibuat otomatis oleh sistem Kafetani.</p>
</body>
</html>
