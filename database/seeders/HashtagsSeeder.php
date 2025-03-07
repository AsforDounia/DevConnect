<?php

namespace Database\Seeders;

use App\Models\Hashtag;
use App\Models\Hashtags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HashtagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hashtag::factory() -> count(5)-> create();
    }
}
