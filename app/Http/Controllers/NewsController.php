<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    /**
     * Halaman daftar berita (list)
     */
    public function index()
    {
        $news = News::with('user')->published()
            ->latest('published_at')
            ->paginate(9)
            ->through(fn($item) => [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'excerpt' => $item->excerpt,
                'image' => $item->image,
                'author' => $item->user ? $item->user->name : 'Admin',
                'published_at' => $item->published_at->translatedFormat('d F Y'),
            ]);

        return Inertia::render('News/Index', [
            'news' => $news,
            'page_title' => 'Berita Terkini',
        ]);
    }

    /**
     * Halaman detail berita
     */
    public function show($slug)
    {
        $newsItem = News::with('user')->where('slug', $slug)
            ->published()
            ->firstOrFail();

        return Inertia::render('News/Show', [
            'news' => [
                'id' => $newsItem->id,
                'title' => $newsItem->title,
                'slug' => $newsItem->slug,
                'content' => $newsItem->content,
                'image' => $newsItem->image,
                'author' => $newsItem->user ? $newsItem->user->name : 'Admin',
                'published_at' => $newsItem->published_at->translatedFormat('l, d F Y H:i'),
                'related' => News::with('user')->where('id', '!=', $newsItem->id)
                    ->published()
                    ->latest('published_at')
                    ->take(3)
                    ->get()
                    ->map(fn($item) => [
                        'title' => $item->title,
                        'slug' => $item->slug,
                        'image' => $item->image,
                        'published_at' => $item->published_at->translatedFormat('d M Y'),
                    ]),
            ],
            'page_title' => $newsItem->title,
        ]);
    }

    /**
     * Admin: List semua berita (published & draft)
     */
    public function adminIndex()
    {
        $news = News::with('user')->latest('created_at')
            ->paginate(15)
            ->through(fn($item) => [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'excerpt' => $item->excerpt,
                'image' => $item->image,
                'author' => $item->user ? $item->user->name : 'Admin',
                'is_published' => $item->is_published,
                'published_at' => $item->published_at?->format('d M Y'),
                'created_at' => $item->created_at->format('d M Y'),
            ]);

        return Inertia::render('News/AdminIndex', [
            'news' => $news,
            'page_title' => 'Kelola Berita',
        ]);
    }

    /**
     * Admin: Form create berita
     */
    public function create()
    {
        return Inertia::render('News/Create', [
            'page_title' => 'Buat Berita Baru',
        ]);
    }

    /**
     * Admin: Store berita baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/news'), $imageName);
            $validated['image'] = '/uploads/news/' . $imageName;
        }

        // Assign user_id dari user yang login
        $validated['user_id'] = Auth::id();

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dibuat!');
    }

    /**
     * Admin: Form edit berita
     */
    public function edit($id)
    {
        $news = News::with('user')->findOrFail($id);

        return Inertia::render('News/Edit', [
            'news' => [
                'id' => $news->id,
                'title' => $news->title,
                'slug' => $news->slug,
                'excerpt' => $news->excerpt,
                'content' => $news->content,
                'image' => $news->image,
                // Author tidak diedit, diambil dari relasi user existing
                'author' => $news->user ? $news->user->name : 'Admin',
                'published_at' => $news->published_at?->format('Y-m-d\TH:i'),
                'is_published' => $news->is_published,
            ],
            'page_title' => 'Edit Berita',
        ]);
    }

    /**
     * Admin: Update berita
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/news'), $imageName);
            $validated['image'] = '/uploads/news/' . $imageName;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diupdate!');
    }

    /**
     * Admin: Delete berita
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Delete image if exists
        if ($news->image && file_exists(public_path($news->image))) {
            unlink(public_path($news->image));
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
