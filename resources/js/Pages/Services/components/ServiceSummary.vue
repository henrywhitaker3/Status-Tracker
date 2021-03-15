<template>
    <inertia-link :href="'/services/' + service.id" nostyle>
        <div class="service-summary flex md:grid grid-cols-3 lg:grid-cols-4 items-center justify-between">
            <span
                class="status-indicator"
                :class="getStatusClass()"
            >
                <font-awesome-icon icon="circle" />
            </span>
            <span>{{ service.name }}</span>
            <span class="text-center">{{ getStatusMessage() }}</span>
            <UptimeGraph :checks="service.recent_checks" :inline="true" class="hidden lg:flex justify-end" />
        </div>
    </inertia-link>
</template>

<script>
import UptimeGraph from '../../../components/UptimeGraph';

export default {
    components: {
        UptimeGraph,
    },
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
        },
        getStatusMessage() {
            if(!this.service.enabled) {
                return 'Disabled';
            }

            if(this.service.status) {
                var msg = 'Up for ';
            } else {
                var msg = 'Down for'
            }

            return msg + ' ' + this.prettyDiff(this.service.status_changed_at);
        }
    }
}
</script>
