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
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithFaker;

    protected $boards;

    protected $users;

    protected $teams;

    protected User $admin;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->setUpFaker();

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

                $project->status = collect(array_keys(config('statuses')))->random();
                $project->team_id = $this->faker->boolean(35) ? $team->id : null;
                $project->owner_id = $this->faker->boolean() ? $owner->id : null;
                $project->save();

                $numBoards = random_int(1, 20);
                \Log::debug("WE ARE GOING TO MAKE: ".$numBoards." BOARDS?");
                for($i = 0; $i < $numBoards; $i++) {
                    $board = Board::factory()->create(['project_id' => $project->id, 'sort' => $i]);

                    Task::factory()
                        ->create([
                            'board_id' => $board->id,
                            'assigned_to' => $this->admin->id,
                            'sort' => 0,
                        ]);

                    for($t = 0; $t < random_int(20, 100); $t++) {
                        Task::factory()
                            ->create([
                                'sort' => $t + 1,
                                'board_id' => $board->id,
                                'assigned_to' => $this->faker->boolean(40) ? $team->members->random()->id : null,
                                'completed_date' => $this->faker->boolean() ? $this->faker->date() : null,
                            ]);
                    }
                }
            });


    }
}
