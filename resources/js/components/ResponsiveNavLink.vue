<template>
    <Link v-if="as === 'a'" :href="href" :class="classes">
        <slot />
    </Link>
    <button v-else :class="classes" @click="click">
        <slot />
    </button>
</template>

<script setup>
import { computed } from "vue";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
    as: {
        type: String,
        default: "a",
    },
    method: {
        type: String,
        default: "get",
    },
});

const classes = computed(() => {
    return props.active
        ? "block pl-3 pr-4 py-2 border-l-4 border-primary text-base font-medium text-primary bg-primary bg-opacity-25 focus:outline-none focus:text-primary focus:bg-primary focus:border-primary transition duration-150 ease-in-out"
        : "block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out";
});

const click = () => {
    if (props.method === "delete") {
        router.delete(props.href);
    } else if (props.method === "post") {
        router.post(props.href);
    } else if (props.method === "put") {
        router.put(props.href);
    } else if (props.method === "patch") {
        router.patch(props.href);
    }
};
</script>
