<template>
    <div>
        <h1>Project Dashboard</h1>

        <div class="card">
            <div class="card-title">Current Projects</div>
            <div class="divide-y dark:divide-zinc-700">
                <ProjectListItem v-for="project in currentProjects" :project="project" />
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import ProjectListItem from "./ProjectListItem.vue";

export default {
    components: {ProjectListItem},
    beforeMount() {
      this.loadCurrentProjects();
    },
    data() {
        return {
            currentProjects: [],
            loadingProjects: false,
        };
    },
    methods: {
        loadCurrentProjects() {
            this.loadingProjects = true;
            axios.get(`/api/projects`, { params: { per_page: 1200, filter: 'user_current' } })
                .then((r) => {
                    this.currentProjects = r.data.data;
                    this.loadingProjects = false;
                })
        },
    }
}
</script>
