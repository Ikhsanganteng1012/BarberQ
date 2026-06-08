@extends('layouts.admin')

@section('title', 'Detail Konsultasi')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Konsultasi #{{ $consultation->id }}</h4>
            <div class="text-muted">
                User: <span class="fw-semibold">{{ $consultation->user->name }}</span>
                <span class="text-muted">({{ $consultation->user->email }})</span>
            </div>
        </div>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.consultations.index', ['status' => $consultation->status]) }}">Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Selfie</div>
                    <img class="img-fluid rounded" src="{{ asset('storage/'.$consultation->selfie_path) }}" alt="Selfie">
                    <div class="text-muted small mt-2">Diajukan: {{ $consultation->created_at->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Catatan user</div>
                    <div class="text-muted" style="white-space: pre-wrap;">{{ $consultation->user_message ?? '-' }}</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="fw-semibold mb-3">Balas konsultasi</div>

                    @if ($errors->any())
                        <div class="alert alert-error" role="alert">
                            <div class="fw-semibold mb-1">Periksa input:</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.consultations.reply', $consultation) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="recommended_hair_style_id" class="form-label fw-semibold">Rekomendasi model (opsional)</label>
                            <select class="form-select" id="recommended_hair_style_id" name="recommended_hair_style_id">
                                <option value="">- Pilih -</option>
                                @foreach($hairStyles as $hs)
                                    <option value="{{ $hs->id }}" {{ (int) old('recommended_hair_style_id', $consultation->recommended_hair_style_id) === (int) $hs->id ? 'selected' : '' }}>
                                        {{ $hs->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="admin_message" class="form-label fw-semibold">Pesan admin</label>
                            <textarea class="form-control" id="admin_message" name="admin_message" rows="5" required>{{ old('admin_message', $consultation->admin_message) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                @php $current = old('status', $consultation->status); @endphp
                                <option value="pending" {{ $current === 'pending' ? 'selected' : '' }}>pending</option>
                                <option value="replied" {{ $current === 'replied' ? 'selected' : '' }}>replied</option>
                                <option value="closed" {{ $current === 'closed' ? 'selected' : '' }}>closed</option>
                            </select>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-save me-2"></i>Simpan Balasan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

