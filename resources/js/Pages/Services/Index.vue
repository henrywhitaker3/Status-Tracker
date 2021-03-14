<template>
<div>
    <Layout>
        <div class="mb-6">
            <inertia-link href="/services/create" class="button button-primary">New service</inertia-link>
        </div>
        <div class="flex flex-col space-y-4">
            <ServiceSummary
                v-for="service in services"
                :key="service.id"
                :service="service"
            />
        </div>
    </Layout>
</div>
</template>

<script>
import Layout from '../../components/Layout';
import ServiceSummary from './components/ServiceSummary';

export default {
    components: {
        Layout,
        ServiceSummary,
    },
    props: ['services']
}
</script>
