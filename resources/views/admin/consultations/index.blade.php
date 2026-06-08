@extends('layouts.admin')

@section('title', 'Konsultasi')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Konsultasi</h4>
            <div class="text-muted">Lihat konsultasi masuk dan balas rekomendasi model rambut.</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex flex-wrap gap-2">
            @php
                $tabs = [
                    'pending' => 'Pending',
                    'replied' => 'Replied',
                    'closed' => 'Closed',
                ];
            @endphp
            @foreach($tabs as $key => $label)
                <a class="btn {{ $status === $key ? 'btn-dark' : 'btn-outline-dark' }}"
                   href="{{ route('admin.consultations.index', ['status' => $key]) }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($consultations->count() === 0)
                <div class="text-muted">Tidak ada data.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Diajukan</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultations as $c)
                                <tr>
                                    <td class="text-muted">#{{ $c->id }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $c->user->name }}</div>
                                        <div class="text-muted small">{{ $c->user->email }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $badge = match($c->status) {
                                                'replied' => 'success',
                                                'closed' => 'secondary',
                                                default => 'warning',
                                            };
                                        @endphp
                                        <span class="badge text-bg-{{ $badge }}">{{ strtoupper($c->status) }}</span>
                                    </td>
                                    <td class="text-muted">{{ $c->created_at->format('d M Y H:i') }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-dark" href="{{ route('admin.consultations.show', $c) }}">Buka</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @if($consultations->hasPages())
            <div class="card-footer bg-white border-0">
                {{ $consultations->links() }}
            </div>
        @endif
    </div>
@endsection

