<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Board;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Database\Factories\BoardFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    protected $boards;

    protected $users;

    protected $teams;

    protected User $admin;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(User::where('email', 'admin@example.com')->count() === 0) {
            \App\Models\User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'admin' => true,
            ]);
        }

        if(DB::table('users')->count() < 200) {
            User::factory(200)->create();
        }

        $this->users = User::all('id');

        if(Team::count() < 25) {
            Team::factory(25)
                ->create()
                ->each(function(Team $team) {
                    $toAdd = random_int(3, $this->users->count() / 10);
                    $ids = $this->users->random($toAdd)->pluck('id')->toArray();
                    $team->members()->sync($ids);
                });
        }

        $this->teams = Team::with('members')->get();

        $this->admin = User::where('email', 'admin@example.com')->first();

        Project::factory()->count(random_int(100, 500))->create()
            ->each(function(Project $project) {
                $team = $this->teams->random();
                $owner = $team->members->random();

                $project->team_id = $team->id;
                $project->owner_id = $owner->id;
                $project->save();

                $numBoards = random_int(2, 15);
                for($i = 0; $i < $numBoards; $i++) {
                    $board = Board::factory()->create(['project_id' => $project->id, 'sort' => $i]);

                    Task::factory()
                        ->create([
                            'board_id' => $board->id,
                            'assigned_to' => $this->admin->id,
                        ]);

                    for($i = 0; $i < random_int(10, 100); $i++) {
                        Task::factory()
                            ->create([
                                'board_id' => $board->id,
                                'assigned_to' => random_int(1, 100) > 40 ? $team->members->random()->id : null,
                            ]);
                    }
                }
            });


    }
}
