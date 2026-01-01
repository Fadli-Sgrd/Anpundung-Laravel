import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { useState } from "react";
import ReportModal from "@/Components/ReportModal";

export default function Kontak({ kategori }) {
    const { auth, flash, errors: pageErrors } = usePage().props;
    const [isModalOpen, setIsModalOpen] = useState(false);

    // Contact Form
    const { data, setData, post, processing, errors, reset, wasSuccessful } = useForm({
        nama: '',
        email: '',
        subject: '',
        message: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/kontak', {
            onSuccess: () => reset()
        });
    };

    return (
        <>
            <Head title="Kontak Kami" />
            
            <div className="max-w-6xl mx-auto px-4 py-12">

                <div className="text-center mb-12">
                    <h1 className="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4">Hubungi Tim Kami</h1>
                    <p className="text-slate-500 text-lg max-w-2xl mx-auto leading-relaxed">
                        Punya pertanyaan, saran, atau kendala teknis? Kami siap mendengar dan membantu Anda.
                    </p>
                </div>

                <div className="grid md:grid-cols-3 gap-8 items-start">

                    <div className="md:col-span-1 space-y-6">
                        <div className="bg-gradient-to-br from-blue-600 to-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-blue-200">
                            <div className="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl -mr-10 -mt-10"></div>

                            <div className="relative z-10">
                                <h3 className="text-xl font-bold mb-6 flex items-center gap-2">
                                    <i className='bx bxs-contact'></i> Info Kontak
                                </h3>

                                <div className="space-y-6">
                                    <div className="flex items-start gap-4">
                                        <div className="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center shrink-0 backdrop-blur-sm">
                                            <i className='bx bxs-map text-xl'></i>
                                        </div>
                                        <div>
                                            <p className="font-bold text-blue-100 text-sm mb-1">Porles Jawa Barat</p>
                                            <p className="text-xs opacity-80 leading-relaxed">Bandung, Jawa Barat<br />Indonesia</p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-4">
                                        <div className="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center shrink-0 backdrop-blur-sm">
                                            <i className='bx bxs-envelope text-xl'></i>
                                        </div>
                                        <div>
                                            <p className="font-bold text-blue-100 text-sm mb-1">Email Resmi</p>
                                            <p className="text-xs opacity-80">anpundung@gmail.com</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                            <h4 className="font-bold text-blue-800 mb-2 flex items-center gap-2 text-sm">
                                <i className='bx bxs-info-circle'></i> Butuh Respon Cepat?
                            </h4>
                            <p className="text-xs text-blue-600/80 leading-relaxed">
                                Untuk pelaporan pungli yang mendesak, disarankan menggunakan menu 
                                {auth.user ? (
                                    <button 
                                        type="button" 
                                        onClick={() => setIsModalOpen(true)}
                                        className="font-bold underline hover:text-blue-800 ml-1"
                                    >
                                        Buat Laporan
                                    </button>
                                ) : (
                                    <Link href="/register" className="font-bold underline hover:text-blue-800 ml-1">
                                        Buat Laporan
                                    </Link>
                                )}
                                agar langsung masuk ke sistem prioritas kami.
                            </p>
                        </div>
                    </div>

                    <div className="md:col-span-2">
                        <div className="bg-white rounded-[2rem] p-8 md:p-10 shadow-sm border border-slate-100">
                            <h3 className="text-2xl font-bold text-slate-800 mb-6">Kirim Pesan</h3>

                            {flash.success && (
                                <div className="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                                    <i className='bx bxs-check-circle text-xl mt-0.5'></i>
                                    <div>
                                        <p className="font-bold text-sm">Berhasil!</p>
                                        <p className="text-xs">{flash.success}</p>
                                    </div>
                                </div>
                            )}

                            <form onSubmit={handleSubmit} className="space-y-5">
                                <div className="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label htmlFor="nama" className="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                        <input 
                                            type="text" 
                                            id="nama" 
                                            value={data.nama}
                                            onChange={(e) => setData('nama', e.target.value)}
                                            required
                                            className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm text-slate-700 placeholder-slate-400 font-medium"
                                            placeholder="Nama Anda"
                                        />
                                        {errors.nama && <div className="text-red-500 text-xs mt-1 font-medium">{errors.nama}</div>}
                                    </div>

                                    <div>
                                        <label htmlFor="email" className="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                                        <input 
                                            type="email" 
                                            id="email" 
                                            value={data.email}
                                            onChange={(e) => setData('email', e.target.value)}
                                            required
                                            className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm text-slate-700 placeholder-slate-400 font-medium"
                                            placeholder="email@contoh.com"
                                        />
                                        {errors.email && <div className="text-red-500 text-xs mt-1 font-medium">{errors.email}</div>}
                                    </div>
                                </div>

                                <div>
                                    <label htmlFor="subject" className="block text-sm font-bold text-slate-700 mb-2">Subjek Pesan</label>
                                    <input 
                                        type="text" 
                                        id="subject" 
                                        value={data.subject}
                                        onChange={(e) => setData('subject', e.target.value)}
                                        required
                                        className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm text-slate-700 placeholder-slate-400 font-medium"
                                        placeholder="Contoh: Kendala Login / Saran Fitur"
                                    />
                                    {errors.subject && <div className="text-red-500 text-xs mt-1 font-medium">{errors.subject}</div>}
                                </div>

                                <div>
                                    <label htmlFor="message" className="block text-sm font-bold text-slate-700 mb-2">Isi Pesan</label>
                                    <textarea 
                                        id="message" 
                                        rows="5" 
                                        value={data.message}
                                        onChange={(e) => setData('message', e.target.value)}
                                        required
                                        className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm text-slate-700 placeholder-slate-400 font-medium font-sans"
                                        placeholder="Tuliskan pesan Anda secara detail di sini..."
                                    />
                                    {errors.message && <div className="text-red-500 text-xs mt-1 font-medium">{errors.message}</div>}
                                </div>

                                <div className="pt-2">
                                    <button 
                                        type="submit"
                                        disabled={processing}
                                        className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transition transform active:scale-95 flex items-center justify-center gap-2 disabled:opacity-50"
                                    >
                                        <i className='bx bx-paper-plane text-xl'></i> {processing ? 'Mengirim...' : 'Kirim Pesan'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <ReportModal 
                isOpen={isModalOpen} 
                onClose={() => setIsModalOpen(false)} 
                kategori={kategori}
            />
        </>
    );
}
