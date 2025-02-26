<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Certification;
use App\Models\ProgrammingLanguage;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::factory(10)->create()->each(function ($user) {
            $user->certifications()->saveMany(Certification::factory(2)->make());
            $user->projects()->saveMany(Project::factory(2)->make());
        });

        Skill::factory(10)->create();
        ProgrammingLanguage::factory(15)->create();
    }

}
