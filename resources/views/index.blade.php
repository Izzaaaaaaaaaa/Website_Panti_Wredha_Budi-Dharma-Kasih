@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div id="homepageApp" v-cloak>

    <!-- HERO CAROUSEL -->
            <section id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner hero-carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets/images/FotoKegiatan1.jpg') }}" class="d-block w-100 hero-slide-img" alt="Slide Kegiatan 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/images/FotoKegiatan2.jpg') }}" class="d-block w-100 hero-slide-img" alt="Slide Kegiatan 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/images/FotoKegiatan3.jpg') }}" class="d-block w-100 hero-slide-img" alt="Slide Kegiatan 3">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </section>

            <!-- MAIN HEADER -->
            <section class="main-header text-center">
                <div class="container">
                    <div class="header-text">
                        <h1>Yayasan Panti Wredha</h1>
                        <h2>"Budi Dharma Kasih" Purbalingga</h2>
                    </div>
                    <p class="subtitle">{{ $settings['motto'] ?? 'Merawat dengan Hati, Melayani dengan Kasih' }}</p>
                </div>
            </section>

            <!-- ABOUT SECTION 1 -->
            <section class="about pb-5">
                <div class="container">
                    <div class="info-box glass-effect">
                            {{ $settings['visi'] ?? '"Kasih Kristus Untuk Semua" menjadi semangat kami dalam melayani dan mendampingi para lanjut usia menjalani hari tua yang penuh makna, kedamaian, dan kebahagiaan.' }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- GALLERY SECTION -->
            <section class="gallery-section py-4">
                <div class="container">
                    <h2 class="mb-5">DOKUMENTASI KEGIATAN KAMI</h2>
                    
                    <div class="row g-4 gallery-grid-bootstrap">
                        <div class="col-lg-4 col-md-6 gallery-item-vue" v-for="(img, index) in paginatedImages" :key="index">
                            <a href="#" data-bs-toggle="modal" :data-bs-target="'#popup-' + index">
                                <img :src="img.src" :alt="img.alt" class="gallery-image">
                            </a>
                            
                            <div class="modal fade gallery-modal" :id="'popup-' + index" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button class="btn-close-custom" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
                                            <img :src="img.src" :alt="img.alt">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav class="mt-5" v-if="totalPages > 1">
                        <ul class="pagination justify-content-center align-items-center gap-2">

                            <!-- PREV -->
                            <li class="page-item">
                                <a
                                    class="page-link"
                                    href="#"
                                    @click.prevent="prevPage"
                                >
                                    « PREV
                                </a>
                            </li>

                            <!-- PAGE NUMBER -->
                            <li
                                class="page-item"
                                v-for="page in totalPages"
                                :key="page"
                                :class="{ active: currentPage === page }"
                            >
                                <a
                                    class="page-link page-num"
                                    href="#"
                                    @click.prevent="setPage(page)"
                                >
                                    @{{ page }}
                                </a>
                            </li>

                            <!-- NEXT -->
                            <li class="page-item">
                                <a
                                    class="page-link"
                                    href="#"
                                    @click.prevent="nextPage"
                                >
                                    NEXT »
                                </a>
                            </li>

                        </ul>

                        <!-- PAGE INFO -->
                        <div class="text-center mt-3 text-muted small">
                            Page @{{ currentPage }} of @{{ totalPages }}
                        </div>
                    </nav>
                </div>
            </section>

            
            <!-- ABOUT SECTION 2 -->
            <section class="about py-5">
                <div class="container">
                    <div class="info-box info-box-berlogo">
                        <p class="about-quote">{{ $settings['misi'] ?? '"Dengan Kasih Kristus Sebagai Dasar Pelayanan Kami mendorong keluarga, masyarakat, dan semua pihak untuk bersama-sama menciptakan masa tua yang penuh cinta, sejahtera, dan bermartabat bagi para lansia. Panti Wredha Budi Dharma Kasih bukan hanya tempat tinggal—ini adalah rumah kami."' }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- PAVILIUN SECTION -->
            <section class="paviliun-section py-5">
                <div class="container">
                    <div class="paviliun-header text-center mb-5">
                        <h2 class="sub-title">FASILITAS & PAVILIUN KAMI</h2>
                    </div>

                    <div class="row g-4">
                        @forelse($pavilions as $pavilion)
                            <div class="col-lg-4 col-md-6">
                                <div class="paviliun-item">
                                    @if($pavilion->image)
                                        <img src="{{ asset('storage/' . $pavilion->image) }}" class="card-img-top" alt="{{ $pavilion->name }}">
                                    @else
                                        <img src="{{ asset('assets/images/pav1.jpg') }}" class="card-img-top" alt="{{ $pavilion->name }}">
                                    @endif
                                    <p>{{ strtoupper($pavilion->name) }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted">Belum ada fasilitas/paviliun.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- CTA BANNER -->
            <section class="cta-banner py-5">
                <div class="container">
                    <div class="cta-content text-center">
                        <a href="{{ url('donatur/donasi') }}" class="cta-button hero-cta">
                            <img src="{{ asset('assets/images/cta_donasi.png') }}" alt="Donate Icon" style="max-width: 350px;">
                        </a>
                        <p class="cta-message mt-4">
                            Untuk informasi lebih lanjut, silahkan menghubungi kami:
                        </p>
                        <div class="contact-info">
                            @if(isset($settings['telepon']))
                                <a href="tel:{{ $settings['telepon'] }}"><i class="fas fa-phone"></i> {{ $settings['telepon'] }}</a>
                            @endif
                            @if(isset($settings['email']))
                                <a href="mailto:{{ $settings['email'] }}"><i class="fas fa-envelope"></i> {{ $settings['email'] }}</a>
                            @endif
                            @if(isset($settings['alamat']))
                                <a href="https://share.google/s2MmzsEeRxtT1BgNj" target="_blank" class="d-block text-white mt-2" style="text-decoration: none;">
                                    <i class="fas fa-map-marker-alt"></i> {{ $settings['alamat'] }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
</div>
@endsection

@push('scripts')
<script>
    window.galleryData = @json($galleries->map(function($g) {
        return ['src' => asset('storage/' . $g->image), 'alt' => $g->caption ?? 'Dokumentasi Kegiatan'];
    }));
</script>
<script src="{{ asset('assets/js/homepage-vue.js') }}"></script>
@endpush

