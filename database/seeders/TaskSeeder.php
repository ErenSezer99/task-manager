<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'test@test.com')->first();

        if ($user) {
            $priorities = ['high', 'medium', 'low'];

            foreach (range(1, 23) as $index) {
                DB::table('tasks')->insert([
                    'user_id' => $user->id,
                    'uuid' => Str::uuid(),
                    'title' => 'Görev ' . $index,
                    'description' => 'Görev Açıklaması ' . $index,
                    'priority' => $priorities[array_rand($priorities)],
                    'due_date' => now()->addDays(rand(1, 9)),
                    'status' => 'in_progress',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
