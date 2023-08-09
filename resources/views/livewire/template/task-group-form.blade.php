<form
    wire:submit="save"
    class="grid gap-4"
    x-data="{
      newTask: '',
      tasks: @entangle('tasks'),
      init() {
        console.log(this.tasks.map(t => t.id), this.$refs.tasklist);
        this.sortable= new Sortable(this.$refs.tasklist, {
            onEnd: () => {
                console.log('sorted');
                const updated = [];

                Array.from(this.$refs.tasklist.querySelectorAll('[data-task]'))
                    .forEach(el => {
                        updated.push({
                            // giving everything a new id lets sorting work....
                            id: Math.random().toFixed(9).slice(2),
                            task: el.querySelector('.task-text').textContent,
                        });
                    });

                this.$nextTick(() => this.tasks = updated);
                // this.tasks = updated;
            }
        });
      },
      addTask() {
        if(this.newTask === '') {
            return;
        }
        this.tasks.push({ id: Math.random(), task: this.newTask });
        this.newTask = '';
        this.$refs.newTaskInput.focus();
      },
      removeTask(id) {
        this.tasks = this.tasks.filter(t => t.id !== id);
      }
    }"
>
    <x-form.input type="text" name="name" wire:model="name" label="Name" />

    <x-form.textarea name="description" wire:model="description" label="Description" help="When should you use this?" />
    <div class="form-group horizontal">
        <div class="form-label">
            Tasks
        </div>
        <div

            class="form-control-container"
        >
            <div class="w-1/3 px-1 flex items-center">
                <input
                    class="form-control"
                    placeholder="New Task"
                    type="text" name="new-task-input"
                    @keydown.enter.prevent="addTask"
                    x-ref="newTaskInput"
                    x-model="newTask"
                />
                <button class="p-1 text-sm btn btn-white btn-attached-left flex-grow bg-white" type="button" @click="addTask">
                    Add
                </button>
            </div>


            <div x-ref="tasklist" class="task-list mt-1 grid w-1/3">
                <template x-for="task in tasks" :key="task.id">
                    <div :data-task="task.id" class="p-1 flex items-center hover:bg-zinc-200 dark:hover:bg-zinc-600">
                        <div class="cursor-move mr-1">
                            <x-icon icon="grip-vertical" class="h-4 w-4" />
                        </div>

                        <span class="task-text" x-text="task.task"></span>

                        <button type="button" @click="removeTask(task.id)" title="Remove task" class="ml-auto hover:text-red-600">
                            <x-icon icon="x-circle" class="h-4 w-4" />
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="form-group mt-4 horizontal">
        <div class="form-label"></div>
        <div class="form-control-container">
            <button class="btn btn-primary w-1/3">
                Save Task Group Template
            </button>
        </div>
    </div>

</form>
