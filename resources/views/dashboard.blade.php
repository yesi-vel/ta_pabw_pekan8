@extends('layouts.app')
@section('title', 'Dashboard - SiPustaka')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Selamat Datang di SiPustaka</h3>
                <p class="text-muted">Halo, <strong>{{ Auth::user()->name }}</strong>! Anda berhasil masuk ke sistem.</p>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="card bg-primary text-white shadow-sm">
                            <div class="card-body">
                                <h5>Total Peminjaman</h5>
                                <h3>{{ $totalPeminjaman }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-success text-white shadow-sm">
                            <div class="card-body">
                                <h5>Total Pengguna</h5>
                                <h3>{{ $totalUsers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection