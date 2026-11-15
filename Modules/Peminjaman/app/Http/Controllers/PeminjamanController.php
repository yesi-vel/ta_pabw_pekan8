<?php

namespace Modules\Peminjaman\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Peminjaman\Models\Peminjaman;
use Modules\Buku\Models\Buku;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        $bukus = Buku::all();
        
        return view('peminjaman::index', compact('peminjamans', 'bukus'));
        }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Maksimal 2MB
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_peminjaman', 'public');
        }

        $peminjaman = Peminjaman::create([
            'user_id' => auth()->id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'Dipinjam',
            'bukti' => $buktiPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil ditambahkan.',
            'data' => $peminjaman->load(['user', 'buku'])
        ]);
    }
    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        return response()->json($peminjaman);
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:Dipinjam,Dikembalikan',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $buktiPath = $peminjaman->bukti;
        if ($request->hasFile('bukti')) {
            if ($buktiPath && Storage::disk('public')->exists($buktiPath)) {
                Storage::disk('public')->delete($buktiPath);
            }
            $buktiPath = $request->file('bukti')->store('bukti_peminjaman', 'public');
        }

        $peminjaman->update([
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
            'bukti' => $buktiPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil diperbarui.',
            'data' => $peminjaman->load(['user', 'buku'])
        ]);
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Hapus file bukti dari storage jika ada
        if ($peminjaman->bukti && Storage::disk('public')->exists($peminjaman->bukti)) {
            Storage::disk('public')->delete($peminjaman->bukti);
        }

        $peminjaman->delete();

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil dihapus dan file bukti terhapus dari storage.'
        ]);
    }
}