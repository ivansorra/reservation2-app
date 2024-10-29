<template>
    <div>
        <Sidebar @load-form="handleLoadForm">
            <component :is="currentComponent"></component>
        </Sidebar>
    </div>
</template>

<script>
import Sidebar from './sidebarComponent.vue';
import membershipForm from '../admin/membershipForm.vue';

export default {
    name: 'adminComponent',
    components: {
        Sidebar,
        membershipForm,
    },
    data() {
        return {
            currentComponent: null,
        };
    },
    methods: {
        handleLoadForm(componentName) {
            if (componentName === 'membership') {
                this.currentComponent = 'membershipForm';
            }
        }
    }
}
</script>
