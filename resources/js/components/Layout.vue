<template>
    <div>
        <nav>
            <div class="nav-left">
                <inertia-link href="/">{{ $page.props.config.app.name }}</inertia-link>
            </div>

            <div class="nav-right md:hidden">
                <font-awesome-icon @click="toggleSidenav" class="cursor-pointer" icon="bars" />
            </div>

            <div
                v-if="showSidenav"
                class="overlay md:hidden"
                @click="toggleSidenav"
                @click.stop=""
            />
            <div
                v-if="showSidenav"
                class="sidenav md:hidden"
            >
                <inertia-link
                    v-for="(link, i) in links"
                    :key="i"
                    :href="link.url"
                >
                    {{ link.name }}
                </inertia-link>
            </div>

            <div class="nav-right hidden md:block">
                <inertia-link
                    v-for="(link, i) in links"
                    :key="i"
                    :href="link.url"
                >
                    {{ link.name }}
                </inertia-link>
            </div>
        </nav>

        <div class="w-11/12 md:w-5/6 lg:w-2/3 mx-auto py-6">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showSidenav: false,
            links: [
                {
                    name: "Home",
                    url: '/'
                },
                {
                    name: "Settings",
                    url: '/settings'
                },
            ],
        }
    },
    methods: {
        toggleSidenav() {
            this.showSidenav = !this.showSidenav;
        },
        showToastMessages() {
            var flash = this.$page.props.flash;
            console.log(flash);


        },
    },
    watch: {
        '$page.props.flash': function(flash, old) {
            if(flash.info) {
                this.$toast.info(flash.info);
            }

            if(flash.success) {
                this.$toast.success(flash.success);
            }

            if(flash.warning) {
                this.$toast.warning(flash.warning);
            }

            if(flash.error) {
                this.$toast.error(flash.error);
            }
        }
    }
}
</script>
