@extends('layouts.app')

@section('title', 'Fasilitas Panti')

@section('content')
<div id="fasilitasApp" v-cloak>

    {{-- PAGE HEADER --}}
    <section class="page-header">
        <div class="container text-center">
            <h1 class="main-title">FASILITAS PANTI</h1>
            <p class="subtitle">Sarana penunjang kenyamanan para lansia di panti</p>
        </div>
    </section>

    {{-- FASILITAS LIST --}}
    <section class="py-5 pt-4">
        <div class="container">

            @forelse($pavilions as $index => $pavilion)
            <div class="row facility-item align-items-center {{ $index % 2 != 0 ? 'flex-lg-row-reverse' : '' }}">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    @if($pavilion->image)
                        <img src="{{ asset('storage/' . $pavilion->image) }}" alt="{{ $pavilion->name }}">
                    @else
                        <img src="{{ asset('assets/images/WhatsApp Image 2025-05-26 at 14.55.10_531d29d0 2.png') }}" alt="{{ $pavilion->name }}">
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="facility-text">
                        <h3>{{ $pavilion->name }}</h3>
                        <p>{{ $pavilion->description }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5 text-muted">
                <h4>Belum ada fasilitas/paviliun yang ditambahkan.</h4>
            </div>
            @endforelse

        </div>
    </section>

    {{-- LOGOUT MODAL --}}
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-danger">Konfirmasi Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-sign-out-alt fa-3x text-danger mb-3"></i>
                    <p class="mb-0 fw-medium fs-5">Apakah Anda yakin ingin keluar?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger rounded-pill px-4" @click="confirmLogout">
                        Ya, Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/fasilitas.js') }}"></script>
@endpush
