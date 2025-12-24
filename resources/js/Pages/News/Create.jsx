import { Head, Link, useForm } from "@inertiajs/react";

export default function Create({ page_title }) {
    const { data, setData, post, processing, errors } = useForm({
        title: "",
        excerpt: "",
        content: "",
        image: null,
        published_at: "",
        is_published: false,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("admin.news.store"));
    };

    return (
        <>
            <Head title={page_title} />

            <div className="container mx-auto px-4 py-8 max-w-4xl">
                {/* Header */}
                <div className="mb-8">
                    <Link
                        href={route("admin.news.index")}
                        className="text-blue-600 hover:text-blue-700 font-medium mb-4 inline-flex items-center gap-2"
                    >
                        <i className="bx bx-arrow-back"></i>
                        Kembali ke Daftar Berita
                    </Link>
                    <h1 className="text-4xl font-bold text-gray-800 mt-4">
                        {page_title}
                    </h1>
                </div>

                {/* Form */}
                <form
                    onSubmit={handleSubmit}
                    className="bg-white rounded-lg shadow-md p-8"
                >
                    {/* Title */}
                    <div className="mb-6">
                        <label className="block text-gray-700 font-semibold mb-2">
                            Judul Berita <span className="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            value={data.title}
                            onChange={(e) => setData("title", e.target.value)}
                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan judul berita"
                        />
                        {errors.title && (
                            <p className="text-red-500 text-sm mt-1">
                                {errors.title}
                            </p>
                        )}
                    </div>

                    {/* Excerpt */}
                    <div className="mb-6">
                        <label className="block text-gray-700 font-semibold mb-2">
                            Ringkasan (Excerpt)
                        </label>
                        <textarea
                            value={data.excerpt}
                            onChange={(e) => setData("excerpt", e.target.value)}
                            rows="3"
                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Ringkasan singkat berita"
                        ></textarea>
                        {errors.excerpt && (
                            <p className="text-red-500 text-sm mt-1">
                                {errors.excerpt}
                            </p>
                        )}
                    </div>

                    {/* Content */}
                    <div className="mb-6">
                        <label className="block text-gray-700 font-semibold mb-2">
                            Konten <span className="text-red-500">*</span>
                        </label>
                        <textarea
                            value={data.content}
                            onChange={(e) => setData("content", e.target.value)}
                            rows="12"
                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Tulis konten berita di sini..."
                        ></textarea>
                        {errors.content && (
                            <p className="text-red-500 text-sm mt-1">
                                {errors.content}
                            </p>
                        )}
                    </div>

                    {/* Image */}
                    <div className="mb-6">
                        <label className="block text-gray-700 font-semibold mb-2">
                            Gambar Berita
                        </label>
                        <input
                            type="file"
                            accept="image/*"
                            onChange={(e) =>
                                setData("image", e.target.files[0])
                            }
                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        {errors.image && (
                            <p className="text-red-500 text-sm mt-1">
                                {errors.image}
                            </p>
                        )}
                    </div>

                    <div className="mb-6">
                        {/* Published Date */}
                        <label className="block text-gray-700 font-semibold mb-2">
                            Tanggal Publish
                        </label>
                        <input
                            type="datetime-local"
                            value={data.published_at}
                            onChange={(e) =>
                                setData("published_at", e.target.value)
                            }
                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        {errors.published_at && (
                            <p className="text-red-500 text-sm mt-1">
                                {errors.published_at}
                            </p>
                        )}
                    </div>

                    {/* Is Published */}
                    <div className="mb-8">
                        <label className="flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                checked={data.is_published}
                                onChange={(e) =>
                                    setData("is_published", e.target.checked)
                                }
                                className="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                            />
                            <span className="text-gray-700 font-semibold">
                                Publish berita ini sekarang
                            </span>
                        </label>
                        <p className="text-sm text-gray-500 ml-8">
                            Jika tidak dicentang, berita akan disimpan sebagai
                            draft
                        </p>
                    </div>

                    {/* Buttons */}
                    <div className="flex items-center gap-4">
                        <button
                            type="submit"
                            disabled={processing}
                            className="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {processing ? "Menyimpan..." : "Simpan Berita"}
                        </button>
                        <Link
                            href={route("admin.news.index")}
                            className="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold"
                        >
                            Batal
                        </Link>
                    </div>
                </form>
            </div>
        </>
    );
}
