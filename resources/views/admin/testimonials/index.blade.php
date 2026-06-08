@extends('layouts.admin')

@section('title', 'Testimoni')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Moderasi Testimoni</h4>
        <div class="text-muted">Testimoni dikirim oleh user. Admin hanya menyetujui atau menolak agar tampil di website.</div>
        @if($pendingCount > 0)
            <span class="badge text-bg-warning text-dark mt-2">{{ $pendingCount }} menunggu persetujuan</span>
        @endif
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle datatable" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Rating</th>
                <th>Pesan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testimonials as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-semibold">
                        {{ $t->name }}<br>
                        <small class="text-muted">{{ $t->email }}</small>
                        @if($t->user)
                            <br><small class="text-muted">User ID: {{ $t->user_id }}</small>
                        @endif
                    </td>
                    <td>
                        @for($s = 1; $s <= 5; $s++)
                            <i class="fas fa-star {{ $s <= $t->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        <div class="small text-muted">{{ $t->rating }}/5</div>
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($t->message, 80) }}</td>
                    <td>
                        @if($t->is_approved)
                            <span class="badge text-bg-success">Tampil di web</span>
                        @else
                            <span class="badge text-bg-warning text-dark">Menunggu</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        @if(! $t->is_approved)
                            <form action="{{ route('admin.testimonials.approve', $t) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.testimonials.reject', $t) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Sembunyikan">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus testimoni ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada testimoni dari user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
$(function () {
    $('.datatable').DataTable({ pageLength: 10, order: [[0, 'asc']], language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ entri' } });
});
</script>
@endsection
