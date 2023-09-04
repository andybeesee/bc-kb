<template>
    <div>
        <div class="mb-4">
            <TabNav @change="tab = $event" :tabs="tabs" :active="tab" />
        </div>


        <div v-if="tab === 'dashboard'">
            <ProjectIndexDashboard />
        </div>

        <div v-if="tab === 'all'">
            <ProjectIndexList />
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
import ProjectIndexList from "../../Components/Project/ProjectIndexList.vue";
import ProjectIndexDashboard from "../../Components/Project/ProjectIndexDashboard.vue";

export default  {
    components: {ProjectIndexDashboard, ProjectIndexList, TabNav, ProjectListItem, PageLinks },
    data() {
        return {
            tab: 'dashboard',
            tabs: [
                { id: 'dashboard', name: 'Dashboard', icon: 'chart' },
                { id: 'all', name: 'All Projects', icon: 'list' },
                { id: 'create', name: 'New Projects', icon: 'plus-circle' },
            ]
        };
    },
}
</script>
