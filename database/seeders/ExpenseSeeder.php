<?php

namespace Database\Seeders;
use App\Models\Expense;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::pluck('id')->toArray();

        if(empty($employees)){
            return;
        }

        for ($i = 1; $i <= 15; $i++) {

            Expense::create([
                'employee_id' => $employees[array_rand($employees)],
                'amount' => rand(500, 15000),
                'purpose' => fake()->sentence(8),
                'document' => 'sample.pdf',
                'status' => collect([
                    'pending',
                    'approved',
                    'rejected'
                ])->random(),
                'action_at' => now()->subDays(rand(1,30))
            ]);
        }
    }
}