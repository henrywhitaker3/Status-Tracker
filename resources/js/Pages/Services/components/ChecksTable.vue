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
                <td>{{ check.type }}</td>
                <td>{{ check.up ? 'Yes' : 'No' }}</td>
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
