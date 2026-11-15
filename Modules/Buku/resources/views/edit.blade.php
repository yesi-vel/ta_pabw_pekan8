@extends('layouts.app') {{-- Sesuaikan dengan layout utama projectmu --}}

@section('content')
<div class="container">
    <h2>Edit Buku</h2>

    <form action="{{ route('buku.update', $buku->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required>
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required>
        </div>

        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection