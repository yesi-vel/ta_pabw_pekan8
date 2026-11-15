@extends('layouts.app')
@section('title', 'Daftar Buku - SiPustaka')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold">Daftar Buku Perpustakaan</h3>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">Tambah Buku</a>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif

                <form method="GET" action="{{ route('buku.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="{{ $search ?? '' }}">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Stok</th>
                                @if(auth()->user()->role === 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukus as $key => $buku)
                            <tr>
                                <td>{{ $bukus->firstItem() + $key }}</td>
                                <td>{{ $buku->judul }}</td>
                                <td>{{ $buku->penulis }}</td>
                                <td>{{ $buku->penerbit }}</td>
                                <td>{{ $buku->tahun_terbit }}</td>
                                <td>{{ $buku->stok }}</td>
                                @if(auth()->user()->role === 'admin')
                                    <td>
                                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}" class="text-center text-muted">Belum ada data buku.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $bukus->links() }}
            </div>
        </div>
    </div>
</div>
@endsection