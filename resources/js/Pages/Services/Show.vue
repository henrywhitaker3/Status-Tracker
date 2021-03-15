<template>
<div>
    <Layout>
        <div class="mb-6">
            <inertia-link href="/services" class="button button-primary mr-2 mb-2">Back to All Services</inertia-link>
            <button @click="destroy" class="button button-danger">Delete</button>
        </div>
        <div class="flex flex-col space-y-4">
            <div class="card flex flex-col space-y-1">
                <h1>{{ service.name }}</h1>
                <h2>{{ service.status ? 'Up' : 'Down' }} for {{ prettyDiff(service.status_changed_at) }}</h2>
                <UptimeGraph :checks="checks" />
            </div>
            <div class="card">
                <h2>Checks</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Up</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="check in checks"
                            :key="check.id"
                        >
                            <td>{{ check.type }}</td>
                            <td>{{ check.up ? 'Yes' : 'No' }}</td>
                            <td>{{ prettyDiff(check.created_at) }} ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</div>
</template>

<script>
import Layout from '../../components/Layout';
import UptimeGraph from '../../components/UptimeGraph';

export default {
    components: {
        Layout,
        UptimeGraph,
    },
    props: {
        service: Object,
        checks: Array,
    },
    methods: {
        destroy() {
            this.$inertia.delete('/services/' + this.service.id);
        }
    }
}
</script>
