import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";

export default function AdminIndex({ news, page_title }) {
    const [deleting, setDeleting] = useState(null);

    const handleDelete = (id) => {
        if (confirm("Yakin ingin menghapus berita ini?")) {
            setDeleting(id);
            router.delete(route("admin.news.destroy", id), {
                onFinish: () => setDeleting(null),
            });
        }
    };

    return (
        <>
            <Head title={page_title || "Kelola Berita"} />

            <div className="w-full">
                {/* Header */}
                <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h1 className="text-4xl font-bold text-gray-800">
                            {page_title || "Kelola Berita"}
                        </h1>
                        <p className="text-gray-500 mt-2">
                            Kelola semua berita dan artikel
                        </p>
                    </div>
                    <Link
                        href={route("admin.news.create")}
                        className="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold flex items-center gap-2 shadow-md hover:shadow-lg whitespace-nowrap"
                    >
                        <i className="bx bx-plus text-xl"></i>
                        Buat Berita Baru
                    </Link>
                </div>

                {/* Empty State or Table */}
                {!news || !news.data || news.data.length === 0 ? (
                    <div className="bg-white rounded-lg shadow-md p-16 text-center">
                        <div className="mb-6">
                            <i className="bx bx-news text-7xl text-gray-300"></i>
                        </div>
                        <h3 className="text-2xl font-bold text-gray-700 mb-3">
                            Belum Ada Berita
                        </h3>
                        <p className="text-gray-500 text-lg mb-6 max-w-md mx-auto">
                            Maaf, Anda belum mengupload berita apapun. Mulai
                            bagikan informasi dengan membuat berita pertama
                            Anda!
                        </p>
                        <Link
                            href={route("admin.news.create")}
                            className="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl"
                        >
                            <i className="bx bx-plus text-xl"></i>
                            Buat Berita Pertama
                        </Link>
                    </div>
                ) : (
                    <>
                        {/* Table */}
                        <div className="bg-white rounded-lg shadow-md overflow-hidden">
                            <table className="w-full">
                                <thead className="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th className="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                            Judul
                                        </th>
                                        <th className="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                            Author
                                        </th>
                                        <th className="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                            Status
                                        </th>
                                        <th className="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                            Tanggal
                                        </th>
                                        <th className="px-6 py-4 text-right text-sm font-semibold text-gray-700">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200">
                                    {news.data.map((item) => (
                                        <tr
                                            key={item.id}
                                            className="hover:bg-gray-50 transition"
                                        >
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-3">
                                                    {item.image && (
                                                        <img
                                                            src={item.image}
                                                            alt={item.title}
                                                            className="w-12 h-12 rounded object-cover"
                                                        />
                                                    )}
                                                    <div>
                                                        <div className="font-semibold text-gray-800">
                                                            {item.title}
                                                        </div>
                                                        {item.excerpt && (
                                                            <div className="text-sm text-gray-500 line-clamp-1">
                                                                {item.excerpt}
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 text-gray-600">
                                                {item.author || "-"}
                                            </td>
                                            <td className="px-6 py-4">
                                                {item.is_published ? (
                                                    <span className="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                                        Published
                                                    </span>
                                                ) : (
                                                    <span className="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                                                        Draft
                                                    </span>
                                                )}
                                            </td>
                                            <td className="px-6 py-4 text-gray-600 text-sm">
                                                {item.published_at ||
                                                    item.created_at}
                                            </td>
                                            <td className="px-6 py-4 text-right">
                                                <div className="flex items-center justify-end gap-2">
                                                    <Link
                                                        href={route(
                                                            "news.show",
                                                            item.slug
                                                        )}
                                                        className="px-3 py-1.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded transition text-sm font-medium"
                                                    >
                                                        <i className="bx bx-show"></i>
                                                    </Link>
                                                    <Link
                                                        href={route(
                                                            "admin.news.edit",
                                                            item.id
                                                        )}
                                                        className="px-3 py-1.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded transition text-sm font-medium"
                                                    >
                                                        <i className="bx bx-edit"></i>
                                                    </Link>
                                                    <button
                                                        onClick={() =>
                                                            handleDelete(item.id)
                                                        }
                                                        disabled={
                                                            deleting === item.id
                                                        }
                                                        className="px-3 py-1.5 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded transition text-sm font-medium disabled:opacity-50"
                                                    >
                                                        <i className="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        {/* Pagination */}
                        {news.links && news.links.length > 3 && (
                            <div className="flex justify-center items-center space-x-2 mt-8">
                                {news.links.map((link, index) => (
                                    <Link
                                        key={index}
                                        href={link.url || "#"}
                                        className={`px-4 py-2 rounded-md ${
                                            link.active
                                                ? "bg-blue-600 text-white"
                                                : link.url
                                                ? "bg-white text-gray-700 hover:bg-gray-100 border border-gray-200"
                                                : "bg-gray-100 text-gray-400 cursor-not-allowed"
                                        }`}
                                        dangerouslySetInnerHTML={{
                                            __html: link.label,
                                        }}
                                        preserveScroll
                                    />
                                ))}
                            </div>
                        )}
                    </>
                )}
            </div>
        </>
    );
}
