@extends('layouts.app')

@section('title', 'Persyaratan Calon Penghuni')

@section('content')
<div id="persyaratanApp" v-cloak>

    {{-- HERO IMAGE --}}
    <div class="hero-image-requirements">
        @if(isset($settings['persyaratan_image']))
            <img src="{{ asset('storage/' . $settings['persyaratan_image']) }}"
                 alt="Header Persyaratan"
                 class="w-100 h-auto"
                 style="object-fit: cover; max-height: 400px;">
        @else
            <img src="{{ asset('assets/images/persyaratan.png') }}"
                 alt="Header Persyaratan"
                 class="w-100 h-auto"
                 style="object-fit: cover;">
        @endif
    </div>

    {{-- CONTENT --}}
    <section class="content-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="content-paper">
                        <h2>Siapa yang dapat menjadi penghuni panti?</h2>

                        <div class="intro-text">
                            {!! nl2br(e($settings['persyaratan'] ?? "Kami dengan tangan terbuka menyambut para lansia yang ingin bergabung...\n\n1. Berusia 60 tahun ke atas.\n2. Tidak mengidap gangguan kejiwaan...")) !!}
                        </div>
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
            initProfilPageVue('persyaratanApp');
        }
    });
</script>
@endpush
