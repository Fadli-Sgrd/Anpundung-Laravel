export default function DetailModal({ isOpen, onClose, report }) {
    if (!isOpen || !report) return null;

    const getStatusClass = (status) => {
        switch (status) {
            case 'Pending': return 'bg-yellow-100 text-yellow-700 border-yellow-200';
            case 'Proses': return 'bg-blue-100 text-blue-700 border-blue-200';
            case 'Selesai': return 'bg-green-100 text-green-700 border-green-200';
            case 'Ditolak': return 'bg-red-100 text-red-700 border-red-200';
            default: return 'bg-slate-100 text-slate-700';
        }
    };

    return (
        <div className="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <div 
                className="absolute inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" 
                onClick={onClose}
            ></div>

            <div className="relative z-10 w-full max-w-3xl bg-white rounded-3xl shadow-2xl flex flex-col max-h-[90vh]">
                
                {/* Header */}
                <div className="p-6 border-b flex items-center justify-between sticky top-0 bg-white z-20 rounded-t-3xl">
                    <div>
                        <h3 className="text-xl font-extrabold text-slate-900 line-clamp-1">{report.judul}</h3>
                        <p className="text-xs text-slate-500 font-bold">#{report.kode_laporan}</p>
                    </div>
                    <button 
                        type="button" 
                        onClick={onClose} 
                        className="text-slate-500 hover:text-red-600 font-bold text-sm bg-slate-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition"
                    >
                        Tutup
                    </button>
                </div>

                {/* Content */}
                <div className="p-6 overflow-y-auto custom-scrollbar space-y-8">
                    
                    {/* Status & Info Grid */}
                    <div className="grid md:grid-cols-2 gap-6">
                        <div className="space-y-4">
                            <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p className="text-xs font-bold text-slate-400 uppercase mb-1">Status Laporan</p>
                                <span className={`px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border ${getStatusClass(report.status_tindakan)}`}>
                                    {report.status_tindakan}
                                </span>
                            </div>
                            
                            <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p className="text-xs font-bold text-slate-400 uppercase mb-1">Kategori</p>
                                <span className="text-sm font-bold text-blue-600">
                                    {report.kategori ? report.kategori.nama_kategori : 'Umum'}
                                </span>
                            </div>
                        </div>

                        <div className="space-y-4">
                            <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p className="text-xs font-bold text-slate-400 uppercase mb-1">Tanggal Kejadian</p>
                                <div className="flex items-center gap-2 text-slate-700 font-bold text-sm">
                                    <i className='bx bx-calendar'></i>
                                    {new Date(report.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
                                </div>
                            </div>

                            <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p className="text-xs font-bold text-slate-400 uppercase mb-1">Lokasi</p>
                                <div className="flex items-center gap-2 text-slate-700 font-bold text-sm">
                                    <i className='bx bx-map-pin'></i>
                                    {report.alamat}
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Kronologi */}
                    <div>
                        <h4 className="font-bold text-slate-800 mb-3 flex items-center gap-2">
                            <i className='bx bx-align-left text-blue-600'></i> Kronologi Kejadian
                        </h4>
                        <div className="bg-slate-50 p-5 rounded-2xl border border-slate-200 text-slate-600 leading-relaxed text-sm whitespace-pre-line">
                            {report.deskripsi}
                        </div>
                    </div>

                    {/* Bukti */}
                    <div>
                        <h4 className="font-bold text-slate-800 mb-3 flex items-center gap-2">
                            <i className='bx bx-image text-blue-600'></i> Bukti Lampiran
                        </h4>
                        
                        {report.bukti && report.bukti.length > 0 ? (
                            <div className="grid grid-cols-2 gap-4">
                                {report.bukti.map((b, index) => (
                                    <div key={index} className="relative group rounded-xl overflow-hidden border border-slate-200 aspect-video bg-slate-100">
                                        {b.jenis === 'Gambar' ? (
                                            <img 
                                                src={`/storage/${b.path_file}`} 
                                                className="w-full h-full object-cover hover:scale-105 transition duration-500 cursor-pointer" 
                                                alt="Bukti"
                                                onClick={() => window.open(`/storage/${b.path_file}`, '_blank')}
                                            />
                                        ) : (
                                            <div className="w-full h-full flex items-center justify-center">
                                                <i className='bx bx-video text-4xl text-slate-400'></i>
                                            </div>
                                        )}
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p className="text-sm text-slate-400 italic bg-slate-50 p-4 rounded-xl text-center border border-dashed border-slate-200">
                                Tidak ada bukti yang dilampirkan.
                            </p>
                        )}
                    </div>

                </div>
            </div>
        </div>
    );
}
