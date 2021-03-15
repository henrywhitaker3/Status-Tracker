<template>
    <div>
        <nav>
            <div class="nav-left">
                <inertia-link href="/">{{ $page.props.config.app.name }}</inertia-link>
            </div>

            <div class="nav-right">
                <inertia-link href="/">Home</inertia-link>
            </div>
        </nav>

        <div class="w-11/12 md:w-5/6 lg:w-2/3 mx-auto py-6">
            <slot />
        </div>
    </div>
</template>
