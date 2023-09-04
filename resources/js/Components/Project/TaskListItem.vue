<template>
    <div class="p-2">
        <div class="flex items-center">
            <i class="fas fa-grip-vertical" v-if="sortable" />
            <button type="button">
                <!-- TODO: complete/uncomplete -->
                <i class="far fa-check-square" v-if="task.complete" />
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

                <div v-if="task.complete">
                    Completion info
                </div>
                <div class="flex items-center space-x-3" v-else>
                    <UserSelector
                        placeholder="Not Assigned"
                        :user="task.assigned_to"
                        @change="updatedAssignee"
                    />

                    <DateChanger
                        prefix="Due"
                        :class="task.is_late ? 'text-red-700' : 'text-butt'"
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
            axios.put(route('api.tasks.update.assigned', this.task.id), {
                    user: newId,
                })
                .then((r) => {
                    this.$emit('task-updated', r.data);
                })
        },
    }
}
</script>
