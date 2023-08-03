<div>
    <form wire:submit="saveTemplate">
        <div class="grid gap-4">
            <x-form.select :options="['project', 'task-group']" name="type" label="Type" />

            <x-form.input type="text" name="name" wire:model="name" label="Name" />

            <x-form.textarea name="description" wire:model="description" label="Description" help="When should you use this?" />

            <div class="form-group">
                <div class="form-label">
                    Tasks
                </div>
                <div
                    x-data="{
                        tasks: @entangle('tasks'),
                        newTask: '',
                        init() {
                            new Sortable(this.$refs.taskList, {
                                onEnd: () => {
                                    console.log('you got sorted!');
                                    const newTasks = [];

                                    Array.from(this.$refs.taskList.querySelectorAll(`[data-task]`))
                                        .forEach((taskel) => {
                                            newTasks.push({
                                                id: taskel.getAttribute('data-task'),
                                                task: taskel.querySelector('.task-text').textContent
                                            })
                                        })

                                    console.log('newtasks', newTasks);
                                    this.tasks = newTasks;
                                }
                            })
                        },
                        addTask() {
                            this.tasks.push({ id: Math.random().toFixed(8).slice(2), task: this.newTask });
                            this.newTask = '';
                        },
                        removeTask(id) {
                            this.tasks = this.tasks.filter(t => t.id !== id);
                        }
                    }"
                    class="form-control-container"
                >

                    <div class="w-1/3 flex items-center">
                        <input class="form-control" placeholder="New Task" type="text" name="new-task-input" @keydown.enter="addTask" x-model="newTask" />
                        <button class="p-1 btn btn-white btn-attached-left flex-grow bg-white" type="button" @click="addTask">
                            Add task
                        </button>
                    </div>


                    <div x-ref="taskList" class="mt-1 grid w-1/3">
                        <template x-for="task in tasks" :key="task.id">
                            <div x-bind:data-task="task.id" class="py-0.5 flex items-center hover:bg-zinc-200 dark:hover:bg-zinc-600">
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
        </div>
    </form>
    {{-- Stop trying to control. --}}
</div>
