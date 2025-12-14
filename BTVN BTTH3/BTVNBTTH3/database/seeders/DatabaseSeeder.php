<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Library;
use App\Models\Book;
use App\Models\Renter;
use App\Models\Laptop;
use App\Models\ItCenter;
use App\Models\HardwareDevice;
use App\Models\Cinema;
use App\Models\Movie;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Sinh 5 thư viện, mỗi thư viện có 10 cuốn sách
        Library::factory(5)->has(Book::factory()->count(10))->create();

        // 2. Sinh 5 người thuê, mỗi người thuê 2 laptop
        Renter::factory(5)->has(Laptop::factory()->count(2))->create();

        // 3. Sinh 5 trung tâm IT, mỗi trung tâm có 8 thiết bị
        ItCenter::factory(5)->has(HardwareDevice::factory()->count(8))->create();

        // 4. Sinh 5 rạp chiếu, mỗi rạp có 5 bộ phim
        Cinema::factory(5)->has(Movie::factory()->count(5))->create();
    }
}