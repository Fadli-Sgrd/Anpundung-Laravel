<?php

namespace Modules\Laporan\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Laporan\Models\Laporan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Kategori\Models\Kategori;
use Modules\Bukti\Models\Bukti;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LaporanController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Admin sees all reports; regular users see only their own
        if (Auth::check() && Auth::user()->role === 'admin') {
            $laporan = Laporan::with(['user', 'kategori', 'bukti'])->latest()->paginate(10);
        } else {
            $laporan = Laporan::with(['user', 'kategori', 'bukti'])
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }



        $kategori = Kategori::all()->sortBy(fn($k) => $k->nama_kategori === 'Lainnya' ? 1 : 0)->values();
        return Inertia::render('Laporan/Index', compact('laporan', 'kategori'));
    }


    /**
     * Menampilkan form tambah laporan
     */
    public function create()
    {
        $kategori = Kategori::all()->sortBy(fn($k) => $k->nama_kategori === 'Lainnya' ? 1 : 0)->values();


        return view('laporan::create', compact('kategori'));
    }


    /**
     * Simpan laporan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'alamat'       => 'required|string',
            'deskripsi'    => 'required|string',
            'id_kategori'  => 'required|exists:kategori_laporan,id',
            'bukti.*'      => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:5120',
        ]);

        $laporan = Laporan::create([
            'judul'           => $request->judul,
            'tanggal'         => $request->tanggal,
            'alamat'          => $request->alamat,
            'deskripsi'       => $request->deskripsi,
            'id_kategori'     => $request->id_kategori,
            'user_id'         => Auth::id(),
            'status_tindakan' => 'Pending'
        ]);

        // Handle uploaded bukti files (if any)
        if ($request->hasFile('bukti')) {
            $files = $request->file('bukti');
            foreach ($files as $file) {
                if (!$file->isValid()) continue;
                $path = $file->store('bukti', 'public');

                Bukti::create([
                    'kode_laporan' => $laporan->kode_laporan,
                    'jenis'        => $file->getClientOriginalExtension() === 'mp4' ? 'Video' : 'Gambar',
                    'path_file'    => $path,
                    'deskripsi'    => null,
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'kode_laporan' => $laporan->kode_laporan
            ]);
        }

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Detail laporan
     */
    public function show($kode_laporan)
    {
        $laporan = Laporan::with(['kategori', 'bukti', 'user'])
            ->where('kode_laporan', $kode_laporan)
            ->firstOrFail();

        // User can only see their own laporan (not for berita/public view)
        if (Auth::check() && Auth::user()->role !== 'admin') {
            if ($laporan->user_id !== Auth::id()) {
                abort(403, 'Unauthorized');
            }
        }

        return view('laporan::show', compact('laporan'));
    }


    /**
     * Update status laporan (admin only)
     */
    public function updateStatus(Request $request, $kode_laporan)
    {
        $laporan = Laporan::where('kode_laporan', $kode_laporan)->firstOrFail();
        
        // Authorize using policy
        $this->authorize('updateStatus', $laporan);

        $request->validate([
            'status_tindakan' => 'required|in:Pending,Proses,Selesai,Ditolak'
        ]);

        $laporan->update([
            'status_tindakan' => $request->status_tindakan
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui menjadi ' . $request->status_tindakan);
    }


    /**
     * Update laporan
     */
    public function update(Request $request, $kode_laporan)
    {
        $laporan = Laporan::where('kode_laporan', $kode_laporan)->firstOrFail();

        // Check auth
        if (Auth::user()->id !== $laporan->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Only allow update if pending
        if ($laporan->status_tindakan !== 'Pending') {
             return redirect()->back()->withErrors(['Laporan tidak dapat diedit karena sudah diproses.']);
        }

        $request->validate([
            'judul'        => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'alamat'       => 'required|string',
            'deskripsi'    => 'required|string',
            'id_kategori'  => 'required|exists:kategori_laporan,id',
            'bukti.*'      => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:5120',
        ]);

        $laporan->update([
            'judul'           => $request->judul,
            'tanggal'         => $request->tanggal,
            'alamat'          => $request->alamat,
            'deskripsi'       => $request->deskripsi,
            'id_kategori'     => $request->id_kategori,
        ]);

        // Handle uploaded bukti files (add new ones)
        if ($request->hasFile('bukti')) {
            $files = $request->file('bukti');
            foreach ($files as $file) {
                if (!$file->isValid()) continue;
                $path = $file->store('bukti', 'public');

                Bukti::create([
                    'kode_laporan' => $laporan->kode_laporan,
                    'jenis'        => $file->getClientOriginalExtension() === 'mp4' ? 'Video' : 'Gambar',
                    'path_file'    => $path,
                    'deskripsi'    => null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Hapus laporan
     */
    public function destroy($kode_laporan)
    {
        $laporan = Laporan::where('kode_laporan', $kode_laporan)->firstOrFail();

        // Check auth
        if (!Auth::check()) abort(403, 'Unauthorized');

        // Admin dapat menghapus semua; user hanya punya mereka sendiri
        $isAdmin = Auth::user()->role === 'admin';
        $isOwner = $laporan->user_id === Auth::id();

        if (!$isAdmin && !$isOwner) {
            abort(403, 'Unauthorized. Hanya admin atau pemilik yang bisa menghapus.');
        }

        // delete related bukti files
        foreach ($laporan->bukti as $b) {
            if ($b->path_file && Storage::disk('public')->exists($b->path_file)) {
                Storage::disk('public')->delete($b->path_file);
            }
            $b->delete();
        }

        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan dihapus');
    }
}
