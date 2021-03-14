<template>
    <div class="uptime-graph">
        <div
            v-for="check in checksSorted"
            :key="check.id"
            v-tooltip="{
                delay: 250,
                content: prettyDiff(check.created_at) + ' ago'
            }"
            :class="check.up ? 'uptime-graph-up' : 'uptime-graph-down'"
        />

    </div>
</template>

<script>
export default {
    props: {
        checks: Array,
    },
    data: function() {
        return {
            checksSorted: this.checks.reverse(),
        }
    }
}
</script>
