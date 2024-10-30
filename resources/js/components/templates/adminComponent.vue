<template>
    <div>
        <sidebarComponent>
            <router-view></router-view>
        </sidebarComponent>
    </div>
</template>

<script>
import sidebarComponent from './SideBarComponent.vue';
import membershipForm from '../admin/membershipForm.vue';

export default {
  name: 'adminComponent',
  components: {
    sidebarComponent,
  },
};
</script>
