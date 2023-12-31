<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\CurrentStatus;
use App\Models\Discussion;
use App\Models\Project;
use App\Models\Board;
use App\Models\ProjectTemplate;
use App\Models\Task;
use App\Models\Checklist;
use App\Models\ChecklistTemplate;
use App\Models\Team;
use App\Models\User;
use Database\Factories\BoardFactory;
use Database\Factories\ChecklistFactory;
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

    protected $statuses;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->setUpFaker();

        $this->statuses = collect(array_keys(config('statuses')));

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
        $this->admin = User::where('email', 'admin@example.com')->first();

        if(Team::count() < 25) {
            Team::factory(25)
                ->create()
                ->each(function(Team $team) {
                    $toAdd = random_int(3, $this->users->count() / 10);
                    $ids = $this->users->random($toAdd)->pluck('id')->toArray();
                    if($this->faker->boolean(65)) {
                        $ids[] = $this->admin->id;
                        $ids = array_unique($ids);
                    }
                    $team->members()->sync($ids);
                });
        }

        $this->teams = Team::with('members')->get();

        $this->teams->each(function(Team $team) {
            $boardsToMake = random_int(2, 50);
            for($i = 0; $i < $boardsToMake; $i++) {
                Board::factory()->create(['owner_id' => $team->id, 'owner_type' => 'team']);
            }
        });

        $this->teams->load('boards');

        $this->seedTemplates();
        $this->seedProjects();
    }


    public function addComments($type, $id, $qty = null)
    {
        $qty = $qty ?? random_int(1, 60);


        for($x = 0; $x < $qty; $x++) {
            $commentAuthorId = $this->users->random()->id;
            Comment::factory()
                ->create([
                    'attached_id' => $id,
                    'attached_type' => $type,
                    'created_by' => $commentAuthorId,
                    'updated_by' => $commentAuthorId,
                ]);

            // TODO: Reactions
        }
    }

    public function addStatuses($type, $id, $qty = 1)
    {
        for($x = 0; $x < $qty; $x++) {
            $statusAuthorId = $this->users->random()->id;

            CurrentStatus::factory()
                ->create([
                    'attached_id' => $id,
                    'attached_type' => $type,
                    'created_by' => $statusAuthorId,
                    'updated_by' => $statusAuthorId,
                ]);
        }
    }

    public function addDiscussions($type, $id, $qty)
    {
        for($i = 0; $i < $qty; $i++) {
            $commentQty = random_int(3, 50);
            $userId = $this->users->random()->id;

            $discussion = Discussion::factory()->create([
                'attached_type' => $type,
                'attached_id' => $id,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);

            $this->addComments('discussion', $discussion->id, $commentQty);

        }
    }

    protected function seedTemplates()
    {
        $tgs = [];
        for($i = 0; $i < 100; $i++) {
            $tasks = [];
            for($x = 0; $x < random_int(5, 100); $x++) {
                $tasks[] = ['id' => $x + 1, 'task' => $this->faker->sentence];
            }

            $tg = new ChecklistTemplate();
            $tg->name = $this->faker->city.' '.$this->faker->colorName.' '.random_int(1111, 9999);
            $tg->description = $this->faker->boolean ? null : $this->faker->sentence;
            $tg->tasks = $tasks;
            $tg->save();

            $tgs[] = $tg->id;
        }

        $tgs = collect($tgs);
        for($i = 0; $i < 200; $i++) {
            $pg = new ProjectTemplate();
            $pg->name = $this->faker->sentence.' ' .random_int(2222, 11111);
            $pg->description = $this->faker->boolean ? $this->faker->sentence : $this->faker->paragraph;
            $pg->save();

            $idSync = [];
            $ids = $tgs->random(random_int(2, 25))->toArray();
            foreach($ids as $index => $id) {
                $idSync[$id] = ['sort' => $index + 1];
            }

            $pg->checklistTemplates()->sync($idSync);
        }
    }

    protected function seedProjects()
    {
        Project::factory()->count(random_int(100, 500))->create()
            ->each(function(Project $project) {
                $team = $this->teams->random();
                $owner = $team->members->random();

                $project->status = $this->statuses->random();
                $project->team_id = $this->faker->boolean(65) ? $team->id : null;
                $project->owner_id = $this->faker->boolean() ? $owner->id : null;
                $project->save();

                $this->addStatuses('project', $project->id, random_int(1, 10));

                if($this->faker->boolean(70)) {
                    $dueDate = $this->faker->dateTimeBetween('-1 year', '+11 years')->format('Y-m-d');
                    $completeDated = $this->faker->dateTimeBetween('-6 months', '+10 years')->format('Y-m-d');
                    $isComplete = $this->faker->boolean();

                    Task::factory()
                        ->create([
                            'sort' => random_int(1, 50),
                            'project_id' => $project->id,
                            'due_date' => $this->faker->boolean() ? $dueDate : null,
                            'assigned_to' => $this->admin->id,
                            'completed_date' =>$isComplete ? $completeDated : null,
                            'completed_by' => $isComplete ? $this->admin->id : null,
                        ]);
                }

                if($this->faker->boolean(60)) {
                    $this->addDiscussions('project', $project->id, random_int(1, 50));
                }

                $tasksToMake = random_int(20, 200);

                $groups = $tasksToMake > 50 ? Checklist::factory()->count(random_int(2, 20))->create(['project_id' => $project->id]) : collect();

                for($t = 0; $t < random_int(20, 100); $t++) {
                    $dueDate = $this->faker->dateTimeBetween('-1 year', '+11 years')->format('Y-m-d');
                    $completeDated = $this->faker->dateTimeBetween('-6 months', '+10 years')->format('Y-m-d');
                    $completedBy = $this->users->random()->id;
                    $isComplete = $this->faker->boolean();
                    $groupId = $groups->count() > 0 && $this->faker->boolean(75) ? $groups->random()->id : null;

                    $task = Task::factory()
                        ->create([
                            'sort' => $t + 1,
                            'project_id' => $project->id,
                            'checklist_id' => $groupId,
                            'due_date' => $this->faker->boolean() ? $dueDate : null,
                            'assigned_to' => $this->faker->boolean(40) ? $team->members->random()->id : null,
                            'completed_date' => $isComplete ? $completeDated : null,
                            'completed_by' => $isComplete ? $completedBy : null,
                        ]);

                    if($this->faker->boolean()) {
                        $this->addStatuses('task', $task->id, random_int(1, 10));
                    }

                    if($this->faker->boolean(40)) {
                        $this->addComments('task', $task->id, random_int(1, 10));
                    }
                }
            });
    }
}
