<template>
    <div class="py-1 px-2">
        <div class="flex items-center">
            <i class="fas fa-grip-vertical" v-if="sortable" />
            <button
                type="button"
                @click="toggleComplete"
                class="text-lg"
                :class="{ 'text-green-600': task.is_complete }"
            >
                <!-- TODO: complete/uncomplete -->
                <i class="fas fa-check-square" v-if="task.is_complete" />
                <i class="far fa-square" v-else />
            </button>
            <div class="ml-2">
                {{ task.name }}
            </div>

            <Link title="Project" :href="route('projects.show', task.project_id)" class="text-xs ml-2.5 hover:underline px-2 py-0.5 bg-zinc-100 rounded dark:bg-zinc-700" v-if="showProject && task.project">
                {{ task.project.name }}
            </Link>

            <Link title="Checklist" :href="route('checklists.show', task.checklist_id)" class="text-xs ml-2.5 hover:underline px-2 py-0.5 bg-zinc-100 rounded dark:bg-zinc-700" v-if="showChecklist && task.checklist">
                {{ task.checklist.name }}
            </Link>

            <div class="flex items-center space-x-4 ml-auto text-sm">
                <button type="button" v-if="task.files_count > 0">
                    <!-- TODO: Open detail -->
                    <i class="far fa-paperclip" />
                    {{ task.files_count }} Files
                </button>
                <button type="button" v-if="task.comments_count > 0">
                    <!-- TODO: Open detail -->
                    <i class="far fa-comment-alt" />
                    {{ task.comments_count }} Files
                </button>

                <div v-if="task.is_complete" class="flex text-green-500 items-center space-x-2">
                    <div>Completed</div>
                    <UserSelector
                        :user="task.completed_by"
                        :can-remove="false"
                        @change="updatedCompletedBy"
                    />

                    <DateChanger
                        prefix="Completed"
                        :can-remove="false"
                        :date="task.completed_date"
                        @change="updateCompletedDate"
                    />
                </div>
                <div class="flex items-center space-x-3" v-else>
                    <UserSelector
                        placeholder="Not Assigned"
                        :user="task.assigned_to"
                        @change="updatedAssignee"
                    />

                    <DateChanger
                        prefix="Due"
                        :class="task.is_late ? 'text-red-700 dark:text-red-300' : ''"
                        placeholder="No Due Date"
                        :date="task.due_date"
                        @change="updateDueDate"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// TODO: handle file dragover and upload
// TODO: Open modal with detailed info
import DateChanger from "../DateChanger.vue";
import UserSelector from "../UserSelector.vue";

export default {
    components: {DateChanger, UserSelector},
    props: {
        sortable: { type: Boolean, default: false },
        showChecklist: { type: Boolean, default: false },
        showProject: { type: Boolean, default: false },
        task: Object,
    },
    methods: {
        updateDueDate(newDate) {
            axios.put(route('api.tasks.update.due-date', this.task.id), {
                    due_date: newDate,
                })
                .then((r) => {
                    this.$emit('task-updated', r.data);
                })
        },
        updatedAssignee(newId) {
            axios.put(route('api.tasks.update.assigned-to', this.task.id), {
                    user: newId,
                })
                .then((r) => {
                    this.$emit('task-updated', r.data);
                })
        },
        toggleComplete() {
            axios.put(route('api.tasks.toggle-complete', this.task.id))
                .then((r) => {
                    this.$emit('task-updated', r.data);
                })
        },
        updatedCompletedBy(newId) {
            axios.put(route('api.tasks.update.completed-by', this.task.id), {
                    user: newId,
                })
                .then((r) => {
                    this.$emit('task-updated', r.data);
                })
        },
        updateCompletedDate(newDate) {
            axios.put(route('api.tasks.update.completed-date', this.task.id), {
                    date: newDate,
                })
                .then((r) => {
                    this.$emit('task-updated', r.data);
                })
        },
    }
}
</script>
