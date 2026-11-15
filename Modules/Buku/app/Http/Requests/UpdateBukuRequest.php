<?php

namespace Modules\Buku\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBukuRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
{
    return [
        'judul' => ['required', 'string', 'max:255'],
        'penulis' => ['required', 'string', 'max:255'],
        'penerbit' => ['required', 'string', 'max:255'],
        'tahun_terbit' => ['required', 'digits:4'],
        'stok' => ['required', 'integer', 'min:0'],
    ];
}

public function authorize(): bool
{
    return $this->user()?->isAdmin() ?? false; // Hanya admin yang boleh tambah/edit
}
}
