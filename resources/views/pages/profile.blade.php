<x-layouts.app title="Profile">
    <div style="max-width: 700px; margin: 0 auto; padding: 0 16px;">
        <!-- Header -->
        <div style="margin-bottom: 64px;">
            <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 40px; color: #333; margin-bottom: 8px;">
                Profile Saya
            </h1>
            <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 16px;">
                Kelola informasi akun Anda
            </p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div style="background: #d4edda; border-left: 5px solid #28a745; border-radius: 12px; padding: 16px; margin-bottom: 40px;">
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #155724; margin: 0;">
                    <i class="bx bx-check-circle" style="vertical-align: middle; margin-right: 8px;"></i> {{ session('success') }}
                </p>
            </div>
        @endif

        <!-- Account Info Card -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee; margin-bottom: 40px;">
            <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px; color: #333; margin-bottom: 24px;">Edit Akun</h2>
            
            <form method="POST" action="/profile/update">
                @csrf
                @method('PATCH')

                <!-- Name Field -->
                <div style="margin-bottom: 24px;">
                    <label for="name" style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required 
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                    @error('name')
                        <p style="color: #dc3545; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div style="margin-bottom: 24px;">
                    <label for="email" style="display: block; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; margin-bottom: 8px;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required 
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; box-sizing: border-box;">
                    @error('email')
                        <p style="color: #dc3545; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Member Info -->
                <div style="background: #f8f9fa; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                        <span>Role</span>
                        <span style="color: #308478;">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 8px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #666;">
                        <span>Bergabung</span>
                        <span>{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" style="width: 100%; background: #308478; color: white; padding: 12px; border: none; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="bx bx-save" style="font-size: 16px;"></i> Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Reports Link -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 2px solid #eee;">
            <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #333; margin-bottom: 12px;">Laporan Saya</h3>
            <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #666; margin-bottom: 20px; font-size: 14px;">
                Kelola semua laporan pungli yang Anda buat
            </p>
            <a href="/laporan" style="display: inline-flex; align-items: center; gap: 8px; background: #308478; color: white; padding: 10px 24px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; text-decoration: none; font-size: 14px;">
                <i class="bx bx-list-ul" style="font-size: 16px;"></i> Lihat Laporan Saya
            </a>
        </div>
    </div>
</x-layouts.app>
