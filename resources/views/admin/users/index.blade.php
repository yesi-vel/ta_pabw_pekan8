@extends('layouts.app')
@section('title', 'Manajemen Pengguna - SiPustaka')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold">Manajemen Pengguna (User Management)</h3>
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Tambah Pengguna</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger py-2">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $u)
                            <tr>
                                <td>{{ $users->firstItem() + $key }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $u->role == 'admin' ? 'danger' : 'secondary' }}">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection