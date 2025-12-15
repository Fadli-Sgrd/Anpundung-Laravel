<x-layouts.app title="Register">
    <div style="display: flex; align-items: center; justify-content: center; min-height: 70vh; padding: 20px;">
        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 20px rgba(0,0,0,0.1); padding: 48px 40px; max-width: 420px; width: 100%;">
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 40px;">
                <div style="font-size: 48px; margin-bottom: 16px; color: #308478;"><i class='bx bx-user-circle' style="font-size:48px; vertical-align: middle;"></i></div>
                <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 28px; color: #333; margin-bottom: 8px;">Daftar ANPUNDUNG</h1>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 14px;">Buat akun untuk mulai melaporkan</p>
            </div>

            @if ($errors->any())
                <div style="background: #fee; border: 1px solid #f99; padding: 16px; border-radius: 8px; margin-bottom: 24px; color: #d32f2f; font-family: 'Poppins', sans-serif; font-size: 14px;">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf

                <!-- Name Field -->
                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 14px; margin-bottom: 8px;">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; transition: border 0.3s ease;"
                        placeholder="Nama Anda" />
                    @error('name')
                        <p style="color: #d32f2f; font-family: 'Poppins', sans-serif; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div style="margin-bottom: 20px;">
                    <label for="email" style="display: block; font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 14px; margin-bottom: 8px;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; transition: border 0.3s ease;"
                        placeholder="nama@example.com" />
                    @error('email')
                        <p style="color: #d32f2f; font-family: 'Poppins', sans-serif; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div style="margin-bottom: 20px;">
                    <label for="password" style="display: block; font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 14px; margin-bottom: 8px;">Password</label>
                    <input type="password" id="password" name="password" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; transition: border 0.3s ease;"
                        placeholder="••••••••" />
                    @error('password')
                        <p style="color: #d32f2f; font-family: 'Poppins', sans-serif; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirm Field -->
                <div style="margin-bottom: 32px;">
                    <label for="password_confirmation" style="display: block; font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 14px; margin-bottom: 8px;">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; transition: border 0.3s ease;"
                        placeholder="••••••••" />
                    @error('password_confirmation')
                        <p style="color: #d32f2f; font-family: 'Poppins', sans-serif; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #308478 0%, #236b5b 100%); color: white; border: none; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 16px; cursor: pointer; transition: transform 0.2s ease;">
                    <i class='bx bxs-user-plus' style="vertical-align: middle; margin-right: 6px; font-size: 18px;"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Separator -->
            <div style="display: flex; align-items: center; gap: 12px; margin: 32px 0; color: #ccc;">
                <div style="flex: 1; height: 1px; background: #eee;"></div>
                <span style="font-family: 'Poppins', sans-serif; font-size: 12px;">atau</span>
                <div style="flex: 1; height: 1px; background: #eee;"></div>
            </div>

            <!-- Login Link -->
            <div style="text-align: center; color: #666; font-family: 'Poppins', sans-serif; font-size: 14px;">
                Sudah punya akun?
                <a href="/login" style="color: #308478; text-decoration: none; font-weight: 600; transition: color 0.2s ease;">
                    Login di sini
                </a>
            </div>

            <!-- Footer -->
            <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #eee; text-align: center;">
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 12px;">
                    Akun Anda akan dienkripsi dan aman
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
