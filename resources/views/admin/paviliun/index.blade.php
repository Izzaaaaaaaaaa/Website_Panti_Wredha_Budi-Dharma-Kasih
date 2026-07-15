@extends('layouts.admin')

@section('title', 'Kelola Paviliun & Fasilitas')

@section('content')
<div class="page-title-banner">
    Kelola Data Paviliun & Fasilitas
</div>

<div class="glass-panel mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="m-0 text-white">Daftar Paviliun & Fasilitas Panti</h5>
        <a href="{{ route('admin.paviliun.create') }}" class="btn btn-light btn-sm">
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
                    <th>Nama Paviliun/Fasilitas</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pavilions as $p)
                <tr>
                    <td>
                        @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}" alt="Foto" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                    <td>{{ $p->name }}</td>
                    <td>{{ Str::limit($p->description, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.paviliun.edit', $p->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.paviliun.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                    <td colspan="4" class="text-center py-4">Belum ada data paviliun atau fasilitas.</td>
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
