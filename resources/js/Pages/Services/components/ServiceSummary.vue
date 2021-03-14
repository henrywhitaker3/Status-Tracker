<template>
    <inertia-link :href="'/services/' + service.id" nostyle>
        <div class="service-summary">
            <span
                class="status-indicator"
                :class="service.status === true ? 'status-indicator-up' : (service.status === false ? 'status-indicator-down' : 'status-indicator-none')"
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
    }
}
</script>
