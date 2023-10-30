<?php

namespace Database\Seeders;

use App\Models\Memo;
use Illuminate\Database\Seeder;

class MemosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Memo::factory()->count(3)->create();
    }
}
