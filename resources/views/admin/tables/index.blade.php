@extends('layouts.admin')
@section('title', 'Manajemen Meja & QR')

@push('styles')
<link rel="stylesheet" href="{{ asset('style-orders.css') }}">
<link rel="stylesheet" href="{{ asset('style-farmer-form.css') }}">
@endpush

@section('content')
<div class="page-header">
  <h1>Manajemen Meja &amp; QR</h1>
</div>

<p style="color:var(--text-mid);font-size:.9rem;max-width:60ch;margin-bottom:1.2rem;">
  Setiap meja punya QR sendiri yang mengarah ke halaman menu — pelanggan tinggal scan dari meja untuk pesan mandiri tanpa perlu login (SRS 3.4.1). Cetak dan tempel QR di masing-masing meja.
</p>

<div class="form-card" style="margin-bottom:1.6rem;max-width:none;">
  <form method="POST" action="{{ route('admin.tables.store') }}">
    @csrf
    <div class="form-grid">
      <div class="form-group">
        <label for="nomor">Nomor Meja <span style="color:#c0392b">*</span></label>
        <input type="text" id="nomor" name="nomor" value="{{ old('nomor') }}"
               maxlength="20" placeholder="cth. 1" required>
        @error('nomor')<div class="field-err">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label for="keterangan">Keterangan (opsional)</label>
        <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}"
               maxlength="100" placeholder="cth. dekat jendela">
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn-primary">+ Tambah Meja</button>
    </div>
  </form>
</div>

<table class="data-table">
  <thead>
    <tr>
      <th>Nomor</th>
      <th>Keterangan</th>
      <th>Status</th>
      <th>QR Code</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($tables as $table)
    <tr>
      <td style="font-weight:500;">Meja {{ $table->nomor }}</td>
      <td style="font-size:.85rem;color:var(--text-mid);">{{ $table->keterangan ?: '—' }}</td>
      <td>
        <span class="badge {{ $table->is_active ? 'badge-ready' : 'badge-cancelled' }}">
          {{ $table->is_active ? 'Aktif' : 'Nonaktif' }}
        </span>
      </td>
      <td>
        <img src="{{ route('admin.tables.qr', $table) }}" alt="QR Meja {{ $table->nomor }}"
             style="width:64px;height:64px;border:1px solid var(--border);border-radius:4px;">
      </td>
      <td>
        <div style="display:flex;gap:.4rem;align-items:center;flex-wrap:wrap;">
          <a href="{{ route('admin.tables.qr', ['table' => $table, 'download' => 1]) }}" class="btn-edit">Unduh QR</a>
          <form method="POST" action="{{ route('admin.tables.toggle', $table) }}">
            @csrf
            <button type="submit" class="btn-edit">{{ $table->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
          </form>
          <form method="POST" action="{{ route('admin.tables.destroy', $table) }}"
                onsubmit="return confirm('Hapus meja ini? QR yang sudah dicetak tidak akan berfungsi lagi.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">Hapus</button>
          </form>
        </div>
      </td>
    </tr>
    @empty
    <tr class="empty-row">
      <td colspan="5">Belum ada meja terdaftar.</td>
    </tr>
    @endforelse
  </tbody>
</table>
@endsection
