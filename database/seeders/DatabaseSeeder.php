<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Database\Factories\BoardFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    protected $boards;

    protected $users;

    protected User $admin;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(DB::table('users')->count() < 200) {
            User::factory(200)->create();
        }

        if(User::where('email', 'admin@example.com')->count() === 0) {
            \App\Models\User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);
        }

        $this->admin = User::where('email', 'admin@example.com')->first();

        $this->users = User::all('id');

        Project::factory()->count(random_int(100, 500))->create()
            ->each(function(Project $project) {
                $boards = Board::factory()->count(random_int(5, 15))->create(['project_id' => $project->id]);

                $boards->each(function(Board $board) {
                    Task::factory()
                        ->create([
                            'board_id' => $board->id,
                            'assigned_to' => $this->admin->id,
                        ]);

                    for($i = 0; $i < random_int(10, 100); $i++) {
                        Task::factory()
                            ->create([
                                'board_id' => $board->id,
                                'assigned_to' => random_int(1, 100) > 40 ? $this->users->random()->id : null,
                            ]);
                    }

                });
            });


    }
}
