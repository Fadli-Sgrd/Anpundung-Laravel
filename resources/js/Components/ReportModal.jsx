import React, { useState, useEffect } from "react";
import { router } from "@inertiajs/react";
import axios from "axios";

export default function ReportModal({
    isOpen: initialIsOpen,
    onClose,
    kategori,
    isEdit = false,
    report = null,
}) {
    const [isOpen, setIsOpen] = useState(initialIsOpen);
    const [processing, setProcessing] = useState(false);
    const [errors, setErrors] = useState({});

    const [data, setData] = useState({
        judul: "",
        tanggal: "",
        id_kategori: "",
        alamat: "",
        deskripsi: "",
        bukti: [],
    });

    // Sync with external prop if provided
    useEffect(() => {
        setIsOpen(initialIsOpen);
    }, [initialIsOpen]);

    // Handle initial data for edit
    useEffect(() => {
        if (isOpen) {
            if (isEdit && report) {
                setData({
                    judul: report.judul || "",
                    tanggal: report.tanggal ? report.tanggal.split("T")[0] : "",
                    id_kategori: report.id_kategori || "",
                    alamat: report.alamat || "",
                    deskripsi: report.deskripsi || "",
                    bukti: [],
                });
            } else {
                setData({
                    judul: "",
                    tanggal: "",
                    id_kategori: "",
                    alamat: "",
                    deskripsi: "",
                    bukti: [],
                });
            }
            setErrors({});
        }
    }, [isOpen, report, isEdit]);

    const handleInputChange = (field, value) => {
        setData((prev) => ({ ...prev, [field]: value }));
    };

    const submitForm = async (e) => {
        e.preventDefault();
        setProcessing(true);
        setErrors({});

        const formData = new FormData();
        Object.keys(data).forEach((key) => {
            if (key === "bukti") {
                if (data.bukti && data.bukti.length > 0) {
                    for (let i = 0; i < data.bukti.length; i++) {
                        formData.append("bukti[]", data.bukti[i]);
                    }
                }
            } else {
                formData.append(key, data[key]);
            }
        });

        if (isEdit && report) {
            formData.append("_method", "PUT");
        }

        const url =
            isEdit && report ? `/laporan/${report.kode_laporan}` : "/laporan";

        // Konfigurasi headers dengan CSRF token
        const headers = { "Content-Type": "multipart/form-data" };
        const token = document.head?.querySelector('meta[name="csrf-token"]');
        if (token) {
            headers["X-CSRF-TOKEN"] = token.content;
        }
        headers["X-Requested-With"] = "XMLHttpRequest";
        headers["X-Client-Type"] = "React";

        try {
            const response = await axios.post(url, formData, { headers });

            // Success handling - tutup modal dulu
            setIsOpen(false);
            if (onClose) onClose();

            // If we're on an Inertia page send reload request
            // We can detect if we are in an Inertia environment by checking if router is available,
            // but since we are importing it, we can just try to use it.
            // However, to be safe for non-Inertia pages (Blade), we might want to check the page context or just try/catch
            try {
                router.reload({
                    preserveScroll: true,
                    only: ["laporan", "flash"],
                    onSuccess: () => {
                         // Optional: console.log("Reload success");
                    }
                });
            } catch (e) {
                // Ignore error if router is not initialized/active (e.g. on Blade page)
                // console.log("Not an Inertia page or reload failed", e);
            }
        } catch (err) {
            if (err.response && err.response.status === 422) {
                setErrors(err.response.data.errors);
            } else {
                alert("Terjadi kesalahan saat mengirim laporan.");
                console.error(err);
            }
        } finally {
            setProcessing(false);
        }
    };

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            {/* Backdrop */}
            <div
                className="absolute inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm"
                onClick={() => {
                    setIsOpen(false);
                    if (onClose) onClose();
                }}
            ></div>

            {/* Modal Panel */}
            <div className="relative z-10 w-full max-w-2xl bg-white rounded-3xl shadow-2xl flex flex-col max-h-[90vh]">
                <div className="p-6 border-b flex items-center justify-between sticky top-0 bg-white z-20 rounded-t-3xl">
                    <h3 className="text-xl font-extrabold text-slate-900">
                        {isEdit ? "Edit Laporan" : "Buat Laporan"}
                    </h3>
                    <button
                        type="button"
                        onClick={() => {
                            setIsOpen(false);
                            if (onClose) onClose();
                        }}
                        className="text-slate-500 hover:text-red-600 font-bold text-sm bg-slate-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition"
                    >
                        Tutup
                    </button>
                </div>

                <div className="p-6 space-y-6 overflow-y-auto custom-scrollbar">
                    <form
                        onSubmit={submitForm}
                        encType="multipart/form-data"
                        className="space-y-6"
                    >
                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">
                                Judul Laporan
                            </label>
                            <input
                                type="text"
                                value={data.judul}
                                onChange={(e) =>
                                    handleInputChange("judul", e.target.value)
                                }
                                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                required
                            />
                            {errors.judul && (
                                <div className="text-red-500 text-sm mt-1">
                                    {errors.judul[0]}
                                </div>
                            )}
                        </div>

                        <div className="grid md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-2">
                                    Tanggal Kejadian
                                </label>
                                <input
                                    type="date"
                                    value={data.tanggal}
                                    onChange={(e) =>
                                        handleInputChange(
                                            "tanggal",
                                            e.target.value
                                        )
                                    }
                                    className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                    required
                                />
                                {errors.tanggal && (
                                    <div className="text-red-500 text-sm mt-1">
                                        {errors.tanggal[0]}
                                    </div>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-2">
                                    Kategori
                                </label>
                                <select
                                    value={data.id_kategori}
                                    onChange={(e) =>
                                        handleInputChange(
                                            "id_kategori",
                                            e.target.value
                                        )
                                    }
                                    className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Kategori --
                                    </option>
                                    {kategori &&
                                        kategori.map((k) => (
                                            <option key={k.id} value={k.id}>
                                                {k.nama_kategori}
                                            </option>
                                        ))}
                                </select>
                                {errors.id_kategori && (
                                    <div className="text-red-500 text-sm mt-1">
                                        {errors.id_kategori[0]}
                                    </div>
                                )}
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">
                                Lokasi Kejadian
                            </label>
                            <input
                                type="text"
                                value={data.alamat}
                                onChange={(e) =>
                                    handleInputChange("alamat", e.target.value)
                                }
                                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                required
                            />
                            {errors.alamat && (
                                <div className="text-red-500 text-sm mt-1">
                                    {errors.alamat[0]}
                                </div>
                            )}
                        </div>

                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">
                                Kronologi
                            </label>
                            <textarea
                                rows="5"
                                value={data.deskripsi}
                                onChange={(e) =>
                                    handleInputChange(
                                        "deskripsi",
                                        e.target.value
                                    )
                                }
                                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                required
                            ></textarea>
                            {errors.deskripsi && (
                                <div className="text-red-500 text-sm mt-1">
                                    {errors.deskripsi[0]}
                                </div>
                            )}
                        </div>

                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">
                                {isEdit
                                    ? "Upload Bukti Baru (Opsional)"
                                    : "Bukti"}
                            </label>
                            <input
                                type="file"
                                multiple
                                onChange={(e) =>
                                    handleInputChange("bukti", e.target.files)
                                }
                                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            />
                            {isEdit && (
                                <p className="text-xs text-slate-500 mt-1">
                                    *Biarkan kosong jika tidak ingin mengubah
                                    bukti.
                                </p>
                            )}
                            {errors.bukti && (
                                <div className="text-red-500 text-sm mt-1">
                                    {errors.bukti[0]}
                                </div>
                            )}
                        </div>

                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl disabled:opacity-50 transition-colors shadow-lg shadow-blue-200"
                        >
                            {processing
                                ? "Menyimpan..."
                                : isEdit
                                ? "Simpan Perubahan"
                                : "Kirim Laporan"}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
}
