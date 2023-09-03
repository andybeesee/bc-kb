<template>
    <div class="p-1">
        <div class="grid md:grid-cols-6 justify-between">
            <div class="col-span-5 grid md:grid-cols-3 md:gap-4">
                <Link :title="project.name" :href="route('projects.show', project.id)" class="truncate link font-medium">
                    #{{ project.id }} {{ project.name }}
                </Link>
                <TeamBadge class="truncate" v-if="project.team" :team="project.team" />
                <UserBadge class="truncate" v-if="project.owner" :user="project.owner" />
            </div>

            <div class="text-right">
                <TaskCountBox :counts="project" />
            </div>
        </div>

    </div>
</template>
<script>
import TaskCountBox from "../TaskCountBox.vue";
import TeamBadge from "../TeamBadge.vue";
import UserBadge from "../UserBadge.vue";

export default {
    components: {UserBadge, TaskCountBox, TeamBadge},
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
