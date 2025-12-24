<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    /**
     * Halaman daftar berita (list)
     */
    public function index()
    {
        $news = News::published()
            ->latest('published_at')
            ->paginate(12)
            ->through(fn($item) => [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'excerpt' => $item->excerpt,
                'image' => $item->image,
                'author' => $item->author,
                'published_at' => $item->published_at->format('d M Y'),
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
        $newsItem = News::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Berita terkait (related news)
        $relatedNews = News::published()
            ->where('id', '!=', $newsItem->id)
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'excerpt' => $item->excerpt,
                'image' => $item->image,
                'published_at' => $item->published_at->format('d M Y'),
            ]);

        return Inertia::render('News/Show', [
            'news' => [
                'id' => $newsItem->id,
                'title' => $newsItem->title,
                'slug' => $newsItem->slug,
                'content' => $newsItem->content,
                'image' => $newsItem->image,
                'author' => $newsItem->author,
                'published_at' => $newsItem->published_at->format('d M Y, H:i'),
            ],
            'related_news' => $relatedNews,
            'page_title' => $newsItem->title,
        ]);
    }
}
