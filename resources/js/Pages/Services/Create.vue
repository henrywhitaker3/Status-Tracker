<template>
<div>
    <Layout>
        <div class="w-full md:w-1/2 mx-auto">
            <div class="card block">
                <h1 class="mb-3">New service</h1>
                <form
                    @submit.prevent="store"
                    class="flex flex-col space-y-3"
                >
                    <div>
                        <label for="name">Name:</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            v-model="service.name"
                            placeholder="Enter a name for your service"
                        >
                        <span class="form-error" v-if="errors.name">{{ errors.name }}</span>
                    </div>

                    <div>
                        <label for="name">Access URL:</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            v-model="service.access_url"
                            placeholder="Enter the access URL"
                        >
                        <span class="form-error" v-if="errors.access_url">{{ errors.access_url }}</span>
                    </div>

                    <div>
                        <label for="name">Check URL:</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            v-model="service.check_url"
                            placeholder="Enter the URL to check"
                        >
                        <span class="form-error" v-if="errors.check_url">{{ errors.check_url }}</span>
                    </div>

                    <div>
                        <label for="name">Check Type:</label>
                        <select
                            id="type"
                            name="type"
                            v-model="service.type"
                        >
                            <option
                                v-for="type in types"
                                :key="type"
                                :value="type"
                            >
                                {{ type }}
                            </option>
                        </select>
                        <span class="form-error" v-if="errors.type">{{ errors.type }}</span>
                    </div>

                    <div>
                        <label for="name">
                            <input
                                type="checkbox"
                                id="enabled"
                                name="enabled"
                                v-model="service.enabled"
                            >
                            <span>Enabled</span>
                        </label>
                        <span class="form-error" v-if="errors.enabled">{{ errors.enabled }}</span>
                    </div>

                    <input type="submit" class="button button-primary" name="Save" />
                </form>
            </div>
        </div>
    </Layout>
</div>
</template>

<script>
import Layout from '../../components/Layout';

export default {
    metaInfo: { title: 'New Service ' },
    components: {
        Layout,
    },
    props: {
        errors: Object,
        types: Object,
    },
    data: function() {
        return {
            service: {
                name: '',
                access_url: '',
                check_url: '',
                enabled: true,
                type: null,
            }
        }
    },
    methods: {
        store() {
            this.$inertia.put('/services', this.service);
        },
    }
}
</script>
