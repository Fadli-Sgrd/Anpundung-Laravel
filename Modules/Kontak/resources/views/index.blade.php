<x-layouts.app title="Kontak Kami">
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 12px; text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 36px; margin-bottom: 10px;">💬 Hubungi Kami</h1>
            <p style="font-size: 16px; opacity: 0.9;">Kirim pesan atau pertanyaan kepada tim ANPUNDUNG</p>
        </div>

        @if (session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <form method="POST" action="/kontak">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label for="nama" style="display: block; color: #333; font-weight: 500; margin-bottom: 8px;">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                    @error('nama')
                        <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="email" style="display: block; color: #333; font-weight: 500; margin-bottom: 8px;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                    @error('email')
                        <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="subject" style="display: block; color: #333; font-weight: 500; margin-bottom: 8px;">Subjek</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                    @error('subject')
                        <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="message" style="display: block; color: #333; font-weight: 500; margin-bottom: 8px;">Pesan</label>
                    <textarea id="message" name="message" rows="6" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; font-family: inherit;">{{ old('message') }}</textarea>
                    @error('message')
                        <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 16px;">
                    ✉️ Kirim Pesan
                </button>
            </form>
        </div>

        <div style="background: #f0f4ff; padding: 20px; border-radius: 12px; margin-top: 30px; border-left: 4px solid #667eea;">
            <h3 style="color: #333; margin-bottom: 10px;">📞 Informasi Kontak Lain</h3>
            <p style="color: #666; line-height: 1.8;">
                Atau Anda dapat menghubungi kami melalui saluran lain yang tersedia. Tim kami siap membantu Anda dengan pertanyaan atau masukan apapun.
            </p>
        </div>
    </div>
</x-layouts.app>
