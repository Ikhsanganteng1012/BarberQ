<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Antrian {{ $booking->queue_code }} — BarberShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
            .print-wrap { box-shadow: none !important; border: none !important; }
        }
        body { background: #f5f5f5; padding: 1rem; }
        .print-wrap {
            max-width: 420px;
            margin: 0 auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }
    </style>
</head>
<body>
<div class="no-print text-center mb-3">
    <button type="button" class="btn btn-dark" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
    <button type="button" class="btn btn-outline-secondary" onclick="window.close()">Tutup</button>
</div>
<div class="print-wrap text-center">
    <div class="fw-bold mb-1">BarberShop — Antrian</div>
    <div class="text-muted small mb-3">{{ $booking->service?->name }} · {{ $booking->booking_date?->format('d/m/Y') }} {{ substr((string) $booking->booking_time, 0, 5) }}</div>
    <div class="fs-5 fw-bold font-monospace text-primary mb-2">{{ $booking->queue_code }}</div>
    <svg id="printBarcode"></svg>
    <div class="small text-muted mt-3">{{ $booking->customer_name }}</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    try {
        JsBarcode('#printBarcode', @json($booking->queue_code), {
            format: 'CODE128',
            displayValue: true,
            fontSize: 16,
            height: 70,
            width: 2,
            margin: 10
        });
    } catch (e) {}
});
</script>
</body>
</html>
