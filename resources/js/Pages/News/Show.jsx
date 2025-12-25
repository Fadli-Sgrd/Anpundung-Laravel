import { Head, Link, usePage } from "@inertiajs/react";

export default function NewsShow({ news, page_title }) {
    const { auth } = usePage().props;
    // Controller passing 'related' inside 'news' object, or as separate prop?
    // Based on controller, it seems 'related' is inside 'news' object in my last edit, 
    // BUT checking Show.jsx original code it expects 'related_news' prop.
    // Let's check keys.
    
    // Controller logic:
    // 'news' => [ ..., 'related' => [...] ]
    
    const relatedNews = news.related || [];

    const backRoute = auth.user && auth.user.role === 'admin' 
        ? route("admin.news.index") 
        : route("news.index");

    return (
        <>
            <Head title={page_title} />

            <article className="w-full max-w-4xl mx-auto px-4 py-8">
                {/* Breadcrumb */}
                <nav className="text-sm text-gray-500 mb-6">
                    <Link
                        href={route("news.index")}
                        className="hover:text-blue-600"
                    >
                        Berita
                    </Link>
                    <span className="mx-2">/</span>
                    <span className="text-gray-700">{news.title}</span>
                </nav>

                {/* Header */}
                <header className="mb-8">
                    <h1 className="text-4xl font-bold text-gray-900 mb-4">
                        {news.title}
                    </h1>

                    <div className="flex items-center text-gray-600 text-sm">
                        <span>{news.published_at}</span>
                        {news.author && (
                            <>
                                <span className="mx-2">•</span>
                                <span>Oleh {news.author}</span>
                            </>
                        )}
                    </div>
                </header>

                {/* Featured Image */}
                {news.image && (
                    <div className="mb-8">
                        <img
                            src={news.image}
                            alt={news.title}
                            className="w-full h-[400px] object-cover rounded-lg shadow-lg"
                        />
                    </div>
                )}

                {/* Content */}
                <div className="prose prose-lg max-w-none mb-12">
                    <div dangerouslySetInnerHTML={{ __html: news.content }} />
                </div>

                {/* Related News */}
                {relatedNews.length > 0 && (
                    <section className="border-t border-gray-200 pt-8">
                        <h2 className="text-2xl font-bold text-gray-900 mb-6">
                            Berita Terkait
                        </h2>
                        <div className="grid md:grid-cols-3 gap-6">
                            {relatedNews.map((item, index) => (
                                <Link
                                    key={index}
                                    href={route("news.show", item.slug)}
                                    className="group"
                                >
                                    {item.image && (
                                        <div className="overflow-hidden rounded-lg mb-3">
                                            <img
                                                src={item.image}
                                                alt={item.title}
                                                className="w-full h-40 object-cover group-hover:scale-105 transition duration-300"
                                            />
                                        </div>
                                    )}
                                    <h3 className="font-semibold text-gray-900 group-hover:text-blue-600 transition">
                                        {item.title}
                                    </h3>
                                    <p className="text-sm text-gray-500 mt-1">
                                        {item.published_at}
                                    </p>
                                </Link>
                            ))}
                        </div>
                    </section>
                )}
            
                {/* Back to List */}
                <div className="mt-12 text-center">
                    <Link
                        href={backRoute}
                        className="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        ← Kembali ke Daftar Berita
                    </Link>
                </div>
            </article>
        </>
    );
}
