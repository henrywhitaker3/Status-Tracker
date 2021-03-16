<template>
    <Layout>
        <div class="mb-3">
            <inertia-link nostyle class="button button-primary" :href="'/services/' + check.service_id">Back to service</inertia-link>
        </div>
        <div class="flex flex-col space-y-4">
            <div class="card">
                <div class="check-badge">
                    <span class="type">{{ check.type }}</span>
                    <span class="check-url">{{ check.service.check_url }}</span>
                    <span class="response-code" :class="check.up ? 'response-code-success' : 'response-code-fail'">{{ check.response_code }}</span>
                </div>
            </div>
            <div class="card response-body">
                <pre>{{ check.response_body }}</pre>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '../../components/Layout';

export default {
    components: {
        Layout,
    },
    props: {
        check: Object,
    },
}
</script>
