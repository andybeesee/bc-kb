<template>
    <div class="grid divide-y divide-zinc-300 dark:divide-zinc-700" v-if="tasks.length > 0">
        <TaskListItem
            @task-updated="handleUpdate"
            v-for="task in tasks"
            :task="task"
            :sortable="sortable"
            :show-checklist="showChecklist"
            :show-project="showProject"
        />
    </div>
    <div v-else>
        <slot name="no-tasks">
            No tasks
        </slot>
    </div>
</template>
<script>
import TaskListItem from "./TaskListItem.vue";

// TODO: Handle sorting, dropping
export default {
    components: {TaskListItem},
    props: {
        projectId: { type: Number, default: null },
        assignedTo: { type: Number, default: null },
        checklistId: { type: Number, default: null },
        filters: { type: Array, default: [] },
        sortable: { type: Boolean, default: false },
        showChecklist: { type: Boolean, default: false },
        showProject: { type: Boolean, default: false },
    },
    data() {
        return {
            tasks: [],
            loading: false,
        }
    },
    beforeMount() {
        this.loadTasks();
    },
    methods: {
        loadTasks() {
            axios.get(`/api/tasks`, { params: {
                project: this.projectId,
                checklist: this.checklistId,
                filters: this.filters,
                assigned: this.assignedTo,
            }}).then((r) => {
                this.tasks = r.data;
            });
        },
        handleUpdate(task) {
            console.log('caughtupdate', task);
            this.tasks = this.tasks.map(t => {
                if(t.id === task.id) {
                    return Object.assign(t, task);
                }

                return t;
            })
        }
    }
}
</script>
