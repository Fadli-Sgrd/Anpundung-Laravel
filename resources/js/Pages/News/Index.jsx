import { Head, Link } from "@inertiajs/react";

export default function NewsIndex({ news, page_title }) {
    return (
        <>
            <Head title={page_title} />

            <div className="container mx-auto px-4 py-8">
                <h1 className="text-4xl font-bold text-gray-800 mb-8">
                    {page_title}
                </h1>

                {/* Grid Berita */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {news.data.map((item) => (
                        <Link
                            key={item.id}
                            href={route("news.show", item.slug)}
                            className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            {/* Gambar Berita */}
                            {item.image && (
                                <img
                                    src={item.image}
                                    alt={item.title}
                                    className="w-full h-48 object-cover"
                                />
                            )}

                            <div className="p-5">
                                {/* Meta Info */}
                                <div className="flex items-center text-sm text-gray-500 mb-3">
                                    <span>{item.published_at}</span>
                                    {item.author && (
                                        <>
                                            <span className="mx-2">•</span>
                                            <span>{item.author}</span>
                                        </>
                                    )}
                                </div>

                                {/* Title */}
                                <h2 className="text-xl font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors">
                                    {item.title}
                                </h2>

                                {/* Excerpt */}
                                {item.excerpt && (
                                    <p className="text-gray-600 line-clamp-3">
                                        {item.excerpt}
                                    </p>
                                )}

                                {/* Read More */}
                                <div className="mt-4">
                                    <span className="text-blue-600 font-medium hover:underline">
                                        Baca Selengkapnya →
                                    </span>
                                </div>
                            </div>
                        </Link>
                    ))}
                </div>

                {/* Pagination */}
                {news.links.length > 3 && (
                    <div className="flex justify-center items-center space-x-2 mt-8">
                        {news.links.map((link, index) => (
                            <Link
                                key={index}
                                href={link.url || "#"}
                                className={`px-4 py-2 rounded-md ${
                                    link.active
                                        ? "bg-blue-600 text-white"
                                        : link.url
                                        ? "bg-white text-gray-700 hover:bg-gray-100"
                                        : "bg-gray-100 text-gray-400 cursor-not-allowed"
                                }`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                                preserveScroll
                            />
                        ))}
                    </div>
                )}

                {/* Empty State */}
                {news.data.length === 0 && (
                    <div className="text-center py-12">
                        <p className="text-gray-500 text-lg">
                            Belum ada berita yang dipublikasikan.
                        </p>
                    </div>
                )}
            </div>
        </>
    );
}
