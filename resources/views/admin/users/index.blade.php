@extends('layouts.admin')

@section('title', $customersOnly ? 'Data Customer' : 'Data User')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $customersOnly ? 'Data Customer' : 'Data User' }}</h4>
        <div class="text-muted">Kelola role, status aktif, dan pencarian.</div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle datatable" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Email</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $u)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $u->email }}</td>
                    <td class="fw-semibold">{{ $u->name }}</td>
                    <td>
                        @if($u->is_admin)
                            @if($u->id === 1)
                                <span class="badge text-bg-success">Super Admin</span>
                            @else
                                <span class="badge text-bg-success">Admin</span>
                            @endif
                        @else
                            <span class="badge text-bg-secondary">User</span>
                        @endif
                    </td>
                    <td>
                        @if($u->is_active)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <form method="POST" action="{{ route('admin.users.role', $u) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="is_admin" value="{{ $u->is_admin ? 0 : 1 }}">
                                <button class="btn btn-sm btn-primary" type="submit" {{ $u->id === auth()->id() ? 'disabled' : '' }} title="Ubah role">
                                    <i class="fas fa-user-tag"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.active', $u) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="is_active" value="{{ $u->is_active ? 0 : 1 }}">
                                <button class="btn btn-sm btn-warning text-dark" type="submit" {{ $u->id === auth()->id() ? 'disabled' : '' }} title="Aktif/nonaktif">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </form>
                        </div>
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
        order: [[0, 'asc']],
        language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ entri', info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri' }
    });
});
</script>
@endsection
