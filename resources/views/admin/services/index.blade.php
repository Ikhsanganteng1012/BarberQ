@extends('layouts.admin')

@section('title', 'Layanan')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Layanan</h4>
        <div class="text-muted">Harga, durasi, dan visibilitas di situs publik.</div>
    </div>
    <a class="btn btn-admin-add" href="{{ route('admin.services.create') }}"><i class="fas fa-plus me-1"></i> Tambah</a>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle datatable" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Durasi (menit)</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $s->name }}</td>
                    <td>Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                    <td>{{ $s->duration }}</td>
                    <td>
                        @if($s->is_active)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.services.edit', $s) }}"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('admin.services.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus layanan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
$(function () {
    $('.datatable').DataTable({ pageLength: 10, language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ entri' } });
});
</script>
@endsection
