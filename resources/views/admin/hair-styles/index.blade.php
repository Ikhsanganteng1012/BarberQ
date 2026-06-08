@extends('layouts.admin')

@section('title', 'Model Rambut')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Model Rambut</h4>
            <div class="text-muted">Daftar model rambut untuk referensi & rekomendasi konsultasi.</div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-admin-add" href="{{ route('admin.hair-styles.create') }}">
                <i class="fas fa-plus me-2"></i>Tambah
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($hairStyles->count() === 0)
                <div class="text-muted">Belum ada model rambut.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hairStyles as $hs)
                                <tr>
                                    <td class="text-muted">#{{ $hs->id }}</td>
                                    <td class="fw-semibold">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($hs->image_path)
                                                <img src="{{ asset('storage/'.$hs->image_path) }}" alt="" width="44" height="44" class="rounded" style="object-fit:cover;">
                                            @else
                                                <div class="rounded bg-light border" style="width:44px;height:44px;"></div>
                                            @endif
                                            <div>
                                                <div>{{ $hs->name }}</div>
                                                <div class="text-muted small">{{ \Illuminate\Support\Str::limit($hs->description, 60) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($hs->is_active)
                                            <span class="badge text-bg-success">ACTIVE</span>
                                        @else
                                            <span class="badge text-bg-secondary">INACTIVE</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-dark" href="{{ route('admin.hair-styles.edit', $hs) }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @if($hairStyles->hasPages())
            <div class="card-footer bg-white border-0">
                {{ $hairStyles->links() }}
            </div>
        @endif
    </div>
@endsection

