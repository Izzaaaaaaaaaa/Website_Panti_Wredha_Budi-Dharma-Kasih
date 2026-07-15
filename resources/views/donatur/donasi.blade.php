@extends('layouts.app')

@section('title', 'Donasi')

@section('content')
<div id="donasiPilihanApp" v-cloak>

    {{-- HERO IMAGE --}}
    <section class="text-center p-0">
        @if(isset($settings['donasi_image']))
            <img src="{{ asset('storage/' . $settings['donasi_image']) }}" alt="Banner Donasi" class="hero-banner-full">
        @else
            <img src="{{ asset('assets/images/bakti sosial.png') }}"
                 alt="Bakti Sosial Panti Wredha"
                 class="hero-banner-full">
        @endif
    </section>

    {{-- KONTEN DONASI --}}
    <section class="pb-5 pt-4" style="background-color: var(--color-light-bg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="donasi-direct-content">

                        <p>
                            {!! nl2br(e($settings['donasi_intro'] ?? "Apabila Ibu/Bapak/Saudara/i tergerak untuk memberikan bantuan dan dukungan...\nSilahkan menghubungi kami...")) !!}
                        </p>

                        <h3>Ungkapan Kasih / Donasi dapat ditransfer ke rekening:</h3>

                        <p>
                            {!! nl2br(e($settings['nomor_rekening'] ?? "BCA KCP Pondok Indah, No. rekening xxxxxxxxxxx atas nama Yayasan BDK\nMandiri KCP Purbalingga, No. rekening xxxxxxxxxxx atas nama Yayasan BDK")) !!}
                        </p>
                        
                        @if(isset($settings['qris_image']))
                        <div class="my-4">
                            <h4>Scan QRIS:</h4>
                            <img src="{{ asset('storage/' . $settings['qris_image']) }}" alt="QRIS" class="img-fluid" style="max-height: 250px;">
                        </div>
                        @endif

                        <p>
                            {!! nl2br(e($settings['donasi_closing'] ?? "Sekali lagi terima kasih atas semua dukungan dan bersama ini kami sampaikan\nsalam sukacita dari Oma dan Opa di Panti Wredha Budi Dharma Kasih.")) !!}
                        </p>

                        {{-- TOMBOL DONASI (DISAMAIN DENGAN HTML LAMA) --}}
                        <div class="donasi-buttons">
                            <button
                                class="btn btn-donasi"
                                @click="pilihDonasi('barang')">
                                Formulir Donasi Barang
                            </button>

                            <button
                                class="btn btn-donasi"
                                @click="pilihDonasi('tunai')">
                                Formulir Donasi Tunai
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/donasi-pilihan.js') }}"></script>
@endpush
