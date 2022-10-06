<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\job;
use App\Models\skill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        job::create([
            'name' => 'Frontend Web Developer',
        ]);
        job::create([
            'name' => 'Backend Web Developer',
        ]);
        job::create([
            'name' => 'Fullstack Web Developer',
        ]);
        skill::create([
            'name' => 'Postgre',
        ]);
        skill::create([
            'name' => 'Laravel',
        ]);
        skill::create([
            'name' => 'PHP',
        ]);
    }
}
