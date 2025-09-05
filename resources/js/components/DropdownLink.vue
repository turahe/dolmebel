<template>
    <Link
        v-if="as === 'a'"
        :href="href"
        :class="classes"
    >
        <slot />
    </Link>
    <button
        v-else
        :class="classes"
        @click="click"
    >
        <slot />
    </button>
</template>

<script setup>
import { computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    as: {
        type: String,
        default: 'a',
    },
    href: {
        type: String,
    },
    method: {
        type: String,
        default: 'get',
    },
})

const classes = computed(() => {
    return 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'
})

const click = () => {
    if (props.method === 'delete') {
        router.delete(props.href)
    } else if (props.method === 'post') {
        router.post(props.href)
    } else if (props.method === 'put') {
        router.put(props.href)
    } else if (props.method === 'patch') {
        router.patch(props.href)
    }
}
</script>
