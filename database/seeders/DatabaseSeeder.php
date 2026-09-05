<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Report;
use App\Models\StatusHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================
        // 1. Create Users
        // =====================================================

        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@siaplapor.test',
            'password' => Hash::make('password'),
            'phone'    => '081200000001',
            'address'  => 'Kantor Pemerintah Kota Bandung',
            'role'     => 'admin',
        ]);

        $petugas1 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'petugas1@siaplapor.test',
            'password' => Hash::make('password'),
            'phone'    => '081200000002',
            'address'  => 'Dinas Pekerjaan Umum Kota Bandung',
            'role'     => 'petugas',
        ]);

        $petugas2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'petugas2@siaplapor.test',
            'password' => Hash::make('password'),
            'phone'    => '081200000003',
            'address'  => 'Dinas Kebersihan Kota Bandung',
            'role'     => 'petugas',
        ]);

        $warga1 = User::create([
            'name'     => 'Ahmad Fauzi',
            'email'    => 'warga1@siaplapor.test',
            'password' => Hash::make('password'),
            'phone'    => '081300000001',
            'address'  => 'Jl. Asia Afrika No. 10, Bandung',
            'role'     => 'warga',
        ]);

        $warga2 = User::create([
            'name'     => 'Dewi Lestari',
            'email'    => 'warga2@siaplapor.test',
            'password' => Hash::make('password'),
            'phone'    => '081300000002',
            'address'  => 'Jl. Braga No. 5, Bandung',
            'role'     => 'warga',
        ]);

        $warga3 = User::create([
            'name'     => 'Rizky Pratama',
            'email'    => 'warga3@siaplapor.test',
            'password' => Hash::make('password'),
            'phone'    => '081300000003',
            'address'  => 'Jl. Dago No. 20, Bandung',
            'role'     => 'warga',
        ]);

        // =====================================================
        // 2. Create Categories
        // =====================================================

        $catJalan = Category::create([
            'name'            => 'Jalan Rusak',
            'priority_weight' => 30,
        ]);

        $catSampah = Category::create([
            'name'            => 'Sampah Menumpuk',
            'priority_weight' => 20,
        ]);

        $catLampu = Category::create([
            'name'            => 'Lampu Jalan Mati',
            'priority_weight' => 15,
        ]);

        $catBanjir = Category::create([
            'name'            => 'Banjir/Drainase Buruk',
            'priority_weight' => 35,
        ]);

        $catFasilitas = Category::create([
            'name'            => 'Fasilitas Umum Rusak',
            'priority_weight' => 10,
        ]);

        // =====================================================
        // 3. Create dummy placeholder photo
        // =====================================================

        // Create a placeholder image for seeder
        $placeholderDir = storage_path('app/public/reports');
        if (!is_dir($placeholderDir)) {
            mkdir($placeholderDir, 0755, true);
        }

        // Create a simple placeholder image
        $placeholderPath = 'reports/placeholder.jpg';
        if (!file_exists(storage_path('app/public/' . $placeholderPath))) {
            // Create a simple 400x300 placeholder image
            $img = imagecreatetruecolor(400, 300);
            $bgColor = imagecolorallocate($img, 200, 200, 200);
            $textColor = imagecolorallocate($img, 100, 100, 100);
            imagefill($img, 0, 0, $bgColor);
            imagestring($img, 5, 130, 140, 'Foto Laporan', $textColor);
            imagejpeg($img, storage_path('app/public/' . $placeholderPath), 80);
            imagedestroy($img);
        }

        // =====================================================
        // 4. Create Reports (Bandung coordinates, some clustered)
        // =====================================================

        // Reports near Alun-Alun Bandung area (clustered - within 500m of each other)
        $report1 = Report::create([
            'user_id'        => $warga1->id,
            'title'          => 'Jalan Berlubang Besar di Jl. Asia Afrika',
            'description'    => 'Terdapat lubang besar di tengah jalan Asia Afrika dekat Alun-Alun yang sangat membahayakan pengendara motor. Lubang berdiameter sekitar 50cm dan kedalaman 15cm. Sudah ada beberapa pengendara yang terjatuh.',
            'photo'          => $placeholderPath,
            'address'        => 'Jl. Asia Afrika No. 65, Braga, Sumur Bandung, Kota Bandung',
            'latitude'       => -6.9214090,
            'longitude'      => 107.6069740,
            'status'         => 'diterima',
            'priority_score' => 0,
        ]);
        $report1->categories()->attach([$catJalan->id]);

        $report2 = Report::create([
            'user_id'        => $warga2->id,
            'title'          => 'Sampah Menumpuk di Trotoar Jl. Braga',
            'description'    => 'Tumpukan sampah yang sudah berhari-hari tidak diangkut di trotoar Jl. Braga. Menimbulkan bau tidak sedap dan mengganggu pejalan kaki serta estetika kawasan wisata Braga.',
            'photo'          => $placeholderPath,
            'address'        => 'Jl. Braga No. 12, Braga, Sumur Bandung, Kota Bandung',
            'latitude'       => -6.9180200,
            'longitude'      => 107.6093100,
            'status'         => 'diproses',
            'priority_score' => 0,
        ]);
        $report2->categories()->attach([$catSampah->id]);

        // Another report near the same area (within 500m radius of report1)
        $report3 = Report::create([
            'user_id'        => $warga3->id,
            'title'          => 'Jalan Retak dan Bergelombang di Jl. Banceuy',
            'description'    => 'Permukaan jalan Banceuy retak parah dan bergelombang, terutama di depan pertokoan. Kondisi ini sudah berlangsung cukup lama dan semakin memburuk saat musim hujan.',
            'photo'          => $placeholderPath,
            'address'        => 'Jl. Banceuy No. 20, Braga, Sumur Bandung, Kota Bandung',
            'latitude'       => -6.9195500,
            'longitude'      => 107.6085600,
            'status'         => 'diterima',
            'priority_score' => 0,
        ]);
        $report3->categories()->attach([$catJalan->id, $catBanjir->id]);

        // Reports in Dago area (clustered)
        $report4 = Report::create([
            'user_id'        => $warga1->id,
            'title'          => 'Lampu Jalan Mati Total di Jl. Ir. H. Juanda',
            'description'    => 'Beberapa titik lampu jalan di sepanjang Jl. Ir. H. Juanda (Dago) mati total sejak minggu lalu. Area menjadi sangat gelap di malam hari dan rawan kecelakaan serta kriminalitas.',
            'photo'          => $placeholderPath,
            'address'        => 'Jl. Ir. H. Juanda No. 100, Dago, Coblong, Kota Bandung',
            'latitude'       => -6.8848200,
            'longitude'      => 107.6150400,
            'status'         => 'selesai',
            'priority_score' => 0,
        ]);
        $report4->categories()->attach([$catLampu->id]);

        $report5 = Report::create([
            'user_id'        => $warga2->id,
            'title'          => 'Drainase Tersumbat Penyebab Banjir di Dago Bawah',
            'description'    => 'Saluran drainase di area Dago Bawah tersumbat sampah dan sedimen. Setiap hujan deras, air meluap ke jalan dan masuk ke pertokoan. Perlu pengerukan segera.',
            'photo'          => $placeholderPath,
            'address'        => 'Jl. Ir. H. Juanda No. 70, Tamansari, Bandung Wetan, Kota Bandung',
            'latitude'       => -6.8880500,
            'longitude'      => 107.6130200,
            'status'         => 'diproses',
            'priority_score' => 0,
        ]);
        $report5->categories()->attach([$catBanjir->id, $catSampah->id]);

        // Reports in other areas (spread out)
        $report6 = Report::create([
            'user_id'        => $warga3->id,
            'title'          => 'Bangku Taman Rusak di Taman Cibeunying',
            'description'    => 'Beberapa bangku taman di Taman Cibeunying patah dan berbahaya untuk diduduki. Perlu perbaikan atau penggantian agar taman tetap nyaman untuk warga.',
            'photo'          => $placeholderPath,
            'address'        => 'Taman Cibeunying, Cihapit, Bandung Wetan, Kota Bandung',
            'latitude'       => -6.9008300,
            'longitude'      => 107.6235700,
            'status'         => 'diterima',
            'priority_score' => 0,
        ]);
        $report6->categories()->attach([$catFasilitas->id]);

        $report7 = Report::create([
            'user_id'        => $warga1->id,
            'title'          => 'Jalan Amblas dan Genangan Air di Jl. Cihampelas',
            'description'    => 'Bagian jalan di depan Cihampelas Walk amblas dan menyebabkan genangan air saat hujan. Kendaraan harus menghindar dan menimbulkan kemacetan parah.',
            'photo'          => $placeholderPath,
            'address'        => 'Jl. Cihampelas No. 160, Cipaganti, Coblong, Kota Bandung',
            'latitude'       => -6.8950100,
            'longitude'      => 107.6050300,
            'status'         => 'diterima',
            'priority_score' => 0,
        ]);
        $report7->categories()->attach([$catJalan->id, $catBanjir->id]);

        $report8 = Report::create([
            'user_id'        => $warga2->id,
            'title'          => 'Tiang Lampu Miring Hampir Roboh di Jl. Pasteur',
            'description'    => 'Ada tiang lampu jalan yang sudah miring hampir 45 derajat di Jl. Pasteur. Sangat berbahaya karena sewaktu-waktu bisa roboh menimpa kendaraan atau pejalan kaki.',
            'photo'          => $placeholderPath,
            'address'        => 'Jl. Dr. Djunjunan (Pasteur) No. 45, Pajajaran, Cicendo, Kota Bandung',
            'latitude'       => -6.8935600,
            'longitude'      => 107.5875300,
            'status'         => 'selesai',
            'priority_score' => 0,
        ]);
        $report8->categories()->attach([$catLampu->id, $catFasilitas->id]);

        $report9 = Report::create([
            'user_id'        => $warga3->id,
            'title'          => 'Sampah Menumpuk di Bantaran Sungai Cikapundung',
            'description'    => 'Tumpukan sampah besar di bantaran Sungai Cikapundung dekat jembatan Jl. Merdeka. Selain merusak pemandangan, juga berpotensi menyumbat aliran sungai dan menyebabkan banjir.',
            'photo'          => $placeholderPath,
            'address'        => 'Bantaran Sungai Cikapundung, Jl. Merdeka, Babakan Ciamis, Sumur Bandung, Kota Bandung',
            'latitude'       => -6.9120300,
            'longitude'      => 107.6098500,
            'status'         => 'diproses',
            'priority_score' => 0,
        ]);
        $report9->categories()->attach([$catSampah->id, $catBanjir->id]);

        $report10 = Report::create([
            'user_id'        => $warga1->id,
            'title'          => 'Trotoar Rusak dan Berbahaya di Jl. Merdeka',
            'description'    => 'Trotoar di sepanjang Jl. Merdeka banyak yang rusak, berlubang, dan ubin-ubinnya lepas. Pejalan kaki sering tersandung, terutama di malam hari karena penerangan kurang.',
            'photo'          => $placeholderPath,
            'address'        => 'Jl. Merdeka No. 30, Babakan Ciamis, Sumur Bandung, Kota Bandung',
            'latitude'       => -6.9135700,
            'longitude'      => 107.6105200,
            'status'         => 'diterima',
            'priority_score' => 0,
        ]);
        $report10->categories()->attach([$catFasilitas->id, $catLampu->id]);

        // =====================================================
        // 5. Calculate priority scores for all reports
        // =====================================================

        $allReports = Report::all();
        foreach ($allReports as $report) {
            Report::calculatePriorityScore($report);
        }

        // =====================================================
        // 6. Create StatusHistory entries
        // =====================================================

        // Report 1: diterima (initial only)
        StatusHistory::create([
            'report_id'  => $report1->id,
            'updated_by' => $warga1->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(5),
        ]);

        // Report 2: diterima -> diproses
        StatusHistory::create([
            'report_id'  => $report2->id,
            'updated_by' => $warga2->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(7),
        ]);
        StatusHistory::create([
            'report_id'  => $report2->id,
            'updated_by' => $petugas1->id,
            'status'     => 'diproses',
            'note'       => 'Tim kebersihan sudah dikirim ke lokasi untuk pembersihan. Estimasi selesai 2 hari kerja.',
            'created_at' => now()->subDays(5),
        ]);

        // Report 3: diterima only
        StatusHistory::create([
            'report_id'  => $report3->id,
            'updated_by' => $warga3->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(3),
        ]);

        // Report 4: diterima -> diproses -> selesai
        StatusHistory::create([
            'report_id'  => $report4->id,
            'updated_by' => $warga1->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(14),
        ]);
        StatusHistory::create([
            'report_id'  => $report4->id,
            'updated_by' => $petugas2->id,
            'status'     => 'diproses',
            'note'       => 'Petugas PLN sudah dikoordinasikan untuk perbaikan lampu jalan di titik yang dilaporkan.',
            'created_at' => now()->subDays(10),
        ]);
        StatusHistory::create([
            'report_id'  => $report4->id,
            'updated_by' => $petugas2->id,
            'status'     => 'selesai',
            'note'       => 'Semua lampu jalan di Jl. Ir. H. Juanda sudah diperbaiki dan berfungsi normal kembali. Total 5 titik lampu diganti.',
            'created_at' => now()->subDays(7),
        ]);

        // Report 5: diterima -> diproses
        StatusHistory::create([
            'report_id'  => $report5->id,
            'updated_by' => $warga2->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(10),
        ]);
        StatusHistory::create([
            'report_id'  => $report5->id,
            'updated_by' => $petugas1->id,
            'status'     => 'diproses',
            'note'       => 'Tim drainase sedang melakukan pengerukan dan pembersihan saluran. Pekerjaan diperkirakan membutuhkan 3-4 hari.',
            'created_at' => now()->subDays(6),
        ]);

        // Report 6-7: diterima only
        StatusHistory::create([
            'report_id'  => $report6->id,
            'updated_by' => $warga3->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(2),
        ]);
        StatusHistory::create([
            'report_id'  => $report7->id,
            'updated_by' => $warga1->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(4),
        ]);

        // Report 8: diterima -> diproses -> selesai
        StatusHistory::create([
            'report_id'  => $report8->id,
            'updated_by' => $warga2->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(20),
        ]);
        StatusHistory::create([
            'report_id'  => $report8->id,
            'updated_by' => $petugas1->id,
            'status'     => 'diproses',
            'note'       => 'Tim teknis sudah meninjau lokasi. Tiang lampu akan diganti baru minggu depan.',
            'created_at' => now()->subDays(15),
        ]);
        StatusHistory::create([
            'report_id'  => $report8->id,
            'updated_by' => $petugas1->id,
            'status'     => 'selesai',
            'note'       => 'Tiang lampu lama sudah dibongkar dan diganti dengan tiang baru yang lebih kokoh. Area sudah aman.',
            'created_at' => now()->subDays(8),
        ]);

        // Report 9: diterima -> diproses
        StatusHistory::create([
            'report_id'  => $report9->id,
            'updated_by' => $warga3->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(8),
        ]);
        StatusHistory::create([
            'report_id'  => $report9->id,
            'updated_by' => $petugas2->id,
            'status'     => 'diproses',
            'note'       => 'Koordinasi dengan Dinas Lingkungan Hidup untuk pembersihan bantaran sungai sedang dilakukan.',
            'created_at' => now()->subDays(4),
        ]);

        // Report 10: diterima only
        StatusHistory::create([
            'report_id'  => $report10->id,
            'updated_by' => $warga1->id,
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
            'created_at' => now()->subDays(1),
        ]);
    }
}
