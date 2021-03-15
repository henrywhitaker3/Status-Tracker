<template>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Up</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="check in checks"
                :key="check.id"
            >
                <td>{{ check.type }}</td>
                <td>{{ check.up ? 'Yes' : 'No' }}</td>
                <td>{{ prettyDiff(check.created_at) }} ago</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        checks: Array
    }
}
</script>
