<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\User;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user yang bisa dijadikan author
        $user = User::first();

        if (!$user) {
            // Buat user default jika belum ada
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Buat berita sample yang lebih banyak dan beragam
        $beritas = [
            [
                'judul' => 'Selamat Datang di Website SMP 54',
                'konten' => 'Selamat datang di website resmi SMP 54. Website ini berisi informasi terbaru mengenai kegiatan sekolah, pengumuman, dan berita-berita penting lainnya. Kami berharap website ini dapat memberikan informasi yang bermanfaat bagi seluruh warga sekolah dan dapat menjadi jembatan komunikasi yang efektif antara sekolah dengan orang tua siswa.',
                'is_published' => true,
            ],
            [
                'judul' => 'Penerimaan Siswa Baru Tahun Ajaran 2024/2025',
                'konten' => 'SMP 54 membuka pendaftaran siswa baru untuk tahun ajaran 2024/2025. Pendaftaran dibuka mulai tanggal 1 Juni 2024 hingga 30 Juni 2024. Untuk informasi lebih lanjut mengenai syarat dan ketentuan pendaftaran, silakan hubungi bagian tata usaha sekolah. Kuota yang tersedia adalah 8 kelas dengan jumlah siswa maksimal 32 per kelas.',
                'is_published' => true,
            ],
            [
                'judul' => 'Kegiatan Ekstrakurikuler Semester Genap',
                'konten' => 'Pada semester genap ini, SMP 54 menyediakan berbagai kegiatan ekstrakurikuler untuk mengembangkan bakat dan minat siswa. Ekstrakurikuler yang tersedia antara lain: Pramuka, PMR, Basket, Futsal, Tari, dan Musik. Pendaftaran dibuka untuk semua siswa dengan jadwal yang fleksibel.',
                'is_published' => false,
            ],
            [
                'judul' => 'Prestasi Gemilang Tim Olimpiade Matematika SMP 54',
                'konten' => 'Tim Olimpiade Matematika SMP 54 berhasil meraih prestasi membanggakan dalam Kompetisi Sains Nasional (KSN) tingkat provinsi. Tiga siswa terbaik berhasil meraih medali emas, perak, dan perunggu. Prestasi ini merupakan hasil kerja keras siswa dan bimbingan intensif dari guru pembimbing selama 6 bulan persiapan.',
                'is_published' => true,
            ],
            [
                'judul' => 'Peringatan Hari Pendidikan Nasional 2024',
                'konten' => 'Dalam rangka memperingati Hari Pendidikan Nasional 2024, SMP 54 mengadakan serangkaian kegiatan menarik. Mulai dari upacara bendera khusus, lomba karya tulis ilmiah, pentas seni, hingga pameran hasil karya siswa. Kegiatan ini bertujuan untuk meningkatkan semangat belajar dan kreativitas siswa.',
                'is_published' => true,
            ],
            [
                'judul' => 'Program Literasi Digital untuk Siswa Kelas VII',
                'konten' => 'SMP 54 meluncurkan program literasi digital khusus untuk siswa kelas VII. Program ini bertujuan untuk meningkatkan kemampuan siswa dalam menggunakan teknologi digital secara bijak dan produktif. Materi yang diajarkan meliputi penggunaan aplikasi pembelajaran, keamanan internet, dan etika digital.',
                'is_published' => true,
            ],
            [
                'judul' => 'Renovasi Laboratorium IPA Segera Dimulai',
                'konten' => 'Pihak sekolah mengumumkan bahwa renovasi laboratorium IPA akan dimulai pada bulan depan. Renovasi ini meliputi pembaruan peralatan praktikum, sistem ventilasi, dan tata ruang yang lebih modern. Diharapkan dengan fasilitas yang lebih baik, pembelajaran IPA akan menjadi lebih efektif dan menarik.',
                'is_published' => false,
            ],
            [
                'judul' => 'Kunjungan Edukatif ke Museum Nasional',
                'konten' => 'Siswa kelas VIII SMP 54 melaksanakan kunjungan edukatif ke Museum Nasional Jakarta. Kegiatan ini merupakan bagian dari pembelajaran sejarah dan budaya Indonesia. Siswa sangat antusias mempelajari berbagai koleksi artefak bersejarah dan mendapat penjelasan langsung dari pemandu museum.',
                'is_published' => true,
            ],
            [
                'judul' => 'Workshop Parenting untuk Orang Tua Siswa',
                'konten' => 'SMP 54 mengadakan workshop parenting yang dikhususkan untuk orang tua siswa. Workshop ini membahas tentang cara mendampingi anak remaja, komunikasi efektif dengan anak, dan strategi memotivasi anak dalam belajar. Acara ini mendapat respons positif dari para orang tua dan akan diadakan secara berkala.',
                'is_published' => true,
            ],
            [
                'judul' => 'Tim Futsal SMP 54 Juara Liga Antar Sekolah',
                'konten' => 'Tim futsal putra SMP 54 berhasil menjuarai Liga Futsal Antar Sekolah tingkat kecamatan. Dalam partai final, tim berhasil mengalahkan SMP 12 dengan skor 3-2. Prestasi ini tidak lepas dari latihan rutin yang dilakukan setiap hari Selasa dan Kamis serta dukungan penuh dari sekolah.',
                'is_published' => true,
            ],
            [
                'judul' => 'Pelaksanaan Ujian Tengah Semester Ganjil',
                'konten' => 'Ujian Tengah Semester (UTS) ganjil akan dilaksanakan pada tanggal 15-22 Oktober 2024. Seluruh siswa diharapkan mempersiapkan diri dengan baik. Jadwal ujian sudah dibagikan melalui wali kelas masing-masing. Untuk siswa yang berhalangan hadir karena sakit, dapat mengikuti ujian susulan sesuai ketentuan yang berlaku.',
                'is_published' => true,
            ],
            [
                'judul' => 'Program Bimbingan Konseling Kelompok',
                'konten' => 'Guru BK SMP 54 meluncurkan program bimbingan konseling kelompok untuk membantu siswa mengatasi berbagai permasalahan remaja. Program ini fokus pada pengembangan kepercayaan diri, manajemen stres, dan keterampilan sosial. Setiap sesi akan diikuti maksimal 8 siswa untuk memastikan efektivitas bimbingan.',
                'is_published' => false,
            ],
            [
                'judul' => 'Pameran Sains dan Teknologi Tingkat Sekolah',
                'konten' => 'SMP 54 menggelar pameran sains dan teknologi dengan tema "Inovasi Muda untuk Masa Depan". Pameran ini menampilkan berbagai karya inovatif siswa mulai dari robot sederhana, eksperimen kimia, hingga aplikasi mobile. Kegiatan ini bertujuan untuk mengasah kreativitas dan jiwa inovator siswa sejak dini.',
                'is_published' => true,
            ],
            [
                'judul' => 'Kegiatan Bakti Sosial di Panti Asuhan',
                'konten' => 'OSIS SMP 54 mengorganisir kegiatan bakti sosial di Panti Asuhan Kasih Sayang. Siswa mengumpulkan donasi berupa buku, alat tulis, dan makanan untuk dibagikan kepada anak-anak panti. Selain memberikan bantuan, siswa juga mengadakan permainan edukatif dan berbagi pengalaman belajar.',
                'is_published' => true,
            ],
            [
                'judul' => 'Sosialisasi Bahaya Narkoba oleh BNN',
                'konten' => 'Pihak BNN memberikan sosialisasi tentang bahaya narkoba kepada seluruh siswa SMP 54. Materi yang disampaikan meliputi jenis-jenis narkoba, dampaknya bagi kesehatan, dan cara menghindari pergaulan yang menjerumuskan. Siswa diharapkan dapat menjadi agent of change dalam memberantas penyalahgunaan narkoba.',
                'is_published' => true,
            ],
            [
                'judul' => 'Festival Budaya Nusantara SMP 54',
                'konten' => 'SMP 54 mengadakan Festival Budaya Nusantara untuk memperkenalkan kekayaan budaya Indonesia kepada siswa. Acara ini menampilkan tarian tradisional, musik daerah, fashion show baju adat, dan kuliner khas dari berbagai daerah. Setiap kelas berpartisipasi dengan menampilkan budaya dari satu provinsi.',
                'is_published' => false,
            ],
            [
                'judul' => 'Pelatihan Jurnalistik untuk Siswa',
                'konten' => 'Ekstrakurikuler jurnalistik SMP 54 mengadakan pelatihan intensif untuk meningkatkan kualitas majalah sekolah. Pelatihan ini mencakup teknik wawancara, penulisan berita, fotografi, dan desain layout. Instruktur pelatihan adalah wartawan profesional dari media massa terkemuka.',
                'is_published' => true,
            ],
            [
                'judul' => 'Program Beasiswa untuk Siswa Berprestasi',
                'konten' => 'SMP 54 mengumumkan program beasiswa untuk siswa berprestasi dari keluarga kurang mampu. Beasiswa ini mencakup pembebasan uang sekolah dan bantuan seragam. Persyaratan meliputi prestasi akademik minimal ranking 10 besar di kelas dan surat keterangan tidak mampu dari kelurahan.',
                'is_published' => true,
            ],
            [
                'judul' => 'Lomba Desain Logo Hari Jadi Sekolah',
                'konten' => 'Dalam rangka memperingati hari jadi SMP 54 yang ke-25, diadakan lomba desain logo khusus. Lomba terbuka untuk seluruh siswa dengan hadiah menarik untuk 3 pemenang terbaik. Logo pemenang akan digunakan sebagai logo resmi peringatan hari jadi sekolah dan berbagai merchandise.',
                'is_published' => false,
            ],
            [
                'judul' => 'Kelas Tambahan untuk Persiapan UN',
                'konten' => 'Untuk siswa kelas IX, sekolah menyediakan kelas tambahan khusus persiapan Ujian Nasional. Kelas ini diadakan setiap hari Sabtu dengan fokus pada mata pelajaran yang diujikan. Materi pembelajaran disesuaikan dengan kisi-kisi UN terbaru dan dilengkapi dengan latihan soal-soal tahun sebelumnya.',
                'is_published' => true,
            ],
        ];

        foreach ($beritas as $berita) {
            Berita::create([
                'judul' => $berita['judul'],
                'konten' => $berita['konten'],
                'user_id' => $user->id,
                'is_published' => $berita['is_published'],
            ]);
        }
    }
}
