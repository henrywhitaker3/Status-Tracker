<template>
    <div class="service-summary">
        <span
            class="status-indicator"
            :class="service.status ? 'status-indicator-up' : 'status-indicator-down'"
        >
            <font-awesome-icon icon="circle" />
        </span>
        <span>{{ service.name }}</span>
    </div>
</template>

<script>
export default {
    props: {
        service: Object
    }
}
</script>
