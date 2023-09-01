<template>
    <div>
        <h1>Projects Index</h1>

        <div class="mb-4">

        </div>
        <PageLinks @change="loadProjects" :paginator="paginator" />
        {{ paginator }}
    </div>

</template>
<script>
import getPagination from "../../utils/getPagination.js";
import axios from "axios";
import PageLinks from "../../Components/PageLinks.vue";

export default  {
    components: { PageLinks },
    data() {
        return {
            projects: [],
            loading: true,
            paginator: {},
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
