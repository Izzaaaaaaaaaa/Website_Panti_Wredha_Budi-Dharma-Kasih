@extends('layouts.admin')

@section('title', 'Edit Paviliun & Fasilitas')

@section('content')
<div class="page-title-banner">
    Edit Data: {{ $paviliun->name }}
</div>

<div class="glass-panel mt-4">
    <div class="section-head">Form Edit Paviliun & Fasilitas</div>

    <form action="{{ route('admin.paviliun.update', $paviliun->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label class="form-label text-white">Nama Paviliun/Fasilitas *</label>
            <input type="text" name="name" class="form-control" value="{{ $paviliun->name }}" required>
        </div>
        
        <div class="form-group mb-3">
            <label class="form-label text-white">Deskripsi Singkat</label>
            <textarea name="description" class="form-control" rows="4">{{ $paviliun->description }}</textarea>
        </div>
        
        <div class="form-group mb-3">
            <label class="form-label text-white">Foto Saat Ini</label>
            @if($paviliun->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $paviliun->image) }}" alt="Foto" style="max-width: 200px; border-radius: 8px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-white-50">Biarkan kosong jika tidak ingin mengubah foto.</small>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('admin.paviliun.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5c7a; border-color: #1a5c7a;">
                <i class="fas fa-save"></i> Simpan Perubahan
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
