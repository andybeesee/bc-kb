<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Database\Factories\BoardFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $boards;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        if(User::where('email', 'admin@example.com')->count() === 0) {
            \App\Models\User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);
        }

        $this->boards = Board::factory()->count(random_int(1000, 2500))->create();

        Project::factory()->count(100)->create()
            ->each(function(Project $project) {
                $boardIds = $this->boards->random(random_int(5, 100))->pluck('id')->toArray();
                $project->boards()->sync($boardIds);
            });

        $this->boards->each(function(Board $board) {
            Task::factory()->count(random_int(10, 100))
                ->create([
                    'board_id' => $board->id,
                ]);
        });
    }
}
