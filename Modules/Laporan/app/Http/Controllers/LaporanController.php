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

        // Untuk AJAX request (bukan Inertia), set flash message dan return JSON
        if (($request->wantsJson() || $request->ajax()) && !$request->header('X-Inertia')) {
            // Set flash message hanya jika request dari React (karena React akan reload page)
            // Blade menggunakan toast JS lokal tanpa reload, jadi tidak butuh flash session
            if ($request->header('X-Client-Type') === 'React') {
                session()->flash('success', 'Laporan berhasil dikirim!');
            }
            
            return response()->json([
                'success' => true,
                'kode_laporan' => $laporan->kode_laporan,
                'message' => 'Laporan berhasil dikirim!'
            ]);
        }

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Update status laporan (admin only)
     */
    public function updateStatus(Request $request, $kode_laporan)
    {
        $laporan = Laporan::where('kode_laporan', $kode_laporan)->firstOrFail();
        $this->authorize('updateStatus', $laporan);

        $request->validate([
            'status_tindakan' => 'required|in:Pending,Proses,Selesai,Ditolak'
        ]);

        $laporan->update([
            'status_tindakan' => $request->status_tindakan
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui!');
    }

    /**
     * Update laporan
     */
    public function update(Request $request, $kode_laporan)
    {
        $laporan = Laporan::where('kode_laporan', $kode_laporan)->firstOrFail();

        if (Auth::user()->id !== $laporan->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

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

        // Untuk AJAX request (bukan Inertia), set flash message dan return JSON
        if (($request->wantsJson() || $request->ajax()) && !$request->header('X-Inertia')) {
            if ($request->header('X-Client-Type') === 'React') {
                session()->flash('success', 'Laporan berhasil diperbarui!');
            }
            return response()->json([
                'success' => true,
                'kode_laporan' => $laporan->kode_laporan,
                'message' => 'Laporan berhasil diperbarui!'
            ]);
        }

        return redirect()->back()->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Hapus laporan
     */
    public function destroy($kode_laporan)
    {
        $laporan = Laporan::where('kode_laporan', $kode_laporan)->firstOrFail();

        if (!Auth::check()) abort(403, 'Unauthorized');

        $isAdmin = Auth::user()->role === 'admin';
        $isOwner = $laporan->user_id === Auth::id();

        if (!$isAdmin && !$isOwner) {
            abort(403, 'Unauthorized');
        }

        foreach ($laporan->bukti as $b) {
            if ($b->path_file && Storage::disk('public')->exists($b->path_file)) {
                Storage::disk('public')->delete($b->path_file);
            }
            $b->delete();
        }

        $laporan->delete();

        // Untuk AJAX request (bukan Inertia), set flash message dan return JSON
        if ((request()->wantsJson() || request()->ajax()) && !request()->header('X-Inertia')) {
            if (request()->header('X-Client-Type') === 'React') {
                session()->flash('success', 'Laporan berhasil dihapus');
            }
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dihapus'
            ]);
        }

        return redirect()->back()->with('success', 'Laporan dihapus');
    }
}
