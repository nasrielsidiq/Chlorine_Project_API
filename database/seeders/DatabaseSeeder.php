<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Industry;
use App\Models\Internship;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            // 'id' => '1',
            'username' => 'rpl',
            'role' => 'industry',
            'email' => 'rpl@industry.id',
            'password' => bcrypt('123')
        ]);

        User::create([
            'username' => 'smk_ypc',
            'role' => 'school',
            'email' => 'smkypc@school.id',
            'password' => bcrypt('123')
        ]);

        School::create([
            'npsn' => '20210704',
            'user_id' => 2,
            'name' => 'SMKS YPC TASIKMALAYA',
            'address' => 'di cintawana',
            'headmaster' => 'Drs. Ujang Sanusi M.M'
        ]);

        for ($i=0; $i < 10; $i++) {
            User::create([
                'username' => 'student'.$i,
                'role' => 'student',
                'email' => 'student'.$i.'@student.id',
                'password' => bcrypt('123')
            ]);
        }

        foreach (User::where('role', 'student')->get() as $key => $value) {
            Student::create([
                'user_id' => $value->id,
                'school_id' => 1,
                'nisn' => '1233211'.$key,
                'full_name' => $value->username.' lengkap',
                'birth_day' => today(),
                'address' => 'di lemur masing masing',
                'major' => 'Rekayasa Perangkat Lunak',
                'potency' => 'jadi jalma sukses'
            ]);
        }
        Industry::create([
            'user_id' => 1,
            'name' => 'IoT Factory SMK YPC',
            'owner' => 'RPL',
            'address' => 'di ypc',
            'latitude' => -7.361465688690356,
            'longitude' => 108.1059279628386
        ]);
        foreach (Student::get() as $key => $value) {
            Internship::create([
                'course' => 'IoT Engginer',
                'student_id' => $value->id,
                'industry_id' => 1,
                'from' => Carbon::now(),
                'to' => Carbon::now()->addMonth(3),
                'is_accepted' => true,
            ]);
        }

        // Attendance::create([
        //     ''
        // ]);

    }
}
