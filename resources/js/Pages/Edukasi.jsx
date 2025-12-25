import { Head, Link, usePage } from "@inertiajs/react";
import { useState } from "react";
import ReportModal from "@/Components/ReportModal";

export default function Edukasi({ kategori }) {
    const { auth } = usePage().props;
    const [isModalOpen, setIsModalOpen] = useState(false);

    return (
        <>
            <Head title="Edukasi - Pencegahan Pungli" />
            
            <div className="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

                <div className="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-blue-600 to-slate-900 text-white shadow-2xl shadow-blue-200 mb-16 p-10 md:p-20 text-center">
                    <div className="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>
                    <div className="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full bg-blue-400 opacity-10 blur-3xl"></div>

                    <div className="relative z-10">
                        <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-blue-100 text-xs font-bold uppercase tracking-wider mb-6 backdrop-blur-sm">
                            <i className='bx bxs-book-open'></i> Pusat Pengetahuan
                        </div>
                        <h1 className="text-3xl md:text-5xl font-extrabold mb-6">Edukasi Pencegahan Pungli</h1>
                        <p className="text-blue-100 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed opacity-90">
                            Bekali dirimu dengan pengetahuan. Pelajari cara mengenali, mencegah, dan melawan praktik pungutan liar di sekitarmu.
                        </p>
                    </div>
                </div>

                <div className="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100 mb-16 flex flex-col md:flex-row gap-10 items-center">
                    <div className="md:w-1/3 flex justify-center">
                        <div className="w-40 h-40 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 shadow-inner">
                            <i className='bx bxs-help-circle text-7xl'></i>
                        </div>
                    </div>
                    <div className="md:w-2/3">
                        <h2 className="text-2xl md:text-3xl font-bold text-slate-800 mb-4">Apa itu Pungli?</h2>
                        <div className="h-1 w-20 bg-blue-600 rounded-full mb-6"></div>
                        <p className="text-slate-600 text-lg leading-relaxed">
                            <span className="font-bold text-slate-800">Pungli (Pungutan Liar)</span> adalah tindakan meminta pembayaran uang yang tidak sesuai peraturan atau tidak ada dasar hukumnya. Ini sering dilakukan oleh oknum dengan menyalahgunakan kekuasaan atau jabatan untuk keuntungan pribadi, yang pada akhirnya merugikan masyarakat dan menghambat pelayanan publik.
                        </p>
                    </div>
                </div>

                <div className="mb-20">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl font-bold text-slate-800 mb-4">Kenali Ciri-Cirinya</h2>
                        <p className="text-slate-500">Waspada jika Anda menemukan tanda-tanda berikut saat mengurus layanan.</p>
                    </div>

                    <div className="grid md:grid-cols-2 gap-6">
                        <div className="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:border-blue-200 transition group">
                            <div className="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                                <i className='bx bxs-file-remove'></i>
                            </div>
                            <h3 className="font-bold text-xl text-slate-800 mb-3 group-hover:text-blue-600 transition">Tidak Ada Bukti Resmi</h3>
                            <p className="text-slate-500 leading-relaxed">Petugas menolak memberikan kwitansi resmi, karcis, atau dokumen sah lainnya sebagai bukti pembayaran.</p>
                        </div>

                        <div className="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:border-blue-200 transition group">
                            <div className="w-12 h-12 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                                <i className='bx bxs-help-circle'></i>
                            </div>
                            <h3 className="font-bold text-xl text-slate-800 mb-3 group-hover:text-blue-600 transition">Alasan Berbelit</h3>
                            <p className="text-slate-500 leading-relaxed">Penjelasan biaya tidak masuk akal, berubah-ubah, atau menggunakan istilah "uang rokok", "uang lelah", dll.</p>
                        </div>

                        <div className="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:border-blue-200 transition group">
                            <div className="w-12 h-12 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                                <i className='bx bxs-angry'></i>
                            </div>
                            <h3 className="font-bold text-xl text-slate-800 mb-3 group-hover:text-blue-600 transition">Unsur Paksaan</h3>
                            <p className="text-slate-500 leading-relaxed">Adanya intimidasi, ancaman layanan diperlambat, atau dipersulit jika tidak memberikan sejumlah uang.</p>
                        </div>

                        <div className="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:border-blue-200 transition group">
                            <div className="w-12 h-12 bg-yellow-50 text-yellow-500 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                                <i className='bx bxs-bank'></i>
                            </div>
                            <h3 className="font-bold text-xl text-slate-800 mb-3 group-hover:text-blue-600 transition">Rekening Pribadi</h3>
                            <p className="text-slate-500 leading-relaxed">Diminta mentransfer biaya layanan ke rekening atas nama perorangan, bukan rekening instansi resmi.</p>
                        </div>
                    </div>
                </div>

                <div className="bg-blue-50 rounded-[2.5rem] p-8 md:p-16 mb-16 relative overflow-hidden">
                    <i className='bx bxs-shield-check absolute -right-10 -bottom-10 text-[15rem] text-blue-100 opacity-50 rotate-12'></i>

                    <div className="relative z-10">
                        <h2 className="text-3xl font-bold text-slate-800 mb-8">Langkah Pencegahan</h2>

                        <div className="space-y-6">
                            {[ 
                                { id: 1, title: 'Verifikasi Identitas & Biaya', desc: 'Selalu cek papan informasi biaya resmi di kantor layanan atau situs web instansi. Pastikan petugas memiliki identitas resmi.' },
                                { id: 2, title: 'Tolak dengan Tegas & Sopan', desc: 'Jika diminta biaya di luar ketentuan, tolak secara halus namun tegas. Katakan Anda hanya membayar sesuai aturan resmi.' },
                                { id: 3, title: 'Dokumentasikan Bukti', desc: 'Diam-diam catat nama petugas, waktu kejadian, dan jika memungkinkan ambil foto/rekaman suara sebagai bukti pelaporan.' },
                                { id: 4, title: 'Laporkan Segera', desc: 'Gunakan aplikasi ANPUNDUNG untuk melaporkan kejadian tersebut. Identitas Anda akan kami lindungi.' }
                            ].map((step) => (
                                <div key={step.id} className="flex items-start gap-4 bg-white p-5 rounded-2xl shadow-sm border border-blue-100">
                                    <div className="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shrink-0">{step.id}</div>
                                    <div>
                                        <h4 className="font-bold text-slate-800 mb-1">{step.title}</h4>
                                        <p className="text-sm text-slate-600">{step.desc}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                <div className="bg-gradient-to-r from-orange-50 to-red-50 border border-orange-100 rounded-3xl p-8 md:p-12 text-center">
                    <div className="w-16 h-16 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
                        <i className='bx bxs-megaphone'></i>
                    </div>
                    <h3 className="text-2xl font-bold text-slate-800 mb-4">Jangan Diam Saja!</h3>
                    <p className="text-slate-600 mb-8 max-w-2xl mx-auto">
                        Diam berarti membiarkan praktik ini terus terjadi. Keberanian Anda melapor adalah kunci perubahan untuk Bandung yang lebih bersih.
                    </p>
                    
                    {auth.user ? (
                        <button 
                            type="button"
                            onClick={() => setIsModalOpen(true)}
                            className="inline-block px-8 py-4 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition shadow-lg shadow-orange-200"
                        >
                            Laporkan Pungli Sekarang
                        </button>
                    ) : (
                        <Link 
                            href="/register" 
                            className="inline-block px-8 py-4 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition shadow-lg shadow-orange-200"
                        >
                            Daftar untuk Melapor
                        </Link>
                    )}
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
