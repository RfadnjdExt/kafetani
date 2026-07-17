@extends('layouts.admin')
@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('style-dashboard.css') }}">
@endpush

@section('content')
<div class="page-header">
  <div>
    <h1>Ringkasan Bisnis</h1>
    <p style="font-size:.85rem;color:var(--text-mid);margin-top:.3rem">Selamat datang, {{ auth()->user()->nama }}. Statistik hari ini.</p>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <h3>Total Pendapatan</h3>
    <span class="stat-num">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</span>
  </div>
  <div class="stat-card">
    <h3>Total Pesanan</h3>
    <span class="stat-num">{{ $stats['total_pesanan'] }}</span>
  </div>
  <div class="stat-card">
    <h3>Produk Tersedia</h3>
    <span class="stat-num">{{ $stats['total_produk'] }}</span>
  </div>
  <div class="stat-card">
    <h3>Petani Mitra</h3>
    <span class="stat-num">{{ $stats['total_petani'] }}</span>
  </div>
</div>

<div class="quick-actions">
  <a href="{{ route('admin.products.index') }}" class="btn-primary">+ Tambah Produk Baru</a>
  <a href="{{ route('admin.farmers.create') }}" class="btn-primary">+ Daftarkan Petani</a>
  <a href="{{ route('admin.kasir') }}" class="btn-primary"><svg class="icon-inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg> Buka Kasir POS</a>
  <a href="{{ route('admin.orders.index') }}" class="btn-edit">Lihat Pesanan Masuk</a>
</div>

<div class="charts-grid">
  <div class="chart-card" style="grid-column: span 2;">
    <h3>Tren Pendapatan (7 Hari Terakhir)</h3>
    <canvas id="chartRevenue" height="90"></canvas>
  </div>
  <div class="chart-card">
    <h3>Status Pesanan</h3>
    <canvas id="chartStatus" height="90"></canvas>
  </div>
  <div class="chart-card">
    <h3>5 Produk Terlaris</h3>
    <canvas id="chartTopProducts" height="90"></canvas>
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
  const revenueData = @json($charts['revenue_trend']);
  const statusData  = @json($charts['status_breakdown']);
  const topProducts = @json($charts['top_products']);

  const statusLabelMap = {
    pending_payment: 'Menunggu Pembayaran',
    pending: 'Masuk',
    processing: 'Proses',
    ready: 'Siap',
    completed: 'Selesai',
    cancelled: 'Dibatalkan',
  };

  // Chart 1: Tren Pendapatan (line)
  new Chart(document.getElementById('chartRevenue'), {
    type: 'line',
    data: {
      labels: revenueData.map(d => d.label),
      datasets: [{
        label: 'Pendapatan (Rp)',
        data: revenueData.map(d => d.total),
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

  // Chart 2: Status Pesanan (doughnut)
  new Chart(document.getElementById('chartStatus'), {
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

  // Chart 3: Produk Terlaris (bar)
  new Chart(document.getElementById('chartTopProducts'), {
    type: 'bar',
    data: {
      labels: topProducts.map(p => p.nama),
      datasets: [{
        label: 'Terjual',
        data: topProducts.map(p => p.terjual),
        backgroundColor: '#3B5C42',
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
