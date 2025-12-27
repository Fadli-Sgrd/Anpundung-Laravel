import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";
import SearchInput from "@/Components/SearchInput";

export default function AdminIndex({ news, page_title, filters }) {
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

            <div className="w-full max-w-7xl mx-auto">
                {/* Header Section */}
                <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                    <div>
                        <div className="flex items-center gap-2 text-blue-600 font-bold text-sm uppercase tracking-widest mb-3">
                            <span className="w-8 h-[2px] bg-blue-600"></span>
                            <span>News Management</span>
                        </div>
                        <h1 className="text-4xl font-extrabold text-slate-900 tracking-tight">
                            {page_title || "Kelola Berita"}
                        </h1>
                        <p className="text-slate-500 mt-2 text-lg">
                            Kelola semua konten berita untuk masyarakat Bandung.
                        </p>
                    </div>
                    <Link
                        href={route("admin.news.create")}
                        className="inline-flex items-center gap-2 bg-blue-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-1"
                    >
                        <i className="bx bx-plus-circle text-2xl"></i>
                        <span className="relative">Tulis Berita Baru</span>
                    </Link>
                </div>

                {/* Search & Filters */}
                <div className="mb-10 flex justify-start">
                    <SearchInput 
                        routeName="admin.news.index" 
                        initialValue={filters?.search || ""} 
                        placeholder="Cari judul atau ringkasan berita..."
                    />
                </div>

                {/* Content Area */}
                {!news || !news.data || (news.data.length === 0 && !filters?.search) ? (

                    <div className="bg-white rounded-[2rem] border-2 border-dashed border-slate-200 p-20 text-center shadow-sm">
                        <div className="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                            <i className="bx bx-news text-5xl"></i>
                        </div>
                        <h3 className="text-2xl font-bold text-slate-800 mb-3">
                            Belum Ada Berita
                        </h3>
                        <p className="text-slate-500 text-lg mb-8 max-w-md mx-auto leading-relaxed">
                            Mulai bagikan informasi bermanfaat untuk warga dengan membuat berita pertama Anda hari ini.
                        </p>
                        <Link
                            href={route("admin.news.create")}
                            className="inline-flex items-center gap-2 px-10 py-4 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition shadow-lg font-bold"
                        >
                            <i className="bx bx-plus text-xl"></i>
                            Buat Berita Pertama
                        </Link>
                    </div>
                ) : news.data.length === 0 && filters?.search ? (
                    <div className="bg-white rounded-[2rem] border-2 border-dashed border-slate-200 p-20 text-center shadow-sm">
                        <div className="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                            <i className="bx bx-search text-5xl"></i>
                        </div>
                        <h3 className="text-2xl font-bold text-slate-800 mb-3">
                            Hasil Tidak Ditemukan
                        </h3>
                        <p className="text-slate-500 text-lg max-w-md mx-auto leading-relaxed">
                            Tidak ada berita yang cocok dengan kata kunci "{filters.search}". Coba gunakan istilah lain.
                        </p>
                    </div>
                ) : (
                    <div className="space-y-8">

                        {/* Table Container */}
                        <div className="bg-white rounded-[2rem] shadow-xl shadow-slate-100/50 border border-slate-100 overflow-hidden transition-all duration-500">
                            <div className="overflow-x-auto">
                                <table className="w-full text-left border-collapse">
                                    <thead>
                                        <tr className="bg-slate-50/50 border-b border-slate-100">
                                            <th className="px-8 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">
                                                Konten Berita
                                            </th>
                                            <th className="px-8 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">
                                                Penulis
                                            </th>
                                            <th className="px-8 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">
                                                Status
                                            </th>
                                            <th className="px-8 py-6 text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">
                                                Publikasi
                                            </th>
                                            <th className="px-8 py-6 text-right text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">
                                                Navigasi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-slate-50">
                                        {news.data.map((item) => (
                                            <tr
                                                key={item.id}
                                                className="group hover:bg-blue-50/30 transition-colors duration-300"
                                            >
                                                <td className="px-8 py-6">
                                                    <div className="flex items-center gap-5">
                                                        <div className="relative flex-shrink-0">
                                                            {item.image ? (
                                                                <img
                                                                    src={item.image}
                                                                    alt={item.title}
                                                                    className="w-16 h-16 rounded-2xl object-cover ring-2 ring-slate-100 group-hover:ring-blue-200 transition-all duration-300"
                                                                />
                                                            ) : (
                                                                <div className="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-2xl ring-2 ring-slate-100">
                                                                    <i className="bx bx-image-alt"></i>
                                                                </div>
                                                            )}
                                                            <div className="absolute -top-1 -right-1 w-4 h-4 bg-white rounded-full flex items-center justify-center">
                                                                <div className={`w-2 h-2 rounded-full ${item.is_published ? 'bg-emerald-500' : 'bg-slate-300'}`}></div>
                                                            </div>
                                                        </div>
                                                        <div className="max-w-md">
                                                            <div className="font-bold text-slate-800 group-hover:text-blue-700 transition-colors text-lg mb-1 line-clamp-1">
                                                                {item.title}
                                                            </div>
                                                            <div className="text-sm text-slate-500 line-clamp-1 font-medium">
                                                                {item.excerpt || "Tidak ada ringkasan..."}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="px-8 py-6">
                                                    <div className="flex items-center gap-2">
                                                        <div className="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs uppercase">
                                                            {(item.author || "A")[0]}
                                                        </div>
                                                        <span className="font-semibold text-slate-700">
                                                            {item.author || "Administrator"}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td className="px-8 py-6">
                                                    {item.is_published ? (
                                                        <span className="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-100">
                                                            <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                            Published
                                                        </span>
                                                    ) : (
                                                        <span className="inline-flex items-center gap-1.5 px-4 py-1.5 bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-slate-100">
                                                            <span className="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                                            Draft
                                                        </span>
                                                    )}
                                                </td>
                                                <td className="px-8 py-6 text-slate-500 font-medium text-sm">
                                                    {item.published_at || item.created_at}
                                                </td>
                                                <td className="px-8 py-6">
                                                    <div className="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                        <Link
                                                            href={route("news.show", item.slug)}
                                                            className="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm"
                                                            title="Pratinjau Berita"
                                                        >
                                                            <i className="bx bx-show text-xl"></i>
                                                        </Link>
                                                        <Link
                                                            href={route("admin.news.edit", item.id)}
                                                            className="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm"
                                                            title="Edit Berita"
                                                        >
                                                            <i className="bx bx-edit-alt text-xl"></i>
                                                        </Link>
                                                        <button
                                                            onClick={() => handleDelete(item.id)}
                                                            disabled={deleting === item.id}
                                                            className="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm disabled:opacity-50"
                                                            title="Hapus Berita"
                                                        >
                                                            <i className="bx bx-trash text-xl"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {/* Pagination Section */}
                        {news.links && news.links.length > 3 && (
                            <div className="flex justify-center items-center space-x-2 mt-8">
                                {news.links.map((link, index) => (
                                    <Link
                                        key={index}
                                        href={link.url || "#"}
                                        className={`px-4 py-2 rounded-xl text-sm font-bold transition  ${
                                            link.active
                                                ? "bg-blue-600 text-white shadow-lg shadow-blue-200"
                                                : link.url
                                                ? "bg-white text-slate-600 hover:bg-slate-50 border border-slate-200"
                                                : "bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-100"
                                        }`}
                                        dangerouslySetInnerHTML={{
                                            __html: link.label,
                                        }}
                                        preserveScroll
                                    />
                                ))}
                            </div>
                        )}
                    </div>
                )}
            </div>
        </>
    );
}
