@extends('layouts.admin')
@section('title', 'Laporan Keuangan')

@push('styles')
<link rel="stylesheet" href="{{ asset('style-dashboard.css') }}?v={{ @filemtime(public_path('style-dashboard.css')) ?: '1' }}">
@endpush

@section('content')
<div class="page-header">
  <div>
    <h1>Laporan Keuangan Bulanan</h1>
    <p style="font-size:.85rem;color:var(--text-mid);margin-top:.3rem">Ringkasan pendapatan periode {{ $periodeLabel }}.</p>
  </div>
</div>

<div class="laporan-toolbar">
  <form method="GET" action="{{ route('admin.laporan.index') }}" class="laporan-periode-form">
    <label for="bulan" style="font-size:.85rem;color:var(--text-mid);margin-right:.5rem">Pilih Bulan</label>
    <select name="bulan" id="bulan" onchange="this.form.submit()">
      @foreach($daftarBulan as $bulan)
        <option value="{{ $bulan['value'] }}" @selected($bulan['value'] === $periodeAktif)>{{ $bulan['label'] }}</option>
      @endforeach
    </select>
  </form>

  <div class="laporan-export-buttons">
    <a href="{{ route('admin.laporan.export.csv', ['bulan' => $periodeAktif]) }}" class="btn-edit">⬇ Export Excel (CSV)</a>
    <a href="{{ route('admin.laporan.export.pdf', ['bulan' => $periodeAktif]) }}" class="btn-primary">⬇ Export PDF</a>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <h3>Total Pendapatan</h3>
    <span class="stat-num">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</span>
  </div>
  <div class="stat-card">
    <h3>Pesanan Selesai</h3>
    <span class="stat-num">{{ $summary['total_pesanan_selesai'] }}</span>
    <span style="font-size:.75rem;color:var(--text-mid)">dari {{ $summary['total_pesanan_masuk'] }} pesanan masuk</span>
  </div>
  <div class="stat-card">
    <h3>Item Terjual</h3>
    <span class="stat-num">{{ $summary['total_item_terjual'] }}</span>
  </div>
  <div class="stat-card">
    <h3>Rata-rata / Transaksi</h3>
    <span class="stat-num">Rp {{ number_format($summary['rata_rata_transaksi'], 0, ',', '.') }}</span>
  </div>
</div>

<div class="charts-grid">
  <div class="chart-card" style="grid-column: span 2;">
    <h3>Tren Pendapatan Harian — {{ $periodeLabel }}</h3>
    <canvas id="chartTrenBulanan" height="90"></canvas>
  </div>
  <div class="chart-card">
    <h3>Status Pesanan Bulan Ini</h3>
    <canvas id="chartStatusBulanan" height="90"></canvas>
  </div>
</div>

<div class="chart-card" style="margin-top:1.25rem;">
  <h3 style="margin-bottom:1rem;">5 Produk Terlaris — {{ $periodeLabel }}</h3>
  @if($topProduk->isEmpty())
    <p style="color:var(--text-mid);font-size:.85rem;">Belum ada pesanan selesai pada bulan ini.</p>
  @else
    <table class="data-table">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Jumlah Terjual</th>
          <th>Omzet</th>
        </tr>
      </thead>
      <tbody>
        @foreach($topProduk as $produk)
          <tr>
            <td>{{ $produk['nama'] }}</td>
            <td>{{ $produk['terjual'] }}</td>
            <td>Rp {{ number_format($produk['omzet'], 0, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection

@push('styles')
<style>
  .laporan-toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:1rem;
    margin-bottom:1.25rem;
  }
  .laporan-periode-form select{
    padding:.5rem .75rem;
    border-radius:.6rem;
    border:1px solid var(--border, #e5e5e5);
    background:#fff;
    font-size:.85rem;
    color:var(--text, #333);
  }
  .laporan-export-buttons{
    display:flex;
    gap:.6rem;
    flex-wrap:wrap;
  }
  .charts-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:1.25rem;
    margin-top:1.5rem;
  }
  .chart-card{
    background:#fff;
    border:1px solid var(--border, #e5e5e5);
    border-radius:.85rem;
    padding:1.25rem;
    box-shadow:0 2px 10px rgba(59,42,26,.06);
    min-width:0;
  }
  .chart-card h3{
    font-size:.9rem;
    font-weight:500;
    margin-bottom:.9rem;
    color:var(--text-mid, #555);
  }
  .chart-card canvas{
    max-width:100%;
  }
  @media (max-width: 900px){
    .charts-grid{ grid-template-columns:1fr; gap:1rem; }
    .chart-card[style]{ grid-column:span 1 !important; }
    .chart-card{ padding:1rem; border-radius:.7rem; }
    .laporan-toolbar{ flex-direction:column; align-items:stretch; }
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
  const trenHarian = @json($trenHarian);
  const statusData = @json($statusBreakdown);

  const statusLabelMap = {
    pending_payment: 'Menunggu Pembayaran',
    pending: 'Masuk',
    processing: 'Proses',
    ready: 'Siap',
    completed: 'Selesai',
    cancelled: 'Dibatalkan',
  };

  new Chart(document.getElementById('chartTrenBulanan'), {
    type: 'line',
    data: {
      labels: trenHarian.map(d => d.label),
      datasets: [{
        label: 'Pendapatan (Rp)',
        data: trenHarian.map(d => d.total),
        borderColor: '#3B5C42',
        backgroundColor: 'rgba(59,92,66,0.1)',
        tension: 0.3,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } }
      }
    }
  });

  new Chart(document.getElementById('chartStatusBulanan'), {
    type: 'doughnut',
    data: {
      labels: Object.keys(statusData).map(k => statusLabelMap[k] ?? k),
      datasets: [{
        data: Object.values(statusData),
        backgroundColor: ['#3B5C42','#C79A2C','#B15A2B','#6E8A63','#C1442E','#8A8A8A'],
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } }
    }
  });
</script>
@endpush
