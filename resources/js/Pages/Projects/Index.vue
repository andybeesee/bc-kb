<template>
    <div>
        <TabNav @change="tab = $event" :tabs="tabs" :active="tab" />
        <h1>Projects Index</h1>

        <div v-if="tab === 'dashboard'">
            Dashboard
        </div>

        <div v-if="tab === 'all'" class="mb-4">
            <div class="mb-4 grid divide-y">
                <ProjectListItem v-for="project in projects" :key="project.id" :project="project" />
            </div>
            <PageLinks @change="loadProjects" :paginator="paginator" />
        </div>

        <div v-if="tab === 'new'">
            New project form
        </div>

    </div>

</template>
<script>
import getPagination from "../../utils/getPagination.js";
import axios from "axios";
import PageLinks from "../../Components/PageLinks.vue";
import ProjectListItem from "../../Components/Project/ProjectListItem.vue";
import TabNav from "../../Components/TabNav.vue";

export default  {
    components: {TabNav, ProjectListItem, PageLinks },
    data() {
        return {
            tab: 'all',
            projects: [],
            loading: true,
            paginator: {},
            tabs: [
                { id: 'dashboard', name: 'Dashboard', icon: 'chart' },
                { id: 'all', name: 'All Projects', icon: 'list' },
                { id: 'create', name: 'New Projects', icon: 'plus-circle' },
            ]
        };
    },
    beforeMount() {
        this.loadProjects();
    },
    methods: {
        loadProjects(page = 1) {
            this.loading = true;
            axios.get(route('api.projects.index'), { params: { page }})
                .then((r) => {
                    this.projects = r.data.data;
                    this.paginator = getPagination(r.data);
                })
        }
    }
}
</script>
