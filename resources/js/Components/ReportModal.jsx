import { useEffect } from 'react';
import { useForm, router } from '@inertiajs/react';

export default function ReportModal({ isOpen, onClose, kategori, isEdit = false, report = null }) {
    const { data, setData, post, put, processing, errors, reset, wasSuccessful } = useForm({
        judul: '',
        tanggal: '',
        id_kategori: '',
        alamat: '',
        deskripsi: '',
        bukti: [] // Note: File input handling for edit is tricky in Inertia/HTML (can't prefill file input)
    });

    useEffect(() => {
        if (isOpen) {
            if (isEdit && report) {
                setData({
                    judul: report.judul || '',
                    tanggal: report.tanggal ? report.tanggal.split('T')[0] : '', // Adjust date format if needed
                    id_kategori: report.id_kategori || '',
                    alamat: report.alamat || '',
                    deskripsi: report.deskripsi || '',
                    bukti: [] // Keep empty, user uploads new files if needed
                });
            } else {
                reset();
            }
        }
    }, [isOpen, report, isEdit]);

    useEffect(() => {
        if (wasSuccessful) {
            onClose();
            reset();
        }
    }, [wasSuccessful]);

    const handleSubmit = (e) => {
        e.preventDefault();
        
        if (isEdit && report) {
             
             post(`/laporan/${report.kode_laporan}`, {
                _method: 'PUT',
                forceFormData: true,
                preserveScroll: true,
                onSuccess: () => {
                    reset();
                    onClose();
                }
            });
             
        } else {
            post('/laporan', {
                forceFormData: true,
                preserveScroll: true,
                onSuccess: () => {
                    reset();
                    onClose();
                }
            });
        }
    }
    const submitForm = (e) => {
        e.preventDefault();
        
        if (isEdit) {
            router.post(`/laporan/${report.kode_laporan}`, {
                _method: 'PUT',
                ...data,
            }, {
                forceFormData: true,
                preserveScroll: true,
                onSuccess: () => {
                     onClose(); 
                     reset();
                }
            });
        } else {
            post('/laporan', {
                forceFormData: true,
                preserveScroll: true,
                onSuccess: () => { onClose(); reset(); }
            });
        }
    };


    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            {/* Backdrop */}
            <div 
                className="absolute inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm" 
                onClick={onClose}
            ></div>

            {/* Modal Panel */}
            <div className="relative z-10 w-full max-w-2xl bg-white rounded-3xl shadow-2xl flex flex-col max-h-[90vh]">
                <div className="p-6 border-b flex items-center justify-between sticky top-0 bg-white z-20 rounded-t-3xl">
                    <h3 className="text-xl font-extrabold text-slate-900">
                        {isEdit ? 'Edit Laporan' : 'Buat Laporan'}
                    </h3>
                    <button 
                        type="button" 
                        onClick={onClose} 
                        className="text-slate-500 hover:text-red-600 font-bold text-sm bg-slate-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition"
                    >
                        Tutup
                    </button>
                </div>

                <div className="p-6 space-y-6 overflow-y-auto custom-scrollbar">
                    <form onSubmit={submitForm} encType="multipart/form-data" className="space-y-6">
                        
                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">Judul Laporan</label>
                            <input
                                type="text"
                                value={data.judul}
                                onChange={(e) => setData('judul', e.target.value)}
                                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                required
                            />
                            {errors.judul && <div className="text-red-500 text-sm mt-1">{errors.judul}</div>}
                        </div>

                        <div className="grid md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-2">Tanggal Kejadian</label>
                                <input
                                    type="date"
                                    value={data.tanggal}
                                    onChange={(e) => setData('tanggal', e.target.value)}
                                    className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                    required
                                />
                                {errors.tanggal && <div className="text-red-500 text-sm mt-1">{errors.tanggal}</div>}
                            </div>

                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                                <select
                                    value={data.id_kategori}
                                    onChange={(e) => setData('id_kategori', e.target.value)}
                                    className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                    required
                                >
                                    <option value="">-- Pilih Kategori --</option>
                                    {kategori && kategori.map((k) => (
                                        <option key={k.id} value={k.id}>{k.nama_kategori}</option>
                                    ))}
                                </select>
                                {errors.id_kategori && <div className="text-red-500 text-sm mt-1">{errors.id_kategori}</div>}
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">Lokasi Kejadian</label>
                            <input
                                type="text"
                                value={data.alamat}
                                onChange={(e) => setData('alamat', e.target.value)}
                                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                required
                            />
                            {errors.alamat && <div className="text-red-500 text-sm mt-1">{errors.alamat}</div>}
                        </div>

                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">Kronologi</label>
                            <textarea
                                rows="5"
                                value={data.deskripsi}
                                onChange={(e) => setData('deskripsi', e.target.value)}
                                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                required
                            ></textarea>
                            {errors.deskripsi && <div className="text-red-500 text-sm mt-1">{errors.deskripsi}</div>}
                        </div>

                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">
                                {isEdit ? 'Upload Bukti Baru (Opsional)' : 'Bukti'}
                            </label>
                            <input
                                type="file"
                                multiple
                                onChange={(e) => setData('bukti', e.target.files)}
                                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            />
                            {isEdit && <p className="text-xs text-slate-500 mt-1">*Biarkan kosong jika tidak ingin mengubah bukti.</p>}
                            {errors.bukti && <div className="text-red-500 text-sm mt-1">{errors.bukti}</div>}
                        </div>

                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl disabled:opacity-50 transition-colors shadow-lg shadow-blue-200"
                        >
                            {processing ? 'Menyimpan...' : (isEdit ? 'Simpan Perubahan' : 'Kirim Laporan')}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
}
