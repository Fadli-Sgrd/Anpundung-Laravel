<x-layouts.app title="Login">
    <div style="display: flex; align-items: center; justify-content: center; min-height: 70vh; padding: 20px;">
        <div
            style="background: white; border-radius: 12px; box-shadow: 0 2px 20px rgba(0,0,0,0.1); padding: 48px 40px; max-width: 420px; width: 100%;">
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 40px;">
                <div style="font-size: 48px; margin-bottom: 16px;">🔓</div>
                <h1
                    style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 28px; color: #333; margin-bottom: 8px;">
                    Login ke ANPUNDUNG</h1>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 14px;">Akses akun
                    Anda untuk melaporkan pungli</p>
            </div>

            @if ($errors->any())
                <div
                    style="background: #fee; border: 1px solid #f99; padding: 16px; border-radius: 8px; margin-bottom: 24px; color: #d32f2f; font-family: 'Poppins', sans-serif; font-size: 14px;">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <!-- Email Field -->
                <div style="margin-bottom: 24px;">
                    <label for="email"
                        style="display: block; font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 14px; margin-bottom: 8px;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; transition: border 0.3s ease;"
                        placeholder="nama@example.com" />
                    @error('email')
                        <p style="color: #d32f2f; font-family: 'Poppins', sans-serif; font-size: 12px; margin-top: 6px;">
                            {{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div style="margin-bottom: 32px;">
                    <label for="password"
                        style="display: block; font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 14px; margin-bottom: 8px;">Password</label>
                    <input type="password" id="password" name="password" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #eee; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; transition: border 0.3s ease;"
                        placeholder="••••••••" />
                    @error('password')
                        <p style="color: #d32f2f; font-family: 'Poppins', sans-serif; font-size: 12px; margin-top: 6px;">
                            {{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    style="width: 100%; padding: 14px; background: linear-gradient(135deg, #308478 0%, #236b5b 100%); color: white; border: none; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 16px; cursor: pointer; transition: transform 0.2s ease;">
                    <i class='bx bxs-log-in' style="vertical-align: middle; margin-right: 6px; font-size: 18px;"></i>
                    Login
                </button>
            </form>

            <!-- Separator -->
            <div style="display: flex; align-items: center; gap: 12px; margin: 32px 0; color: #ccc;">
                <div style="flex: 1; height: 1px; background: #eee;"></div>
                <span style="font-family: 'Poppins', sans-serif; font-size: 12px;">atau</span>
                <div style="flex: 1; height: 1px; background: #eee;"></div>
            </div>

            <!-- Register Link -->
            <div style="text-align: center; color: #666; font-family: 'Poppins', sans-serif; font-size: 14px;">
                Belum punya akun?
                <a href="/register"
                    style="color: #308478; text-decoration: none; font-weight: 600; transition: color 0.2s ease;">
                    Daftar sekarang
                </a>
            </div>

            <!-- Footer -->
            <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #eee; text-align: center;">
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #999; font-size: 12px;">
                    Data Anda aman dan terlindungi
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
