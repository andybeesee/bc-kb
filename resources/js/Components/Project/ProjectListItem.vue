<template>
    <div class="px-2 py-3 hover:bg-zinc-100">
        <div class="grid md:grid-cols-6 justify-between">
            <div class="col-span-5 grid md:grid-cols-4 md:gap-4">
                <div class="flex items-center space-x-2 truncate col-span-2">
                    <ProjectStatusBadge :project="project" />
                    <Link :title="project.name" :href="route('projects.show', project.id)" class="truncate link font-medium">
                        #{{ project.id }} {{ project.name }}
                    </Link>
                </div>
                <TeamBadge class="truncate" v-if="project.team" :team="project.team" />
                <UserBadge class="truncate" v-if="project.owner" :user="project.owner" />
            </div>

            <div class="text-right">
                <TaskCountBox :counts="project" />
            </div>
        </div>
        <div class="flex items-center space-x-3 text-sm text-zinc-500 mt-1">

            <CurrentStatusBadge :status="project.current_status" />
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
