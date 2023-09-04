<template>
    <div>
        <TabNav @change="tab = $event" :tabs="tabs" :active="tab" />


        <div v-if="tab === 'dashboard'">
            Dashboard
        </div>

        <div v-if="tab === 'all'" class="mt-4">
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

export default  {
    components: {ProjectIndexList, TabNav, ProjectListItem, PageLinks },
    data() {
        return {
            tab: 'all',
            tabs: [
                { id: 'dashboard', name: 'Dashboard', icon: 'chart' },
                { id: 'all', name: 'All Projects', icon: 'list' },
                { id: 'create', name: 'New Projects', icon: 'plus-circle' },
            ]
        };
    },
}
</script>
