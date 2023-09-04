<template>
    <div class="px-2 py-3 hover:bg-zinc-100 dark:hover:bg-zinc-900">
        <div class="grid md:grid-cols-6 justify-between">
            <div class="col-span-5 grid md:grid-cols-4 md:gap-4">
                <div class="flex items-center truncate ">
                    <ProjectStatusBadge class="text-lg" :icon-only="true" :project="project" />
                    <Link :title="project.name" :href="route('projects.show', project.id)" class="truncate ml-2 link font-medium">
                        #{{ project.id }} {{ project.name }}
                    </Link>
                </div>
                <div class="ml-2 flex items-center space-x-3 text-xs">
                    <TeamBadge class="truncate" v-if="project.team" :team="project.team" />
                    <UserBadge class="truncate" v-if="project.owner" :user="project.owner" />
                </div>
            </div>

            <div class="text-right">
                <span v-if="project.past_due_tasks_count > 0" class="text-sm text-red-600">
                    {{ project.past_due_tasks_count }} Late Task{{ project.past_due_tasks_count === 1 ? '' : 's' }}
                </span>
            </div>
        </div>
        <div class="grid grid-cols-6 mt-0.5 ml-5">
            <div class="col-span-5 text-sm text-zinc-500">
                <CurrentStatusBadge :status="project.current_status" />
            </div>
            <div class="text-right ml-auto">
                <span v-if="project.incomplete_user_tasks_count > 0" class="text-sm text-blue-800">
                    {{ project.incomplete_user_tasks_count }} Task{{ project.incomplete_user_tasks_count === 1 ? '' : 's' }} Assigned to You
                </span>
            </div>
        </div>
    </div>
</template>
<script>
import TaskCountBox from "../TaskCountBox.vue";
import TeamBadge from "../TeamBadge.vue";
import UserBadge from "../UserBadge.vue";
import ProjectStatusBadge from './ProjectStatusBadge.vue';
import CurrentStatusBadge from "../CurrentStatusBadge.vue";
export default {
    components: {CurrentStatusBadge, ProjectStatusBadge, UserBadge, TaskCountBox, TeamBadge},
    props: {
        project: Object,
    },
    data() {
        return {
            editing: false,
            updatingStatus: false,
            detailOpen: false,
        };
    },
}
</script>
