<template>
    <div class="mt-6 -mb-1 flex flex-wrap justify-center">
        <template v-for="(link, key) in links">
            <div v-if="link.url === null" :key="key" class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-gray-400" :class="{ 'ml-auto': link.label === 'Next' }" v-html="link.label"></div>
            <inertia-link
                nostyle
                v-else
                :key="key"
                class="mr-1 mb-1 px-4 py-3 text-sm border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                :class="{ 'bg-gray-200 border-gray-400': link.active, 'ml-auto': link.label === 'Next' }"
                :href="link.url"
                v-html="link.label"
                :preserve-scroll="preserveScroll"
            />
        </template>
    </div>
</template>

<script>
export default {
    props: {
        links: Array,
        preserveScroll: {
            type: Boolean,
            default: true,
        },
    },
}
</script>
