import { Head, Link, usePage } from "@inertiajs/react";

export default function NewsShow({ news, page_title }) {
    const { auth } = usePage().props;    
    const relatedNews = news.related || [];

    const backRoute = auth.user && auth.user.role === 'admin' 
        ? route("admin.news.index") 
        : route("news.index");

    return (
        <>
            <Head title={page_title} />

            <div className="bg-white min-h-screen pb-20">
                {/* Progress Bar (Optional) */}
                <div className="fixed top-0 left-0 w-full h-1.5 bg-slate-100 z-50">
                    <div className="h-full bg-blue-600 transition-all duration-300" style={{ width: '0%' }}></div>
                </div>

                {/* Main Article Container */}
                <article className="w-full max-w-5xl mx-auto px-6 lg:px-10 py-12">
                    {/* Top Navigation */}
                    <div className="flex items-center justify-between mb-12">
                        <Link
                            href={backRoute}
                            className="group flex items-center gap-3 text-slate-400 hover:text-blue-600 font-bold transition-all duration-300"
                        >
                            <div className="w-10 h-10 rounded-full border border-slate-100 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all">
                                <i className="bx bx-left-arrow-alt text-2xl"></i>
                            </div>
                            <span className="text-sm uppercase tracking-widest">Kembali</span>
                        </Link>

                        <div className="flex items-center gap-4">
                            <span className="text-slate-300">|</span>
                            <div className="flex gap-2">
                                <button className="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-blue-50 hover:text-blue-600 transition-all">
                                    <i className="bx bxl-facebook text-xl"></i>
                                </button>
                                <button className="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-blue-400 hover:text-white transition-all">
                                    <i className="bx bxl-twitter text-xl"></i>
                                </button>
                                <button className="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-emerald-50 hover:text-emerald-600 transition-all">
                                    <i className="bx bxl-whatsapp text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Content Header */}
                    <header className="max-w-4xl mx-auto text-center mb-16">
                        <div className="inline-flex items-center gap-2 text-blue-600 font-black text-[10px] uppercase tracking-[0.3em] mb-6 bg-blue-50 px-6 py-2 rounded-full border border-blue-100">
                            Pusat Informasi Edukasi
                        </div>
                        <h1 className="text-4xl md:text-6xl font-black text-slate-900 mb-8 leading-[1.15] tracking-tight">
                            {news.title}
                        </h1>

                        <div className="flex flex-col md:flex-row items-center justify-center gap-6 text-slate-400">
                            <div className="flex items-center gap-3 font-bold text-sm bg-slate-50 px-5 py-2.5 rounded-2xl border border-slate-100">
                                <div className="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs">
                                    {(news.author || "A")[0]}
                                </div>
                                <span className="text-slate-700">{news.author || "Administrator"}</span>
                            </div>
                            <div className="flex items-center gap-3 text-sm font-bold uppercase tracking-widest">
                                <i className="bx bx-calendar-event text-xl text-blue-500"></i>
                                <span>{news.published_at}</span>
                            </div>
                            <div className="flex items-center gap-3 text-sm font-bold uppercase tracking-widest">
                                <i className="bx bx-time-five text-xl text-orange-400"></i>
                                <span>5 Min Read</span>
                            </div>
                        </div>
                    </header>

                    {/* Hero Image */}
                    {news.image && (
                        <div className="relative group mb-16 px-4 md:px-0">
                            <div className="absolute -inset-4 bg-blue-600/5 rounded-[3rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            <div className="relative rounded-[3rem] overflow-hidden shadow-2xl shadow-blue-900/10">
                                <img
                                    src={news.image}
                                    alt={news.title}
                                    className="w-full h-[300px] md:h-[600px] object-cover"
                                />
                                <div className="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                            </div>
                        </div>
                    )}

                    {/* Article Body */}
                    <div className="max-w-3xl mx-auto">
                        <div 
                            className="prose prose-slate prose-lg lg:prose-xl max-w-none 
                            prose-headings:font-black prose-headings:tracking-tight prose-headings:text-slate-800
                            prose-p:text-slate-600 prose-p:leading-relaxed prose-p:font-medium
                            prose-strong:text-blue-600 prose-strong:font-black
                            prose-img:rounded-[2rem] prose-img:shadow-xl prose-img:my-12
                            prose-blockquote:border-l-4 prose-blockquote:border-blue-600 prose-blockquote:bg-blue-50/50 prose-blockquote:py-6 prose-blockquote:px-8 prose-blockquote:rounded-r-3xl prose-blockquote:italic prose-blockquote:text-slate-700 prose-blockquote:not-italic prose-blockquote:font-bold
                            selection:bg-blue-100 selection:text-blue-900"
                            dangerouslySetInnerHTML={{ __html: news.content }} 
                        />

                        {/* Social Footer */}
                        <div className="mt-20 py-10 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-8">
                            <div>
                                <h4 className="font-black text-slate-800 text-lg mb-1">Apakah artikel ini membantu?</h4>
                                <p className="text-slate-500 font-medium">Bagikan kepada kerabat Anda untuk edukasi bersama.</p>
                            </div>
                            <div className="flex gap-4">
                                <button className="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:scale-105 transition-all">
                                    <i className="bx bxl-facebook-square text-xl"></i> Facebook
                                </button>
                                <button className="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold shadow-lg shadow-slate-200 hover:scale-105 transition-all">
                                    <i className="bx bxl-twitter text-xl"></i> Twitter
                                </button>
                            </div>
                        </div>
                    </div>
                </article>

                {/* Related News Section */}
                {relatedNews.length > 0 && (
                    <section className="bg-slate-50 py-24">
                        <div className="max-w-7xl mx-auto px-6 uppercase tracking-[0.3em] text-blue-600 font-black text-xs text-center mb-4">
                            Read More next
                        </div>
                        <h2 className="text-4xl font-black text-slate-800 text-center mb-16 tracking-tight">
                            Lanjut Baca Berita Lainnya
                        </h2>
                        <div className="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10">
                            {relatedNews.map((item, index) => (
                                <Link
                                    key={index}
                                    href={route("news.show", item.slug)}
                                    className="group bg-white p-6 rounded-[2.5rem] shadow-xl shadow-slate-200/40 hover:shadow-blue-200/50 border border-slate-100 transition-all duration-500 hover:-translate-y-2"
                                >
                                    {item.image && (
                                        <div className="relative overflow-hidden rounded-[1.5rem] mb-6 aspect-video">
                                            <img
                                                src={item.image}
                                                alt={item.title}
                                                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                            />
                                        </div>
                                    )}
                                    <h3 className="text-xl font-bold text-slate-800 group-hover:text-blue-600 transition-colors leading-tight mb-3">
                                        {item.title}
                                    </h3>
                                    <div className="flex items-center gap-2 text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                                        <i className="bx bx-calendar"></i>
                                        {item.published_at}
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </section>
                )}
            </div>
        </>
    );
}
