<template>
    <div>
        <button @click="showModal()" class="focus:border-0 focus:outline-none text-gray-600">
            <font-awesome-icon icon="ellipsis-v" />
        </button>

        <modal :name="'check-modal-' + check.id">
            <h1>{{ check.id }}</h1>
        </modal>
    </div>
</template>

<script>
export default {
    props: {
        check: Object
    },
    methods: {
        showModal() {
            this.$modal.show('check-modal-' + this.check.id);
        },
        hideModal() {
            //
        }
    }
}
</script>
