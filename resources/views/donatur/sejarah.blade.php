@extends('layouts.app')

@section('title', 'Sejarah Singkat')

@section('content')
<div id="sejarahApp" v-cloak>

    {{-- PAGE HEADER --}}
    <section class="page-header pt-5 pb-0 text-center">
        <div class="container">
            <h1 class="main-title">SEJARAH SINGKAT</h1>
            <p class="subtitle">Panti "Budi Dharma Kasih" Purbalingga</p>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="profile-section pt-3 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    @if(isset($settings['sejarah_image']))
                        <img src="{{ asset('storage/' . $settings['sejarah_image']) }}"
                             alt="Gedung Panti Budi Dharma Kasih"
                             class="img-fluid rounded shadow w-100 mb-5">
                    @else
                        <img src="{{ asset('assets/images/gedung panti.png') }}"
                             alt="Gedung Panti Budi Dharma Kasih"
                             class="img-fluid rounded shadow w-100 mb-5">
                    @endif

                    <div class="history-text">
                        {!! nl2br(e($settings['sejarah'] ?? 'Sejarah yayasan ini dimulai pada tahun 1972...')) !!}
                    </div>

                </div>
            </div>
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
                    <button type="button"
                            class="btn btn-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button"
                            class="btn btn-danger rounded-pill px-4"
                            @click="confirmLogout">
                        Ya, Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/profil-pages-vue.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof initProfilPageVue === 'function') {
            initProfilPageVue('sejarahApp');
        }
    });
</script>
@endpush
