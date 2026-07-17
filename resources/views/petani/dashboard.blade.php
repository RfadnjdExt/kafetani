@extends('layouts.petani')
@section('title', 'Dashboard Petani')

@push('styles')
<link rel="stylesheet" href="{{ asset('style-dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('style-produk.css') }}">
@endpush

@section('content')
<div class="page-header">
  <div>
    <h1>Halo, {{ $farmer->name }}</h1>
    <p style="font-size:.85rem;color:var(--text-mid);margin-top:.3rem">Ringkasan produk marketplace milik anda.</p>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <h3>Total Produk</h3>
    <span class="stat-num">{{ $stats['total_produk'] }}</span>
  </div>
  <div class="stat-card">
    <h3>Menunggu Review</h3>
    <span class="stat-num">{{ $stats['total_pending'] }}</span>
  </div>
  <div class="stat-card">
    <h3>Disetujui</h3>
    <span class="stat-num">{{ $stats['total_approved'] }}</span>
  </div>
  <div class="stat-card">
    <h3>Total Terjual (pcs)</h3>
    <span class="stat-num">{{ $stats['total_terjual'] }}</span>
  </div>
</div>

<div class="quick-actions" style="margin-bottom:2rem;">
  <a href="{{ route('petani.produk.index') }}" class="btn-primary">+ Daftarkan Produk Baru</a>
  <a href="{{ route('petani.profil') }}" class="btn-edit">Kelola Profil</a>
</div>

<h2 style="font-family:var(--ff-display);font-weight:300;font-size:1.5rem;color:var(--brown);margin-bottom:1rem;">Produk Terbaru</h2>
<table class="data-table">
  <thead>
    <tr>
      <th>Nama Produk</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @forelse($produkTerbaru as $prod)
    <tr>
      <td style="font-weight:500;">{{ $prod->nama_produk }}</td>
      <td>Rp {{ number_format($prod->harga, 0, ',', '.') }}</td>
      <td>{{ $prod->stok }}</td>
      <td><span class="badge badge-{{ $prod->status }}">{{ $prod->status }}</span></td>
    </tr>
    @empty
    <tr class="empty-row"><td colspan="4">anda belum mendaftarkan produk apa pun.</td></tr>
    @endforelse
  </tbody>
</table>

<h2 style="font-family:var(--ff-display);font-weight:300;font-size:1.5rem;color:var(--brown);margin:2rem 0 1rem;">Tren Kebutuhan Stok</h2>
<div class="charts-grid">
  <div class="chart-card" style="grid-column: span 2;">
    <h3>Tren Permintaan (14 Hari Terakhir)</h3>
    <canvas id="chartStockDemand" height="90"></canvas>
  </div>
  <div class="chart-card">
    <h3>Sisa Stok per Produk</h3>
    <canvas id="chartStokProduk" height="90"></canvas>
  </div>
</div>
@endsection

@push('styles')
<style>
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
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
  const stockDemandData = @json($charts['stock_demand_trend']);
  const stokProdukData  = @json($charts['stok_per_produk']);

  // Chart 1: Tren Kebutuhan Stok (line) — unit terjual per hari
  new Chart(document.getElementById('chartStockDemand'), {
    type: 'line',
    data: {
      labels: stockDemandData.map(d => d.label),
      datasets: [{
        label: 'Unit Terjual',
        data: stockDemandData.map(d => d.terjual),
        borderColor: '#3B5C42',
        backgroundColor: 'rgba(59,92,66,0.1)',
        tension: 0.3,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
    }
  });

  // Chart 2: Sisa Stok per Produk (bar) — urut dari yang paling menipis
  new Chart(document.getElementById('chartStokProduk'), {
    type: 'bar',
    data: {
      labels: stokProdukData.map(p => p.nama),
      datasets: [{
        label: 'Sisa Stok',
        data: stokProdukData.map(p => p.stok),
        backgroundColor: '#C79A2C',
      }]
    },
    options: {
      responsive: true,
      indexAxis: 'y',
      plugins: { legend: { display: false } },
      scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
    }
  });
</script>
@endpush
