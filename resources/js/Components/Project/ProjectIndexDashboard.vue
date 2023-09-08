<template>
    <div>
        <h1>Project Dashboard</h1>
        <div class="grid gap-4">
            <div class="card">
                <div class="card-title">Current Projects</div>
                <div class="divide-y dark:divide-zinc-700">
                    <ProjectListItem @projectUpdated="handleProjectUpdate" v-for="project in currentProjects" :project="project" />
                </div>
            </div>

            <div class="card">
                <div class="card-title">Past Due Tasks</div>
                <TaskList :filters="['past_due']" :assigned-to="$page.props.auth.id" :show-checklist="true" :show-project="true" />
            </div>

            <div class="card">
                <div class="card-title">Due Date Upcoming</div>
                <TaskList :filters="['upcoming']" :assigned-to="$page.props.auth.id" :show-checklist="true" :show-project="true" />
            </div>

            <div class="card">
                <div class="card-title">Incomplete Tasks</div>
                <TaskList :filters="['incomplete']" :assigned-to="$page.props.auth.id" :show-checklist="true" :show-project="true" />
            </div>
        </div>

    </div>
</template>
<script>
import axios from "axios";
import ProjectListItem from "./ProjectListItem.vue";
import TaskList from "./TaskList.vue";
import Modal from "../Modal.vue";

export default {
    components: {Modal, TaskList, ProjectListItem},
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
        handleProjectUpdate(p) {
            console.log('handle p', p);
        }
    }
}
</script>
