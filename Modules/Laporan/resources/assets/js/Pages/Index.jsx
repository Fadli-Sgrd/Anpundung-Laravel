import { Head, Link, usePage, router } from "@inertiajs/react";
import { useState } from "react";
import ReportModal from "@/Components/ReportModal";
import DetailModal from "@/Components/DetailModal";
import PrimaryButton from "@/Components/PrimaryButton";

export default function LaporanIndex({ laporan, kategori }) {
    const { auth, flash } = usePage().props;
    const [createModalOpen, setCreateModalOpen] = useState(false);
    const [editModalOpen, setEditModalOpen] = useState(false);
    const [detailModalOpen, setDetailModalOpen] = useState(false);
    const [selectedReport, setSelectedReport] = useState(null);
    const [statusDropdownOpen, setStatusDropdownOpen] = useState(null);

    const handleDelete = (id) => {
        if (confirm("Apakah Anda yakin ingin menghapus laporan ini?")) {
            router.delete(`/laporan/${id}`, {
                preserveScroll: true
            });
        }
    };

    const handleStatusChange = (kode_laporan, newStatus) => {
        router.patch(`/laporan/${kode_laporan}/status`, {
            status_tindakan: newStatus
        }, {
            preserveScroll: true,
            onSuccess: () => {
                setStatusDropdownOpen(null);
            }
        });
    };

    const handleEdit = (report) => {
        setSelectedReport(report);
        setEditModalOpen(true);
    };

    const handleView = (report) => {
        setSelectedReport(report);
        setDetailModalOpen(true);
    };

    const handleCreate = () => {
        setSelectedReport(null);
        setCreateModalOpen(true);
    };

    const getStatusClass = (status) => {
        switch (status) {
            case 'Pending': return 'bg-yellow-100 text-yellow-700';
            case 'Proses': return 'bg-blue-100 text-blue-700';
            case 'Selesai': return 'bg-green-100 text-green-700';
            case 'Ditolak': return 'bg-red-100 text-red-700';
            default: return 'bg-slate-100 text-slate-700';
        }
    };

    const formatDate = (dateString) => {
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    };

    return (
        <>
            <Head title="Laporan Saya" />

            <div className="max-w-5xl mx-auto px-4 py-8">
                
                {flash.success && (
                    <div className="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-start gap-3">
                        <i className='bx bxs-check-circle text-xl mt-0.5'></i>
                        <div>
                            <p className="font-bold text-sm">Berhasil!</p>
                            <p className="text-xs">{flash.success}</p>
                        </div>
                    </div>
                )}

                <div className="flex flex-col md:flex-row justify-between items-end gap-6 mb-10">
                    <div>
                        <h1 className="text-3xl font-extrabold text-slate-800 mb-2">Riwayat Laporan</h1>
                        <p className="text-slate-500">Pantau status dan perkembangan aduan yang telah Anda kirim.</p>
                    </div>
                    <PrimaryButton onClick={handleCreate}>
                        <i className='bx bx-plus-circle text-xl'></i> Buat Laporan Baru
                    </PrimaryButton>
                </div>

                {laporan.data.length === 0 ? (
                    <div className="bg-white rounded-3xl border-2 border-dashed border-slate-200 p-16 text-center">
                        <div className="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                            <i className='bx bx-notepad text-4xl'></i>
                        </div>
                        <h3 className="text-xl font-bold text-slate-800 mb-2">Belum ada laporan</h3>
                        <p className="text-slate-500 mb-8 max-w-md mx-auto">Anda belum pernah membuat laporan pungli. Jika menemukan indikasi pungli, segera laporkan di sini.</p>
                        <button 
                            onClick={handleCreate}
                            className="text-blue-600 font-bold hover:underline"
                        >
                            Mulai Buat Laporan &rarr;
                        </button>
                    </div>
                ) : (
                    <div className="grid gap-6">
                        {laporan.data.map((l) => (
                            <div key={l.kode_laporan} className="group block bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-400 transition relative overflow-hidden">
                                
                                <div className="absolute top-6 right-6">
                                    {/* Admin can change status - show as dropdown */}
                                    {auth.user.role === 'admin' ? (
                                        <div className="relative">
                                            <button
                                                onClick={() => setStatusDropdownOpen(statusDropdownOpen === l.kode_laporan ? null : l.kode_laporan)}
                                                className={`px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider cursor-pointer transition ${getStatusClass(l.status_tindakan)}`}
                                            >
                                                {l.status_tindakan}
                                                <i className={`bx bx-chevron-down ml-1 transition ${statusDropdownOpen === l.kode_laporan ? 'rotate-180' : ''}`}></i>
                                            </button>
                                            
                                            {statusDropdownOpen === l.kode_laporan && (
                                                <div className="absolute top-full right-0 mt-2 bg-white border border-slate-200 rounded-lg shadow-lg z-50">
                                                    {['Pending', 'Proses', 'Selesai', 'Ditolak'].map((status) => (
                                                        <button
                                                            key={status}
                                                            onClick={() => handleStatusChange(l.kode_laporan, status)}
                                                            className={`block w-full text-left px-4 py-2 text-sm font-medium hover:bg-slate-50 first:rounded-t-lg last:rounded-b-lg transition ${
                                                                l.status_tindakan === status ? 'bg-blue-50 text-blue-700' : 'text-slate-700'
                                                            }`}
                                                        >
                                                            {status}
                                                        </button>
                                                    ))}
                                                </div>
                                            )}
                                        </div>
                                    ) : (
                                        <span className={`px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider ${getStatusClass(l.status_tindakan)}`}>
                                            {l.status_tindakan}
                                        </span>
                                    )}
                                </div>

                                <div className="pr-24 pl-2"> 
                                    <h3 className="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition cursor-pointer" onClick={() => handleView(l)}>{l.judul}</h3>
                                    <div className="flex items-center gap-4 text-xs font-medium text-slate-500 mb-4">
                                        <span className="flex items-center gap-1">
                                            <i className='bx bx-calendar'></i> {formatDate(l.tanggal)}
                                        </span>
                                        <span className="flex items-center gap-1">
                                            <i className='bx bx-tag'></i> {l.kategori ? l.kategori.nama_kategori : 'Umum'}
                                        </span>
                                    </div>
                                    <p className="text-slate-600 text-sm line-clamp-2 leading-relaxed">
                                        {l.deskripsi}
                                    </p>
                                </div>
                                    
                                <div className="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between pl-2">
                                    <span className="text-xs font-bold text-slate-400">Kode: #{l.kode_laporan}</span>
                                    
                                    <div className="flex items-center gap-3">
                                        {/* View Button */}
                                        <button 
                                            onClick={(e) => { e.preventDefault(); handleView(l); }}
                                            className="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm"
                                            title="Lihat Detail"
                                        >
                                            <i className='bx bx-show text-xl'></i>
                                        </button>

                                        {/* Edit Button (Owner or Admin) */}
                                        {(auth.user.role === 'admin' || auth.user.id === l.user_id) && l.status_tindakan === 'Pending' && (
                                            <button 
                                                onClick={(e) => { e.preventDefault(); handleEdit(l); }}
                                                className="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm"
                                                title="Edit Laporan"
                                            >
                                                <i className='bx bx-edit-alt text-xl'></i>
                                            </button>
                                        )}

                                        {/* Delete Button (Owner or Admin) */}
                                        {(auth.user.role === 'admin' || auth.user.id === l.user_id) && (
                                            <button 
                                                onClick={(e) => { e.preventDefault(); handleDelete(l.kode_laporan); }}
                                                className="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm"
                                                title="Hapus Laporan"
                                            >
                                                <i className='bx bx-trash text-xl'></i>
                                            </button>
                                        )}
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}

                {/* Pagination */}
                {laporan.links?.length > 3 && (
                    <div className="flex justify-center items-center space-x-2 mt-8">
                        {laporan.links.map((link, index) => (
                            <Link
                                key={index}
                                href={link.url || "#"}
                                className={`px-4 py-2 rounded-xl text-sm font-bold transition ${
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

            {/* Create Modal */}
            <ReportModal 
                isOpen={createModalOpen} 
                onClose={() => setCreateModalOpen(false)} 
                kategori={kategori}
            />

            {/* Edit Modal */}
            <ReportModal 
                isOpen={editModalOpen} 
                onClose={() => setEditModalOpen(false)} 
                kategori={kategori}
                isEdit={true}
                report={selectedReport}
            />

            {/* Detail Modal */}
            <DetailModal 
                isOpen={detailModalOpen}
                onClose={() => setDetailModalOpen(false)}
                report={selectedReport}
            />
        </>
    );
}
