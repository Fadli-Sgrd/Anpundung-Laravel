@props(['kategori'])

@php
    // Ensure kategori is available and iterable
    if (!isset($kategori) || empty($kategori)) {
        $kategori = collect([]);
    }
    // Keep as collection, Blade can iterate over it
@endphp

<div x-data="reportModal()" 
     x-show="isOpen || showSuccess" 
     x-cloak
     @open-report-modal.window="isOpen = true"
     class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
     style="display: none;">
    
    <!-- Success Modal Notification -->
    <div x-show="showSuccess" 
         x-cloak
         class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center shadow-2xl transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
             @click.away="showSuccess = false">
             
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-check text-5xl text-green-600'></i>
            </div>
            
            <h3 class="text-2xl font-black text-slate-800 mb-2">Berhasil!</h3>
            <p class="text-slate-500 mb-8" x-text="successMessage"></p>
            
            <button @click="showSuccess = false" 
                    class="w-full py-4 bg-slate-900 text-white font-bold rounded-xl shadow-lg hover:bg-slate-800 hover:-translate-y-1 transition-all">
                Tutup
            </button>
        </div>
    </div>
    
    <!-- Backdrop -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-slate-900/60 transition-opacity backdrop-blur-sm"
         @click="isOpen = false"></div>

    <!-- Modal Panel -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative z-10 w-full max-w-2xl bg-white rounded-3xl shadow-2xl flex flex-col max-h-[90vh]">
        <div class="p-6 border-b flex items-center justify-between sticky top-0 bg-white z-20 rounded-t-3xl">
            <h3 class="text-xl font-extrabold text-slate-900">Buat Laporan</h3>
            <button type="button"
                    @click="isOpen = false"
                    class="text-slate-500 hover:text-red-600 font-bold text-sm bg-slate-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition">
                Tutup
            </button>
        </div>

        <div class="p-6 space-y-6 overflow-y-auto custom-scrollbar">
            <form id="report-form" 
                  @submit.prevent="submitForm"
                  enctype="multipart/form-data"
                  class="space-y-6">
                
                <!-- Judul Laporan -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Judul Laporan
                    </label>
                    <input type="text"
                           name="judul"
                           x-model="formData.judul"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                           required>
                    <template x-if="errors.judul">
                        <div class="text-red-500 text-sm mt-1">
                            <span x-text="errors.judul[0]"></span>
                        </div>
                    </template>
                </div>

                <!-- Tanggal & Kategori -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Tanggal Kejadian
                        </label>
                        <input type="date"
                               name="tanggal"
                               x-model="formData.tanggal"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                               required>
                        <template x-if="errors.tanggal">
                            <div class="text-red-500 text-sm mt-1">
                                <span x-text="errors.tanggal[0]"></span>
                            </div>
                        </template>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Kategori
                        </label>
                        <div class="relative">
                            <select name="id_kategori"
                                    x-model="formData.id_kategori"
                                    class="w-full px-4 py-3 pr-10 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition appearance-none cursor-pointer"
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @if($kategori && $kategori->count() > 0)
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class='bx bx-chevron-down text-slate-400 text-xl'></i>
                            </div>
                        </div>
                        <template x-if="errors.id_kategori">
                            <div class="text-red-500 text-sm mt-1">
                                <span x-text="errors.id_kategori[0]"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Lokasi Kejadian -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Lokasi Kejadian
                    </label>
                    <input type="text"
                           name="alamat"
                           x-model="formData.alamat"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                           required>
                    <template x-if="errors.alamat">
                        <div class="text-red-500 text-sm mt-1">
                            <span x-text="errors.alamat[0]"></span>
                        </div>
                    </template>
                </div>

                <!-- Kronologi -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Kronologi
                    </label>
                    <textarea rows="5"
                              name="deskripsi"
                              x-model="formData.deskripsi"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                              required></textarea>
                    <template x-if="errors.deskripsi">
                        <div class="text-red-500 text-sm mt-1">
                            <span x-text="errors.deskripsi[0]"></span>
                        </div>
                    </template>
                </div>

                <!-- Bukti -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Bukti
                    </label>
                    <input type="file"
                           name="bukti[]"
                           multiple
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <template x-if="errors.bukti">
                        <div class="text-red-500 text-sm mt-1">
                            <span x-text="errors.bukti[0]"></span>
                        </div>
                    </template>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        :disabled="processing"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl disabled:opacity-50 transition-colors shadow-lg shadow-blue-200">
                    <span x-show="!processing">Kirim Laporan</span>
                    <span x-show="processing">Menyimpan...</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function reportModal() {
    return {
        isOpen: false,
        processing: false,
        errors: {},
        showSuccess: false,
        successMessage: '',
        formData: {
            judul: '',
            tanggal: '',
            id_kategori: '',
            alamat: '',
            deskripsi: ''
        },
        
        init() {
            // Listen for open event
            window.addEventListener('open-report-modal', () => {
                this.isOpen = true;
            });
        },
        
        showSuccessNotification(message) {
            this.successMessage = message;
            this.showSuccess = true;
            // Auto hide setelah 5 detik
            setTimeout(() => {
                this.showSuccess = false;
            }, 5000);
        },
        
        async submitForm() {
            this.processing = true;
            this.errors = {};
            
            const form = document.getElementById('report-form');
            const formData = new FormData(form);
            
            try {
                const response = await fetch('/laporan', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Tampilkan notifikasi sukses
                    this.showSuccessNotification('Laporan berhasil dikirim!');
                    this.isOpen = false;
                    this.resetForm();
                    // Tidak perlu refresh halaman
                } else if (response.status === 422) {
                    this.errors = data.errors || {};
                } else {
                    alert('Terjadi kesalahan saat mengirim laporan.');
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan saat mengirim laporan.');
            } finally {
                this.processing = false;
            }
        },
        
        resetForm() {
            this.formData = {
                judul: '',
                tanggal: '',
                id_kategori: '',
                alamat: '',
                deskripsi: ''
            };
            const form = document.getElementById('report-form');
            if (form) form.reset();
        }
    }
}

// Global function untuk membuka modal
window.openReportModal = function() {
    window.dispatchEvent(new CustomEvent('open-report-modal'));
};
</script>

