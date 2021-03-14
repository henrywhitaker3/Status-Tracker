<template>
    <inertia-link :href="'/services/' + service.id" nostyle>
        <div class="service-summary">
            <span
                class="status-indicator"
                :class="getStatusClass()"
            >
                <font-awesome-icon icon="circle" />
            </span>
            <span>{{ service.name }}</span>
        </div>
    </inertia-link>
</template>

<script>
export default {
    props: {
        service: Object
    },
    methods: {
        getStatusClass() {
            if(!this.service.enabled) {
                return 'status-indicator-none';
            }

            if(this.service.status) {
                return 'status-indicator-up';
            }

            return 'status-indicator-down';
        }
    }
}
</script>
