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
                    <CheckModal :check="check" />
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import CheckModal from './CheckModal';

export default {
    components: {
        CheckModal
    },
    props: {
        checks: Object
    }
}
</script>
