<template>
<div>
    <Layout>
        <div class="mb-3">
            <inertia-link nostyle href="/services" class="button button-primary mr-2 mb-2">Back to All Services</inertia-link>
            <button @click="destroy" class="button button-danger">Delete</button>
        </div>
        <div class="flex flex-col space-y-4">
            <div class="card block sm:flex justify-between items-center space-y-1">
                <div>
                    <h1>{{ service.name }}</h1>
                    <h2>{{ service.status ? 'Up' : 'Down' }} for {{ prettyDiff(service.status_changed_at) }}</h2>
                </div>
                <UptimeGraph :checks="checks.data" />
            </div>
            <div class="card">
                <h2>Checks</h2>
                <ChecksTable :checks="checks" />
            </div>
        </div>
    </Layout>
</div>
</template>

<script>
import Layout from '../../components/Layout';
import UptimeGraph from '../../components/UptimeGraph';
import ChecksTable from './components/ChecksTable';

export default {
    metaInfo() {
        return { title: this.service.name }
    },
    components: {
        Layout,
        UptimeGraph,
        ChecksTable,
    },
    props: {
        service: Object,
        checks: Object,
    },
    methods: {
        destroy() {
            this.$inertia.delete('/services/' + this.service.id);
        }
    }
}
</script>
