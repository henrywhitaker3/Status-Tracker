<template>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Up</th>
                <th>Time</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="check in checks.data"
                :key="check.id"
            >
                <td><span class="solo-type">{{ check.type }}</span></td>
                <td class="text-2xl">
                    <font-awesome-icon v-if="check.up" class="text-green-400 " icon="check-circle" />
                    <font-awesome-icon v-else class="text-red-500 " icon="times-circle" />
                </td>
                <td>{{ prettyDiff(check.created_at) }} ago</td>
                <td class="text-right w-px">
                    <inertia-link :href="'/checks/' + check.id"><font-awesome-icon icon="ellipsis-v" /></inertia-link>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        checks: Object
    }
}
</script>
