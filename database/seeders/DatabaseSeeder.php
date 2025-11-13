<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('publisher')->insert([
            ['name' => 'Gramedia', 'address' => 'Jl. Sudirman No.1, Jakarta', 'email' => 'contact@gramedia.com', 'phone' => '081234567890', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Erlangga', 'address' => 'Jl. Thamrin No.10, Jakarta', 'email' => 'info@erlangga.com', 'phone' => '082345678901', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Mizan', 'address' => 'Jl. Merdeka No.5, Bandung', 'email' => 'support@mizan.com', 'phone' => '083456789012', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Bentang Pustaka', 'address' => 'Jl. Pahlawan No.12, Yogyakarta', 'email' => 'contact@bentangpustaka.com', 'phone' => '084567890123', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Kompas Gramedia', 'address' => 'Jl. Gatot Subroto No.45, Jakarta', 'email' => 'info@kompasgramedia.com', 'phone' => '085678901234', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Kawan Pustaka', 'address' => 'Jl. Veteran No.8, Surabaya', 'email' => 'support@kawanpustaka.com', 'phone' => '086789012345', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Elex Media', 'address' => 'Jl. Asia Afrika No.20, Bandung', 'email' => 'contact@elexmedia.com', 'phone' => '087890123456', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Pustaka Obor', 'address' => 'Jl. Diponegoro No.33, Jakarta', 'email' => 'info@pustakaobor.com', 'phone' => '088901234567', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        DB::table('author')->insert([
            ['name' => 'Tere Liye', 'bio' => 'Penulis novel fantasi terkenal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Andrea Hirata', 'bio' => 'Penulis Laskar Pelangi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Dewi Lestari', 'bio' => 'Penulis Supernova dan novel populer lain', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Agnes Davonar', 'bio' => 'Penulis novel romance Indonesia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Pidi Baiq', 'bio' => 'Penulis novel dan ilustrator Laskar Pelangi series', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fiersa Besari', 'bio' => 'Penulis dan musisi, terkenal dengan novel dan puisi inspiratif', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Risa Saraswati', 'bio' => 'Penulis novel horor dan fantasi, juga penyanyi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Raditya Dika', 'bio' => 'Penulis, komika, dan sutradara film komedi Indonesia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Clara Ng', 'bio' => 'Penulis novel anak-anak dan dewasa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Dee Lestari', 'bio' => 'Penulis novel fantasi dan inspiratif', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Marthino Lio', 'bio' => 'Penulis dan kreator cerita fiksi romantis', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Mochamad Fahri', 'bio' => 'Penulis cerita petualangan dan fantasi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Luluk HF', 'bio' => 'Penulis cerita percintaan dan novel remaja', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Intan Paramaditha', 'bio' => 'Penulis cerita horor dan feminisme', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Ika Natassa', 'bio' => 'Penulis novel romance dan drama', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        DB::table('book')->insert([
            ['title' => 'Bumi', 'desc' => 'Novel fantasi karya Tere Liye', 'year_publish' => 2012, 'author_id' => 1, 'publisher_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Laskar Pelangi', 'desc' => 'Novel inspiratif karya Andrea Hirata', 'year_publish' => 2005, 'author_id' => 2, 'publisher_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Supernova', 'desc' => 'Novel karya Dewi Lestari', 'year_publish' => 2001, 'author_id' => 3, 'publisher_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Rock & Love', 'desc' => 'Novel romance karya Agnes Davonar', 'year_publish' => 2015, 'author_id' => 4, 'publisher_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Dilan 1990', 'desc' => 'Novel populer karya Pidi Baiq', 'year_publish' => 2014, 'author_id' => 5, 'publisher_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Garis Waktu', 'desc' => 'Novel inspiratif karya Fiersa Besari', 'year_publish' => 2014, 'author_id' => 6, 'publisher_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Rintik Sedu', 'desc' => 'Novel horor karya Risa Saraswati', 'year_publish' => 2013, 'author_id' => 7, 'publisher_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Manusia Setengah Salmon', 'desc' => 'Novel komedi karya Raditya Dika', 'year_publish' => 2011, 'author_id' => 8, 'publisher_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Jendela-Jendela', 'desc' => 'Novel anak-anak karya Clara Ng', 'year_publish' => 2015, 'author_id' => 9, 'publisher_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Perahu Kertas', 'desc' => 'Novel fantasi dan inspiratif karya Dee Lestari', 'year_publish' => 2009, 'author_id' => 10, 'publisher_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Senja di Jakarta', 'desc' => 'Novel romantis karya Marthino Lio', 'year_publish' => 2018, 'author_id' => 11, 'publisher_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Petualangan Si Kecil', 'desc' => 'Novel petualangan karya Mochamad Fahri', 'year_publish' => 2020, 'author_id' => 12, 'publisher_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Cinta yang Terlupakan', 'desc' => 'Novel percintaan karya Luluk HF', 'year_publish' => 2017, 'author_id' => 13, 'publisher_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Gentayangan', 'desc' => 'Novel horor feminis karya Intan Paramaditha', 'year_publish' => 2011, 'author_id' => 14, 'publisher_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Antologi Rasa', 'desc' => 'Novel romance dan drama karya Ika Natassa', 'year_publish' => 2011, 'author_id' => 15, 'publisher_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}