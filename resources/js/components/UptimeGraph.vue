<template>
    <div class="uptime-graph" :class="inline ? 'inline-block' : 'block'">
        <div
            v-for="check in getChecksData()"
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
        reverse: {
            type: Boolean,
            default: true,
        },
        inline: {
            type: Boolean,
            default: false,
        }
    },
    methods: {
        getChecksData() {
            if(this.reverse) {
                let checks = JSON.parse(JSON.stringify(this.checks));

                return checks.reverse();
            }

            return this.checks;
        }
    }
}
</script>
