@extends('layouts.app')
@section('title', 'Manajemen Peminjaman - SiPustaka')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold">Manajemen Peminjaman Buku (AJAX)</h3>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#peminjamanModal" onclick="resetForm()">Tambah Peminjaman</button>
                </div>

                <div id="alert-container"></div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="peminjaman-table">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Bukti (PDF/IMG)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $key => $p)
                            <tr id="row-{{ $p->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $p->user->name ?? '-' }}</td>
                                <td>{{ $p->buku->judul ?? '-' }}</td>
                                <td>{{ $p->tanggal_pinjam }}</td>
                                <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                                <td><span class="badge bg-{{ $p->status == 'Dipinjam' ? 'warning' : 'success' }}">{{ $p->status }}</span></td>
                                <td>
                                    @if($p->bukti)
                                        <a href="{{ asset('storage/' . $p->bukti) }}" target="_blank" class="btn btn-sm btn-info text-white">Lihat Berkas</a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editPeminjaman({{ $p }})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deletePeminjaman({{ $p->id }})">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="peminjamanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formPeminjaman" enctype="multipart/form-data">
    @csrf
    
    <!-- Pilih Buku -->
    <div class="mb-3">
        <label for="buku_id" class="form-label">Pilih Buku</label>
        <select name="buku_id" id="buku_id" class="form-control">
            <option value="">-- Pilih Buku --</option>
            @foreach($bukus as $buku)
                <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
            @endforeach
        </select>
        <small class="text-danger error-buku_id"></small>
    </div>

    <!-- Tanggal Pinjam -->
    <div class="mb-3">
        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control">
        <small class="text-danger error-tanggal_pinjam"></small>
    </div>

    <!-- Tanggal Kembali -->
    <div class="mb-3">
        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
        <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control">
        <small class="text-danger error-tanggal_kembali"></small>
    </div>

    <!-- Upload Bukti -->
    <div class="mb-3">
        <label for="bukti" class="form-label">Bukti Peminjaman (JPG/PNG/PDF, Max 2MB)</label>
        <input type="file" name="bukti" id="bukti" class="form-control">
        <small class="text-danger error-bukti"></small>
    </div>

    <button type="button" id="btnSimpanPeminjaman" class="btn btn-primary">Simpan Peminjaman</button>
</form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Deklarasikan variabel global untuk mode edit
let editMode = false;
let editId = null;

// Fungsi Reset Form
function resetForm() {
    $('#formPeminjaman')[0].reset();
    editMode = false;
    editId = null;
    $('#status-group').hide(); // Sembunyikan pilihan status saat tambah baru
    $('#btnSimpanPeminjaman').text('Simpan Peminjaman');
    $('.text-danger').text('');
}

// Fungsi Edit Peminjaman (Mengambil data berdasarkan ID)
function editPeminjaman(id) {
    let url = "{{ route('peminjaman.edit', ':id') }}";
    url = url.replace(':id', id);

    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            editMode = true;
            editId = id;

            // Masukkan data ke input form
            $('#buku_id').val(response.buku_id);
            $('#tanggal_pinjam').val(response.tanggal_pinjam);
            $('#tanggal_kembali').val(response.tanggal_kembali);
            $('#status').val(response.status);
            
            // Tampilkan pilihan status khusus saat edit
            $('#status-group').show();
            
            // Ubah teks tombol modal jadi Perbarui
            $('#btnSimpanPeminjaman').text('Perbarui Peminjaman');
            
            // Tampilkan modal
            $('#peminjamanModal').modal('show');
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            alert('Gagal mengambil data: Status ' + xhr.status);
        }
    });
}

// Fungsi Hapus Peminjaman
function deletePeminjaman(id) {
    if (confirm('Apakah kamu yakin ingin menghapus data peminjaman ini?')) {
        $.ajax({
            url: "{{ url('peminjaman') }}/" + id,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Data berhasil dihapus');
                $('#row-' + id).remove();
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat menghapus data.');
            }
        });
    }
}

$(document).ready(function() {
    // Tombol Simpan / Perbarui Peminjaman
    $('#btnSimpanPeminjaman').click(function(e) {
        e.preventDefault();

        let formElement = $('#formPeminjaman')[0];
        let formData = new FormData(formElement);
        
        let url = "{{ route('peminjaman.store') }}";
        let type = "POST";

        if (editMode) {
            url = "{{ url('peminjaman') }}/" + editId;
            formData.append('_method', 'PUT'); // Spoofing method PUT untuk update
        }

        $('.text-danger').text('');

        $.ajax({
            url: url,
            type: type,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert(response.message || 'Berhasil disimpan');
                location.reload();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $('.error-' + field).text(messages[0]);
                    });
                } else {
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan pada server. Status: ' + xhr.status);
                }
            }
        });
    });
});
</script>
@endsection