<template>
    <div>
        <h1>All Projects</h1>
        <div class="mb-3">
            <input @input="updateSearch" type="text" class="w-full form-control" placeholder="Search projects" />
        </div>
        <div class="mb-4 grid divide-y">
            {{ search }}
            <ProjectListItem v-for="project in projects" :key="project.id" :project="project" />
        </div>
        <PageLinks @change="loadProjects" :paginator="paginator" />
    </div>
</template>
<script>
import { debounce } from "lodash";
import ProjectListItem from "./ProjectListItem.vue";
import PageLinks from "../PageLinks.vue";
import axios from "axios";
import getPagination from "../../utils/getPagination.js";

export  default {
    components: {
        ProjectListItem,
        PageLinks,
    },
    data() {
        return {
            projects: [],
            loading: true,
            paginator: {},
            search: '',
            filters: [],
        };
    },
    beforeMount() {
        this.loadProjects();
        this.updateSearch = debounce((e) => {
            this.search = e.target.value;
            this.loadProjects(1);
        }, 200)
    },
    methods: {
        loadProjects(page = 1) {
            this.loading = true;
            console.log('laoding');
            axios.get(route('api.projects.index'), { params: { page, search: this.search, }})
                .then((r) => {
                    this.projects = r.data.data;
                    this.paginator = getPagination(r.data);
                })
        },
    }
}
</script>
