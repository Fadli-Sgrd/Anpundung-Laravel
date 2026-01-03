<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temukan admin atau user pertama sebagai penulis
        $admin = User::where('role', 'admin')->first() ?: User::first();

        if (!$admin) {
            $this->command->error("Gagal melakukan seeding berita: Tidak ada user (admin) yang ditemukan.");
            return;
        }

        // Hapus data berita lama agar "ditimpa" sesuai permintaan user
        News::truncate();

        $newsData = [
            [
                'title' => 'Satgas Saber Pungli Bandung Perketat Pengawasan di Sektor Perizinan',
                'excerpt' => 'Pemerintah Kota Bandung bersama Satgas Saber Pungli berkomitmen memberantas praktik pungutan liar di seluruh instansi pelayanan publik.',
                'content' => 'Praktik pungutan liar (pungli) menjadi perhatian serius Pemerintah Kota Bandung. Dalam upaya mewujudkan tata kelola pemerintahan yang bersih dan melayani, Satgas Saber Pungli Kota Bandung memperketat pengawasan, terutama di sektor perizinan dan dokumen kependudukan. "Kami tidak akan mentolerir oknum yang masih berani melakukan pungli," tegas salah satu perwakilan Satgas. Warga dihimbau untuk selalu menggunakan jalur resmi dan melaporkan indikasi kecurangan melalui kanal yang tersedia.',
                'image' => 'https://images.unsplash.com/photo-1573163281534-ddb2807c6c58?q=80&w=2070&auto=format&fit=crop', // Meeting/Official look
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Edukasi Warga: Kenali Tanda-tanda Pungli Saat Mengurus Dokumen Publik',
                'excerpt' => 'Banyak warga belum menyadari bahwa biaya tambahan di luar aturan resmi adalah pungli. Simak penjelasan lengkapnya di sini.',
                'content' => 'Edukasi mengenai pencegahan pungli sangat krusial bagi masyarakat. Pungli seringkali berkedok "uang administrasi" atau "uang lelah" yang diminta secara paksa atau halus oleh oknum. Secara aturan, setiap layanan publik memiliki tarif resmi yang dipublikasikan secara terbuka. Jika ada permintaan uang melebihi tarif tersebut tanpa dasar hukum, itu dipastikan adalah pungli. Masyarakat diharapkan berani menolak dan menanyakan kwitansi resmi untuk setiap transaksi.',
                'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?q=80&w=2011&auto=format&fit=crop', // Documents/Legal
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Anpundung: Platform Digital Baru untuk Bandung Bebas Pungutan Liar',
                'excerpt' => 'Aplikasi Anpundung resmi dirilis untuk memfasilitasi aduan warga terkait praktik pungli di lingkungan sekitar.',
                'content' => 'Menjawab tantangan di era digital, platform Anpundung hadir sebagai solusi bagi warga Bandung untuk melaporkan praktik pungutan liar secara aman dan anonim. Dengan fitur unggulan seperti unggah bukti foto dan video, laporan warga akan langsung diteruskan ke instansi terkait untuk ditindaklanjuti. Kehadiran platform ini diharapkan mampu memutus rantai birokrasi yang korup dan mempercepat respon penanganan aduan masyarakat.',
                'image' => 'https://images.unsplash.com/photo-1512428559087-560fa5ceab42?q=80&w=2070&auto=format&fit=crop', // Modern App/Phone
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Inovasi Pelayanan Publik: Digitalisasi Menutup Celah Praktik Ilegal',
                'excerpt' => 'Melalui digitalisasi layanan, interaksi tatap muka yang berisiko pungli dapat dikurangi secara signifikan.',
                'content' => 'Digitalisasi bukan hanya soal teknologi, tapi soal integritas. Dengan sistem online, interaksi antara pemohon layanan dan petugas dapat diminimalkan, sehingga potensi terjadinya negosiasi ilegal atau pungutan liar bisa ditekan. Kota Bandung terus bertransformasi menuju Smart City yang transparan, di mana setiap progress layanan dapat dipantau secara langsung oleh warga tanpa perlu "menitip" pesan kepada pihak ketiga.',
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop', // Technology/Futuristic
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Sosialisasi Anti-Korupsi di Sekolah: Membangun Generasi Berintegritas',
                'excerpt' => 'Nilai-nilai kejujuran ditanamkan sejak dini melalui program sosialisasi ke sekolah-sekolah di wilayah Bandung.',
                'content' => 'Membangun Bandung yang bersih harus dimulai dari pondasi karakter. Program sosialisasi anti-pungli dan anti-korupsi kini mulai merambah ke dunia pendidikan. Siswa diajarkan untuk memahami dampak buruk pungli bagi keadilan sosial. Diharapkan generasi muda Bandung ke depan memiliki integritas tinggi dan menjadi pengawal transparansi di masa depan.',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop', // Education/Classroom
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
        ];

        foreach ($newsData as $data) {
            News::create(array_merge($data, [
                'user_id' => $admin->id,
                'slug' => Str::slug($data['title']),
            ]));
        }
    }
}
