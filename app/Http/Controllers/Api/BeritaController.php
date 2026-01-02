<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class BeritaController extends Controller
{
    public function index()
    {
        // Ubah 'Berita::' jadi 'News::'
        $berita = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(5);

        $berita->getCollection()->transform(function ($item) {
            if ($item->image && !str_contains($item->image, 'http')) {
                $item->image_url = asset('storage/' . $item->image); 
            } else {
                $item->image_url = $item->image;
            }
            return $item;
        });

        return response()->json([
            'status'  => true,
            'message' => 'List Berita Terbaru',
            'data'    => $berita
        ], 200);
    }

    public function show($key)
    {
        // Ubah 'Berita::' jadi 'News::'
        $berita = News::find($key);

        if (!$berita) {
            $berita = News::where('slug', $key)->first();
        }

        if (!$berita) {
            return response()->json([
                'status'  => false,
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }

        if ($berita->image && !str_contains($berita->image, 'http')) {
            $berita->image_url = asset('storage/' . $berita->image);
        } else {
            $berita->image_url = $berita->image;
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail Berita',
            'data'    => $berita
        ], 200);
    }
}