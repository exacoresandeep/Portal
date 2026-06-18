<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([AttendanceSeeder::class,]);
        $this->call([
            LeaveSeeder::class,
            ]);
        $this->call(DepartmentSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(LeaveSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(ExpenseSeeder::class);
    }
}
