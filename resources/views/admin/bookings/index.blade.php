@extends('layouts.admin')

@section('title', 'Transaksi Booking')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Transaksi Booking</h4>
        <div class="text-muted">Antrian, metode bayar (QRIS / transfer), dan status pembayaran otomatis.</div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle datatable" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Kode antrian</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Jadwal</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><span class="font-monospace fw-semibold">{{ $b->queue_code ?? '—' }}</span></td>
                    <td>
                        <div class="small">{{ $b->customer_name }}</div>
                        <div class="text-muted small">{{ $b->customer_email }}</div>
                    </td>
                    <td>{{ $b->service?->name ?? '—' }}</td>
                    <td class="small">{{ $b->booking_date?->format('d/m/Y') }}<br>{{ substr($b->booking_time, 0, 5) }}</td>
                    <td>Rp {{ number_format($b->amount ?? 0, 0, ',', '.') }}</td>
                    <td>
                        @if($b->payment_method === \App\Models\Booking::METHOD_QRIS)
                            <span class="badge text-bg-info text-dark">QRIS</span>
                        @elseif($b->payment_method === \App\Models\Booking::METHOD_BANK_TRANSFER)
                            <span class="badge text-bg-primary">Transfer</span>
                        @else
                            <span class="badge text-bg-secondary">—</span>
                        @endif
                    </td>
                    <td>
                        @if($b->payment_status === \App\Models\Booking::PAYMENT_PAID)
                            <span class="badge text-bg-success">Lunas</span>
                        @else
                            <span class="badge text-bg-warning text-dark">Belum</span>
                        @endif
                    </td>
                    <td><span class="badge text-bg-light text-dark border">{{ $b->status }}</span></td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.bookings.show', $b) }}"><i class="fas fa-eye"></i></a>
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
        language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ entri' }
    });
});
</script>
@endsection
