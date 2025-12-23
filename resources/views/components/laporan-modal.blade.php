@auth
        <div id="modal-lapor" class="fixed inset-0 z-[9999] hidden">
            <div id="modal-backdrop" class="absolute inset-0 bg-slate-900/60"></div>

            <div class="relative z-10 w-full h-full flex items-center justify-center p-4">
                <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b flex items-center justify-between">
                        <h3 class="text-xl font-extrabold text-slate-900">Buat Laporan</h3>
                        <button type="button" id="btn-close-lapor">Tutup</button>
                    </div>

                    <div id="msg-modal" class="hidden mx-6 mt-6 p-4 rounded-xl text-sm font-bold"></div>

                    <form id="form-laporan-modal" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Judul Laporan</label>
                            <input type="text" name="judul" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Kejadian</label>
                                <input type="date" name="tanggal" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                                <select name="id_kategori" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Kejadian</label>
                            <input type="text" name="alamat" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kronologi</label>
                            <textarea name="deskripsi" rows="5" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Bukti</label>
                            <input type="file" name="bukti[]" multiple
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                        </div>

                        <button id="btn-submit-lapor" type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl">
                            Kirim Laporan
                        </button>
                    </form>

                </div>
            </div>
        </div>
    @endauth
