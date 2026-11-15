<?php

namespace Modules\Peminjaman\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeminjamanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
{
    $peminjaman = $this->route('peminjaman');
    return [
        'nama_peminjam' => ['required', 'string', 'max:255'],
        'judul_buku' => ['required', 'string', 'max:255'],
        'tanggal_pinjam' => ['required', 'date'],
        'tanggal_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
        'status' => ['required', 'string'],
        'berkas' => [$peminjaman ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
    ];
}
public function authorize(): bool { return true; }
}
