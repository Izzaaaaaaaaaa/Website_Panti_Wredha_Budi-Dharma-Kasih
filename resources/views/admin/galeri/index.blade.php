@extends('layouts.admin')

@section('title', 'Kelola Dokumentasi Kegiatan')

@section('content')
<div class="page-title-banner">
    Kelola Data Dokumentasi Kegiatan
</div>

<div class="glass-panel mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="m-0 text-white">Daftar Dokumentasi Kegiatan Panti</h5>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table-transparent">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Caption (Opsional)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $g)
                <tr>
                    <td>
                        @if($g->image)
                            <img src="{{ asset('storage/' . $g->image) }}" alt="Foto" style="width: 120px; height: 80px; object-fit: cover; border-radius: 4px;">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                    <td>{{ $g->caption ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.galeri.edit', $g->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus foto dokumentasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4">Belum ada data dokumentasi kegiatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
