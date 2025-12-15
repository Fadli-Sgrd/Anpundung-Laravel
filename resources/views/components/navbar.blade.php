<nav
    style="background: white; height: 96px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: fixed; top: 0; width: 100%; z-index: 50; display: flex; justify-content: space-between; align-items: center; padding: 0 24px;">
    <!-- Logo Section -->
    <div style="display: flex; align-items: center; gap: 8px;">
        <i class='bx bx-shield-exclamation' style="font-size: 24px; color: #308478;"></i>
        <div>
            <div style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 18px; color: #308478;">ANPUNDUNG
            </div>
            <div style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 11px; color: #999;">Anti Pungli
                Bandung</div>
        </div>
    </div>

    @if (Illuminate\Support\Facades\Auth::check())
        @php $user = Illuminate\Support\Facades\Auth::user() @endphp

        <!-- Desktop Menu -->
        <div style="display: none; gap: 24px; align-items: center;" class="desktop-menu">
            @if ($user->role === 'admin')
                {{-- ADMIN MENU --}}
                <a href="/dashboard"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bxs-dashboard'></i> Dashboard
                </a>
                <a href="/laporan"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bxs-file-pdf'></i> Kelola Laporan
                </a>
                <a href="/kategoris"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bx-tag'></i> Kategori
                </a>
                <a href="/kontak"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bxs-message'></i> Kontak
                </a>
                <a href="/profile"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bxs-user-circle'></i> Profile
                </a>
            @else
                {{-- USER MENU --}}
                <a href="/home"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bxs-home'></i> Home
                </a>
                <a href="/kontak"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bxs-message'></i> Kontak
                </a>
                <a href="/berita"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bxs-news'></i> Berita
                </a>
                <a href="/profile"
                    style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class='bx bxs-user-circle'></i> Profile
                </a>
            @endif
        </div>

        <!-- Logout Button -->
        <form method="POST" action="/logout" style="display: none;" class="desktop-menu">
            @csrf
            <button type="submit"
                style="background: #308478; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-family: 'Poppins', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 14px;">
                <i class='bx bx-log-out'></i> Logout
            </button>
        </form>
    @else
        <!-- Desktop Auth Links -->
        <div style="display: none; gap: 16px; align-items: center;" class="desktop-menu">
            <a href="/login"
                style="font-family: 'Poppins', sans-serif; font-weight: 500; color: #308478; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                <i class='bx bx-log-in'></i> Login
            </a>
            <a href="/register"
                style="background: #308478; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-family: 'Poppins', sans-serif; font-weight: 500; display: flex; align-items: center; gap: 6px;">
                <i class='bx bx-user-plus'></i> Register
            </a>
        </div>
    @endif

    <!-- Hamburger Button -->
    <button id="hamburger" style="display: none; background: none; border: none; font-size: 24px; cursor: pointer;">
        <i class='bx bx-menu'></i>
    </button>
</nav>

<!-- Mobile Sidebar -->
<div id="sidebar"
    style="position: fixed; top: 0; right: -300px; width: 300px; height: 100vh; background: white; box-shadow: -2px 0 10px rgba(0,0,0,0.1); z-index: 50; transition: right 0.3s ease; padding-top: 80px; padding: 20px;">
    <!-- Mobile Menu -->
    <div style="display: flex; flex-direction: column; gap: 0;">
        @if (Illuminate\Support\Facades\Auth::check())
            @php $user = Illuminate\Support\Facades\Auth::user() @endphp

            @if ($user->role === 'admin')
                <a href="/dashboard"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-dashboard'></i> Dashboard
                </a>
                <a href="/laporan"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-file-pdf'></i> Kelola Laporan
                </a>
                <a href="/kategoris"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bx-tag'></i> Kategori
                </a>
                <a href="/kontak"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-message'></i> Kontak
                </a>
                <a href="/profile"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-user-circle'></i> Profile
                </a>
            @else
                <a href="/home"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-home'></i> Home
                </a>
                <a href="/edukasi"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-book'></i> Edukasi
                </a>
                <a href="/kontak"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-message'></i> Kontak
                </a>
                <a href="/berita"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-news'></i> Berita
                </a>
                <a href="/profile"
                    style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                    <i class='bx bxs-user-circle'></i> Profile
                </a>
            @endif

            <form method="POST" action="/logout" style="margin-top: 16px;">
                @csrf
                <button type="submit"
                    style="width: 100%; background: #308478; color: white; padding: 10px; border: none; border-radius: 6px; font-family: 'Poppins', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class='bx bx-log-out'></i> Logout
                </button>
            </form>
        @else
            <a href="/login"
                style="padding: 12px 0; font-family: 'Poppins', sans-serif; font-weight: 500; color: #333; text-decoration: none; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 8px;">
                <i class='bx bx-log-in'></i> Login
            </a>
            <a href="/register"
                style="margin-top: 16px; background: #308478; color: white; padding: 10px; border-radius: 6px; text-align: center; text-decoration: none; font-family: 'Poppins', sans-serif; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class='bx bx-user-plus'></i> Register
            </a>
        @endif
    </div>
</div>

<script>
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    const desktopMenus = document.querySelectorAll('.desktop-menu');

    // Show desktop menu on screens >= 1024px
    function updateNavBar() {
        if (window.innerWidth >= 1024) {
            desktopMenus.forEach(menu => menu.style.display = 'flex');
            hamburger.style.display = 'none';
            sidebar.style.right = '-300px';
        } else {
            desktopMenus.forEach(menu => menu.style.display = 'none');
            hamburger.style.display = 'block';
        }
    }

    hamburger.addEventListener('click', () => {
        sidebar.style.right = '0';
    });

    // Close sidebar when clicking on a link
    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            sidebar.style.right = '-300px';
        });
    });

    // Close sidebar when clicking form submit
    const logoutForm = document.querySelector('#sidebar form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', () => {
            sidebar.style.right = '-300px';
        });
    }

    // Update on page load and resize
    updateNavBar();
    window.addEventListener('resize', updateNavBar);
</script>
