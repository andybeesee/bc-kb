<template>
    <div class="px-2 py-3 hover:bg-zinc-100 dark:hover:bg-zinc-900">
        <div class="flex items-start">
            <div class="pt-0.5">
                <ProjectStatusBadge class="text-lg" :icon-only="true" :project="project" />
            </div>
            <div class="flex-grow ml-2">
                <div class="flex items-center">
                    <Link :title="project.name" :href="route('projects.show', project.id)" class="truncate font-semibold hover:underline">
                        #{{ project.id }} {{ project.name }}
                    </Link>
                    <TeamBadge class="ml-4 truncate" v-if="project.team" :team="project.team" />
                    <UserBadge class="ml-4 truncate" v-if="project.owner" :user="project.owner" />

                    <div class="ml-auto flex items-center space-x-3">
                        <span v-if="project.past_due_tasks_count > 0" class="text-sm text-red-600">
                            {{ project.past_due_tasks_count }} Late Task{{ project.past_due_tasks_count === 1 ? '' : 's' }}
                         </span>
                        <span v-if="project.incomplete_user_tasks_count > 0" class="text-sm text-blue-800 dark:text-blue-600">
                            {{ project.incomplete_user_tasks_count }} Task{{ project.incomplete_user_tasks_count === 1 ? '' : 's' }} Assigned to You
                        </span>
                        <Link class="text-lg" :href="route('projects.show', project.id)">
                            <i class="fas fa-long-arrow-right" />
                        </Link>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="col-span-5 text-sm text-zinc-500 dark:text-zinc-300">
                        <CurrentStatusBadge :status="project.current_status" />
                    </div>
                    <div class="text-right ml-auto">
                        <span v-if="project.incomplete_tasks_count > 0" class="text-sm text-zinc-400 dark:text-zinc-600">
                            {{ project.incomplete_tasks_count }} Incomplete Task{{ project.incomplete_tasks_count === 1 ? '' : 's' }}
                        </span>
                    </div>
                </div>
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
