<template>
    <Layout>
        <div class="flex flex-col space-y-4">
            <GeneralSettings :settings="settings.general" />
            <NotificationSettings :settings="settings.notifications" />
        </div>
    </Layout>
</template>

<script>
import Layout from '../../components/Layout';
import GeneralSettings from './components/GeneralSettings';
import NotificationSettings from './components/NotificationSettings';

export default {
    components: {
        Layout,
        GeneralSettings,
        NotificationSettings,
    },
    props: {
        settings: Object,
    },

}
</script>
