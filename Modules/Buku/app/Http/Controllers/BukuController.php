<?php

namespace Modules\Buku\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Buku\Models\Buku;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $bukus = Buku::when($search, function($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('penulis', 'like', "%{$search}%");
            })
            ->paginate(5);

        return view('buku::index', compact('bukus', 'search'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('buku::create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'stok' => 'required|integer|min:0',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $buku = Buku::findOrFail($id);
        return view('buku::edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'stok' => 'required|integer|min:0',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }
}