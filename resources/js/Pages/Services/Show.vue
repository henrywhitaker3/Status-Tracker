<template>
<div>
    <Layout>
        <div class="mb-3">
            <inertia-link nostyle href="/" class="button button-primary mr-2 mb-2">Back to All Services</inertia-link>
            <button @click="destroy" class="button button-danger">Delete</button>
        </div>
        <div class="flex flex-col space-y-4">
            <div class="card">
                <div class="block sm:flex justify-between items-center space-y-1 mb-2">
                    <div>
                        <h1>{{ service.name }}</h1>
                        <h2>{{ service.status ? 'Up' : 'Down' }} for {{ prettyDiff(service.status_changed_at) }}</h2>
                    </div>
                    <UptimeGraph :checks="checks.data" />
                </div>
                <div class="flex flex-col space-y-2">
                    <div class="check-badge">
                        <span class="type">Check URL</span>
                        <a rel="noreferer" target="_blank" :href="service.check_url" class="check-url rounded-r">{{ service.check_url}}</a>
                    </div>
                    <div class="check-badge">
                        <span class="type">Access URL</span>
                        <a rel="noreferer" target="_blank" :href="service.access_url" class="check-url rounded-r">{{ service.access_url}}</a>
                    </div>
                </div>
            </div>
            <div class="table-wrapper">
                <ChecksTable :checks="checks" />
            </div>
            <Links :links="checks.links" />
        </div>
    </Layout>
</div>
</template>

<script>
import Layout from '../../components/Layout';
import UptimeGraph from '../../components/UptimeGraph';
import ChecksTable from './components/ChecksTable';
import Links from '../../components/Links';

export default {
    metaInfo() {
        return { title: this.service.name }
    },
    components: {
        Layout,
        UptimeGraph,
        ChecksTable,
        Links
    },
    props: {
        service: Object,
        checks: Object,
    },
    data() {
        return {
            refresh: null
        }
    },
    methods: {
        startRefresh() {
            let self = this;

            this.refresh = setInterval(function() {
                self.$inertia.reload();
            }, 2500);
        },
        cancelRefresh() {
            clearInterval(this.refresh);
        },
        destroy() {
            this.$inertia.delete('/services/' + this.service.id);
        }
    },
    destroyed() {
        this.cancelRefresh();
    },
    mounted() {
        this.startRefresh();
    }
}
</script>
