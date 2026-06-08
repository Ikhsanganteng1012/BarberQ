@extends('layouts.admin')

@section('title', 'Galeri')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Galeri</h4>
        <div class="text-muted">Foto gaya potongan / katalog tampilan.</div>
    </div>
    <a class="btn btn-admin-add" href="{{ route('admin.galleries.create') }}"><i class="fas fa-plus me-1"></i> Tambah</a>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle datatable" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($galleries as $i => $g)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><img src="{{ asset('storage/'.$g->image) }}" alt="" width="56" height="56" class="rounded" style="object-fit:cover;"></td>
                    <td class="fw-semibold">{{ $g->title }}</td>
                    <td>
                        @if($g->is_active)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.galleries.edit', $g) }}"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('admin.galleries.destroy', $g) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?');">
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
    $('.datatable').DataTable({
        pageLength: 10,
        language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ entri' }
    });
});
</script>
@endsection
