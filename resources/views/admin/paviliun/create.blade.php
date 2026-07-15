@extends('layouts.admin')

@section('title', 'Tambah Paviliun & Fasilitas')

@section('content')
<div class="page-title-banner">
    Tambah Paviliun & Fasilitas Baru
</div>

<div class="glass-panel mt-4">
    <div class="section-head">Form Data Paviliun & Fasilitas</div>

    <form action="{{ route('admin.paviliun.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label class="form-label text-white">Nama Paviliun/Fasilitas *</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="form-group mb-3">
            <label class="form-label text-white">Deskripsi Singkat</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>
        
        <div class="form-group mb-3">
            <label class="form-label text-white">Foto</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        
        <div class="mt-4">
            <a href="{{ route('admin.paviliun.index') }}" class="btn btn-secondary">Batal</a>
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
