@extends('layouts.app')

@section('title', 'Konsultasi')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Konsultasi Model Rambut</h2>
            <div class="text-muted">Upload selfie, admin akan rekomendasikan model yang cocok.</div>
        </div>
        <a class="btn btn-primary" href="{{ route('consultations.create') }}">
            <i class="fas fa-plus me-2"></i>Ajukan Konsultasi
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($consultations->count() === 0)
                <div class="text-muted">Belum ada konsultasi.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Diajukan</th>
                                <th>Admin</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultations as $c)
                                <tr>
                                    <td class="text-muted">#{{ $c->id }}</td>
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
                                    <td class="text-muted">{{ $c->admin?->name ?? '-' }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-dark" href="{{ route('consultations.show', $c) }}">Detail</a>
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
</div>
@endsection

