import { Head, Link } from "@inertiajs/react";
import SearchInput from "@/Components/SearchInput";

export default function NewsIndex({ news, page_title, filters }) {
    return (
        <>
            <Head title={page_title} />

            <div className="bg-[#f8fafc] min-h-screen pb-20">
                {/* Hero / Header Section */}
                <div className="relative bg-slate-900 py-24 mb-12 overflow-hidden rounded-[2.5rem]">
                    {/* Background Texture */}
                    <div className="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>

                    {/* Background Gradient (Diubah ke tengah/center agar simetris) */}
                    <div className="absolute top-0 left-1/2 -translate-x-1/2 w-full md:w-2/3 h-full bg-gradient-to-b from-blue-600/10 to-transparent blur-3xl"></div>

                    {/* Content Container */}
                    <div className="container mx-auto px-6 relative z-10 flex flex-col items-center text-center">
                        {/* Label / Badge */}
                        <div className="flex items-center justify-center gap-3 text-blue-400 font-bold text-sm uppercase tracking-widest mb-4">
                            <span className="w-12 h-[2px] bg-blue-500"></span>
                            <span>Informasi & Edukasi</span>
                            <span className="w-12 h-[2px] bg-blue-500"></span> {/* Menambahkan garis kedua di kanan agar seimbang */}
                        </div>

                        {/* Heading */}
                        <h1 className="text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
                            Portal Berita <span className="text-blue-500">Anpundung.</span>
                        </h1>

                        {/* Description */}
                        <p className="text-slate-400 text-xl max-w-2xl mx-auto leading-relaxed">
                            Dapatkan berita terbaru mengenai aksi pemberantasan pungli, tips keamanan, dan edukasi hukum di Kota Bandung.
                        </p>
                    </div>
                </div>

                <div className="container mx-auto px-6">

                    {/* Header & Search Section (Merged) */}
                    <div className="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                        <h2 className="text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
                            {filters?.search ? `Hasil Pencarian: "${filters.search}"` : 'Berita Terbaru'}
                            <span className="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        </h2>

                        <div className="w-full md:w-auto md:min-w-[400px]">
                            <SearchInput 
                                routeName="news.index" 
                                initialValue={filters?.search || ""} 
                                placeholder="Cari berita berdasarkan judul atau konten..."
                            />
                        </div>
                    </div>



                            {/* Grid Berita */}
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                                {news.data.map((item) => (
                                    <Link
                                        key={item.id}
                                        href={route("news.show", item.slug)}
                                        className="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-blue-200/40 transition-all duration-500 hover:-translate-y-2 flex flex-col h-full"
                                    >
                                        {/* Image Wrap */}
                                        <div className="relative h-64 overflow-hidden">
                                            {item.image ? (
                                                <img
                                                    src={item.image}
                                                    alt={item.title}
                                                    className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                                />
                                            ) : (
                                                <div className="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                                    <i className="bx bx-image-alt text-6xl"></i>
                                                </div>
                                            )}
                                            <div className="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                            <div className="absolute bottom-4 left-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                                <span className="text-white font-bold flex items-center gap-2">
                                                    Baca Selengkapnya <i className="bx bx-right-arrow-alt text-xl"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div className="p-8 flex flex-col flex-grow">
                                            {/* Meta */}
                                            <div className="flex items-center gap-4 mb-5">
                                                <span className="px-4 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-blue-100">
                                                    Artikel
                                                </span>
                                                <span className="text-slate-400 text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
                                                    <i className="bx bx-calendar text-sm"></i>
                                                    {item.published_at}
                                                </span>
                                            </div>

                                            {/* Title */}
                                            <h3 className="text-2xl font-extrabold text-slate-800 mb-4 group-hover:text-blue-600 transition-colors leading-snug">
                                                {item.title}
                                            </h3>

                                            {/* Excerpt */}
                                            {item.excerpt && (
                                                <p className="text-slate-500 text-base line-clamp-3 mb-6 leading-relaxed font-medium">
                                                    {item.excerpt}
                                                </p>
                                            )}

                                            {/* Author */}
                                            <div className="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                                                <div className="flex items-center gap-2">
                                                    <div className="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-[10px]">
                                                        {(item.author || "A")[0]}
                                                    </div>
                                                    <span className="text-sm font-bold text-slate-600">
                                                        {item.author || "Admin"}
                                                    </span>
                                                </div>
                                                <div className="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 shadow-inner">
                                                    <i className="bx bx-chevron-right text-2xl"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </Link>
                                ))}
                            </div>


                    {/* Empty State */}
                    {news.data.length === 0 && (
                        <div className="bg-white rounded-[3rem] p-24 text-center border border-slate-100 shadow-xl shadow-slate-100">
                            <div className="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 text-slate-200">
                                <i className="bx bx-search text-6xl"></i>
                            </div>
                            <h3 className="text-3xl font-black text-slate-800 mb-4">
                                {filters?.search ? `Tidak ada berita untuk "${filters.search}"` : 'Tidak ada berita saat ini.'}
                            </h3>
                            <p className="text-slate-500 text-lg max-w-md mx-auto leading-relaxed">
                                {filters?.search 
                                    ? "Coba gunakan kata kunci lain yang lebih umum." 
                                    : "Kami sedang menyiapkan konten informasi menarik untuk Anda. Silakan kembali lagi nanti!"}
                            </p>
                        </div>
                    )}

                    {/* Pagination */}
                    {news.links?.length > 3 && (
                        <div className="flex justify-center items-center gap-2 mt-12 pb-12">
                            {news.links.map((link, index) => (
                                <Link
                                    key={index}
                                    href={link.url || "#"}
                                    className={`px-4 py-2 rounded-xl text-sm font-bold transition-all duration-300 ${
                                        link.active
                                            ? "bg-blue-600 text-white shadow-lg shadow-blue-200"
                                            : link.url
                                            ? "bg-white text-slate-600 hover:bg-slate-50 border border-slate-200"
                                            : "bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-100"
                                    }`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                    preserveScroll
                                />
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
