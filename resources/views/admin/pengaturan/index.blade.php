@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="page-title-banner">
    Pengaturan Teks Website
</div>

<div class="glass-panel mt-4">
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Nav tabs -->
        <ul class="nav nav-tabs custom-tabs mb-4" id="settingTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="umum-tab" data-bs-toggle="tab" data-bs-target="#umum" type="button" role="tab">Profil & Kontak</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sejarah-tab" data-bs-toggle="tab" data-bs-target="#sejarah" type="button" role="tab">Sejarah</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="visimisi-tab" data-bs-toggle="tab" data-bs-target="#visimisi" type="button" role="tab">Visi, Misi & Motto</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="persyaratan-tab" data-bs-toggle="tab" data-bs-target="#persyaratan" type="button" role="tab">Persyaratan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="donasi-tab" data-bs-toggle="tab" data-bs-target="#donasi" type="button" role="tab">Donasi & Rekening</button>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" id="settingTabsContent">
            
            <!-- TAB: UMUM -->
            <div class="tab-pane fade show active" id="umum" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Nomor Telepon/WA</label>
                            <input type="text" name="telepon" class="form-control" value="{{ $settings['telepon'] ?? '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ $settings['alamat'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: SEJARAH -->
            <div class="tab-pane fade" id="sejarah" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Foto/Gambar Sejarah (Opsional)</label>
                            <div class="mb-2">
                                @if(isset($settings['sejarah_image']))
                                    <img src="{{ asset('storage/' . $settings['sejarah_image']) }}" alt="Foto Sejarah" class="img-thumbnail" style="max-height: 150px;">
                                @else
                                    <span class="text-muted fst-italic" style="color: #ccc!important;">Belum ada foto khusus, gambar default akan digunakan.</span>
                                @endif
                            </div>
                            <input type="file" name="sejarah_image" class="form-control" accept="image/*">
                            <small style="color: #ddd;">Kosongkan jika tidak ingin mengubah gambar.</small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Teks Sejarah Singkat</label>
                            <textarea name="sejarah" class="form-control" rows="8">{{ $settings['sejarah'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: VISI MISI -->
            <div class="tab-pane fade" id="visimisi" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Motto</label>
                            <input type="text" name="motto" class="form-control" value="{{ $settings['motto'] ?? '' }}" placeholder="Contoh: Kasih Kristus Untuk Semuanya">
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Visi Yayasan</label>
                            <textarea name="visi" class="form-control" rows="3">{{ $settings['visi'] ?? '' }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Misi Yayasan</label>
                            <textarea name="misi" class="form-control" rows="6">{{ $settings['misi'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: PERSYARATAN -->
            <div class="tab-pane fade" id="persyaratan" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Foto/Gambar Persyaratan (Opsional)</label>
                            <div class="mb-2">
                                @if(isset($settings['persyaratan_image']))
                                    <img src="{{ asset('storage/' . $settings['persyaratan_image']) }}" alt="Foto Persyaratan" class="img-thumbnail" style="max-height: 150px;">
                                @else
                                    <span class="text-muted fst-italic" style="color: #ccc!important;">Menggunakan gambar default.</span>
                                @endif
                            </div>
                            <input type="file" name="persyaratan_image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Syarat & Ketentuan Masuk Panti</label>
                            <textarea name="persyaratan" class="form-control" rows="10" placeholder="Ketikkan persyaratan dalam bentuk teks atau list...">{{ $settings['persyaratan'] ?? '' }}</textarea>
                            <small style="color: #ddd;">Teks ini akan muncul di halaman Persyaratan calon penghuni panti.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: DONASI -->
            <div class="tab-pane fade" id="donasi" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Teks Pengantar Halaman Donasi</label>
                            <textarea name="donasi_intro" class="form-control" rows="3" placeholder="Contoh: Apabila Ibu/Bapak/Saudara/i tergerak...">{{ $settings['donasi_intro'] ?? '' }}</textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Teks Penutup Halaman Donasi</label>
                            <textarea name="donasi_closing" class="form-control" rows="3" placeholder="Contoh: Sekali lagi terima kasih atas semua dukungan...">{{ $settings['donasi_closing'] ?? '' }}</textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Teks Instruksi Formulir Donasi</label>
                            <textarea name="instruksi_donasi" class="form-control" rows="3">{{ $settings['instruksi_donasi'] ?? '' }}</textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Informasi Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" class="form-control" value="{{ $settings['nomor_rekening'] ?? '' }}" placeholder="Contoh: BCA 123456789 a/n Panti Wredha">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Gambar QRIS (Opsional)</label>
                            <div class="mb-2">
                                @if(isset($settings['qris_image']))
                                    <img src="{{ asset('storage/' . $settings['qris_image']) }}" alt="QRIS" class="img-thumbnail" style="max-height: 150px;">
                                @else
                                    <span class="text-muted fst-italic" style="color: #ccc!important;">Belum ada QRIS yang diunggah.</span>
                                @endif
                            </div>
                            <input type="file" name="qris_image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label text-white fw-bold">Banner Halaman Donasi (Opsional)</label>
                            <div class="mb-2">
                                @if(isset($settings['donasi_image']))
                                    <img src="{{ asset('storage/' . $settings['donasi_image']) }}" alt="Banner Donasi" class="img-thumbnail" style="max-height: 150px;">
                                @else
                                    <span class="text-muted fst-italic" style="color: #ccc!important;">Menggunakan gambar default.</span>
                                @endif
                            </div>
                            <input type="file" name="donasi_image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group mb-4 mt-4 border-top pt-4" style="border-color: rgba(255,255,255,0.2) !important;">
                            <label class="form-label text-white fw-bold">Judul Kartu Donasi Barang</label>
                            <input type="text" name="donasi_barang_title" class="form-control" value="{{ $settings['donasi_barang_title'] ?? 'Donasi Barang' }}" placeholder="Contoh: Donasi Barang">
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Deskripsi Kartu Donasi Barang</label>
                            <textarea name="donasi_barang_desc" class="form-control" rows="2" placeholder="Contoh: Berupa sembako, pakaian...">{{ $settings['donasi_barang_desc'] ?? 'Berupa sembako, pakaian layak pakai, alat kesehatan, dll.' }}</textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Judul Kartu Donasi Tunai</label>
                            <input type="text" name="donasi_tunai_title" class="form-control" value="{{ $settings['donasi_tunai_title'] ?? 'Donasi Tunai' }}" placeholder="Contoh: Donasi Tunai">
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label text-white fw-bold">Deskripsi Kartu Donasi Tunai</label>
                            <textarea name="donasi_tunai_desc" class="form-control" rows="2" placeholder="Contoh: Donasi dalam bentuk uang...">{{ $settings['donasi_tunai_desc'] ?? 'Donasi dalam bentuk uang tunai atau transfer bank.' }}</textarea>
                        </div>
                    </div> <!-- End col-md-6 -->
                </div> <!-- End row -->
            </div> <!-- End tab-pane donasi -->
            
        </div> <!-- End tab-content -->
        
        <div class="text-end mt-5 border-top pt-3" style="border-color: rgba(255,255,255,0.2) !important;">
            <button type="submit" class="btn btn-primary btn-lg px-5" style="background-color: #1a5c7a; border-color: #1a5c7a;">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<style>
.custom-tabs .nav-link {
    color: rgba(255, 255, 255, 0.9) !important;
    border: none;
    border-bottom: 3px solid transparent;
    font-weight: 600;
    padding: 10px 20px;
}
.custom-tabs .nav-link:hover {
    border-color: transparent;
    color: #fff !important;
}
.custom-tabs .nav-link.active {
    background-color: transparent !important;
    color: #fff !important;
    border-color: transparent transparent #27ae60 transparent !important;
}
</style>
@endsection

@push('scripts')
<script>
    const { createApp, ref, onMounted } = Vue;
    createApp({
        setup() {
            const isLoading = ref(false);
            
            // Common admin sidebar state
            const activePage = ref('cms');
            const currentUrl = ref(window.location.href);

            const logoutAdmin = () => {
                if (confirm('Yakin ingin keluar?')) {
                    fetch('/api/logout', { method: 'POST', headers: { 'Authorization': 'Bearer ' + localStorage.getItem('admin_token') } })
                        .finally(() => {
                            localStorage.removeItem('admin_token');
                            window.location.href = '/login';
                        });
                }
            };

            return { isLoading, activePage, currentUrl, logoutAdmin };
        }
    }).mount('#adminApp');
</script>
@endpush
