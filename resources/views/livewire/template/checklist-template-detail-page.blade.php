<div class="md:mx-10">
    <div class="mb-4">
        @if($editing)
            <form class="max-w-lg" wire:submit="saveChanges">
                <div class="grid gap-4">
                    <x-form.input display="vertical" type="text" label="Checklist Name" wire:model="updatedName" name="updatedname" />

                    <x-form.textarea display="vertical" label="Checklist Description" wire:model="updatedDescription" name="updateddesc" />

                    <div>
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </div>
                </div>

            </form>
        @else
            <span class="text-xs">Checklist Template</span>
            <h1>{{ $checklistTemplate->name }}</h1>
            <div>{{ $checklistTemplate->description }}</div>

            <button class="btn btn-white" type="button" wire:click="$set('editing', true)">Edit</button>
        @endif
    </div>

    <div>
        <h2>Tasks</h2>

        <div x-data="{
            newTask: '',
            tasks: @entangle('tasks').live,
            init() {
                new Sortable(this.$refs.sortablelist, {
                    handle: '.handle',
                    onEnd: () => {
                        // TODO: rendering issues!
                        this.tasks = Array.from(this.$refs.sortablelist.querySelectorAll('[data-task-id]'))
                            .map((el) => {
                                return {
                                    id: parseInt(el.getAttribute('data-task-id')),
                                    task: el.querySelector('input').value,
                                };
                            });
                    }
                })
            },
            removeTask(id) {
                this.tasks = this.tasks.filter(t => t.id !== id);
            },
            updateTask(id, task) {
                this.tasks = this.tasks.map(t => {
                    if(t.id === id) {
                        return {
                            id,
                            task,
                        }
                    }

                    return t;
                })
            },
            addTask() {
                if(this.newTask === '') {
                    return;
                }

                this.tasks.push({
                    id: Math.random().toFixed(8).slice(2),
                    task: this.newTask,
                });

                this.newTask = '';
            },
        }">
            <div class="mb-2">
                <div class="font-semibold text-sm">New Task</div>
                <div class="flex items-center mb-2">
                    <input class="form-control form-control-sm" type="text" x-model="newTask" @keydown.enter="addTask" />
                    <button class="ml-1 btn-sm btn-white" type="button" @click="addTask">
                        Add Task
                    </button>
                </div>
            </div>
            <div x-ref="sortablelist">
                <template x-for="task in tasks" key="task.id">
                    <div :data-task-id="task.id" class="py-1 flex items-center">
                        <x-icon icon="grip-vertical" class="handle h-4 w-4 mr-1" />
                        <input
                            class="form-control form-control-sm"
                            type="text"
                            :value="task.task"
                            @input.debounce="updateTask(task.id, $event.target.value)"
                        >
                        <button class="ml-1" type="button" @click="removeTask(task.id)">
                            <x-icon icon="x-circle" class="h-4 w-4" />
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>
