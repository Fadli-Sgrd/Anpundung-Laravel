import { Head, Link } from "@inertiajs/react";

export default function NewsShow({ news, related_news, page_title }) {
    return (
        <>
            <Head title={page_title} />

            <article className="container mx-auto px-4 py-8 max-w-4xl">
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
                            className="w-full h-auto rounded-lg shadow-lg"
                        />
                    </div>
                )}

                {/* Content */}
                <div
                    className="prose prose-lg max-w-none mb-12"
                    dangerouslySetInnerHTML={{ __html: news.content }}
                />

                {/* Divider */}
                <hr className="my-12 border-gray-300" />

                {/* Related News */}
                {related_news.length > 0 && (
                    <section>
                        <h2 className="text-2xl font-bold text-gray-800 mb-6">
                            Berita Terkait
                        </h2>

                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {related_news.map((item) => (
                                <Link
                                    key={item.id}
                                    href={route("news.show", item.slug)}
                                    className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow"
                                >
                                    {item.image && (
                                        <img
                                            src={item.image}
                                            alt={item.title}
                                            className="w-full h-40 object-cover"
                                        />
                                    )}

                                    <div className="p-4">
                                        <p className="text-sm text-gray-500 mb-2">
                                            {item.published_at}
                                        </p>
                                        <h3 className="font-semibold text-gray-800 line-clamp-2 hover:text-blue-600">
                                            {item.title}
                                        </h3>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </section>
                )}

                {/* Back to List */}
                <div className="mt-12 text-center">
                    <Link
                        href={route("news.index")}
                        className="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        ← Kembali ke Daftar Berita
                    </Link>
                </div>
            </article>
        </>
    );
}
