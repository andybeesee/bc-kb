<div>
    <form wire:submit="saveTemplate">
        <div class="grid gap-4">
            <x-form.select wire:model.live="type" :options="['project' => 'Project', 'task-group' => 'Task Group']" name="type" label="Type" />

            <x-form.input type="text" name="name" wire:model="name" label="Name" />

            <x-form.textarea name="description" wire:model="description" label="Description" help="When should you use this?" />


            @if($type === 'project')
                <div class="form-group">
                    <div class="form-label">Include Task Groups</div>
                    <div class="form-control-container">
                        ...
                    </div>
                </div>
            @else

                <div class="form-group">
                    <div class="form-label">
                        Tasks
                    </div>
                    <div
                        x-data="{
                        tasks: @entangle('tasks'),
                        newTask: '',
                        sortable: null,
                        init() {
                            this.sortable = new Sortable(this.$refs.taskList, {
                                onSort() {
                                    console.log('on sort');
                                },
                                onUpdate() {
                                    console.log('on update');
                                },
                                onEnd: () => {
                                    console.log('on end hit!', this.sortable.toArray());
                                    const newTasks = [];

                                    this.tasks = Array.from(this.$refs.taskList.querySelectorAll(`[data-task]`))
                                        .map((taskel) => {
                                            return {
                                                id: Math.random().toFixed(8).slice(2),
                                                task: taskel.querySelector('.task-text').textContent
                                            };
                                        });
                                }
                            })
                        },
                        addTask() {
                            this.tasks.push({ id: Math.random().toFixed(8).slice(2), task: this.newTask });
                            this.newTask = '';
                        },
                        removeTask(id) {
                            console.log('pre', this.tasks);
                            // this.tasks = this.tasks.filter(t => t.id !== id)

                            $wire.set('tasks', this.tasks.filter(t => t.id !== id));
                            console.log('post', this.tasks);
                        }
                    }"
                        class="form-control-container"
                    >

                        <div class="w-1/3 px-1 flex items-center">
                            <input class="form-control" placeholder="New Task" type="text" name="new-task-input" @keydown.enter.prevent="addTask" x-model="newTask" />
                            <button class="p-1 text-sm btn btn-white btn-attached-left flex-grow bg-white" type="button" @click="addTask">
                                Add
                            </button>
                        </div>


                        <div x-ref="taskList" class="mt-1 grid w-1/3">
                            <template x-for="task in tasks" :key="task.id">
                                <div x-bind:data-task="task.id" class="p-1 flex items-center hover:bg-zinc-200 dark:hover:bg-zinc-600">
                                    <div class="cursor-move mr-1">
                                        <x-icon icon="grip-vertical" class="h-4 w-4" />
                                    </div>

                                    <span class="task-text" x-text="task.task"></span>

                                    <button @click="removeTask(task.id)" title="Remove task" class="ml-auto hover:text-red-600">
                                        <x-icon icon="x-circle" class="h-4 w-4" />
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @endif


            <div class="form-group">
                <div class="form-label"></div>
                <div class="form-control-container">
                    <button type="submit" class="btn btn-primary w-1/3">
                        Add Template
                    </button>
                </div>
            </div>
        </div><!-- end of fields -->
    </form>
    {{-- Stop trying to control. --}}
</div>
