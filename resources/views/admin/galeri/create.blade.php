@extends('layouts.admin')

@section('title', 'Tambah Dokumentasi')

@section('content')
<div class="page-title-banner">
    Tambah Dokumentasi Baru
</div>

<div class="glass-panel mt-4">
    <div class="section-head">Form Data Dokumentasi</div>

    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label class="form-label text-white">Caption (Opsional)</label>
            <input type="text" name="caption" class="form-control" placeholder="Contoh: Kegiatan Pagi Bersama">
        </div>
        
        <div class="form-group mb-3">
            <label class="form-label text-white">Foto *</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5c7a; border-color: #1a5c7a;">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const { createApp, ref } = Vue;
    createApp({
        setup() {
            const isLoading = ref(false);
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
