<template>
    <div class="card">
        <h1>Notification Settings</h1>

        <div class="flex flex-col space-y-2">
            <div
                v-for="setting in settings"
                :key="setting.id"
            >
                <label class="text-base" :for="setting.name">{{ setting.name }}</label>
                <input type="text" :name="setting.name" :id="setting.name" v-model="setting.value">
                <span v-if="setting.info" class="setting-info">{{ setting.info }}</span>
            </div>
        </div>
        <button class="button button-primary inline-block mt-2" @click="save">Save</button>
    </div>
</template>

<script>
export default {
    props: {
        settings: Object
    },
    methods: {
        save() {
            this.$inertia.post('/settings', { settings: this.settings }, { preservceScroll: true });
        }
    }
}
</script>
