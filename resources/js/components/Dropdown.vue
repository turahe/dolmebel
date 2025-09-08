<template>
    <div class="relative">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div
            v-show="open"
            class="fixed inset-0 z-40"
            @click="open = false"
        ></div>

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="absolute z-50 mt-2 rounded-md shadow-lg"
                :class="[widthClass, positioningClasses]"
                style="display: none"
                @click="open = false"
            >
                <div
                    class="ring-opacity-5 rounded-md ring-1 ring-black"
                    :class="contentClasses"
                >
                    <slot name="content" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
    align: {
        type: String,
        default: "right",
    },
    width: {
        type: String,
        default: "48",
    },
    contentClasses: {
        type: Array,
        default: () => ["py-1", "bg-white", "dark:bg-gray-700"],
    },
});

const open = ref(false);

const widthClass = computed(() => {
    return {
        48: "w-48",
        60: "w-60",
        80: "w-80",
    }[props.width.toString()];
});

const positioningClasses = computed(() => {
    if (props.align === "left") {
        return "origin-top-left left-0";
    }

    if (props.align === "right") {
        return "origin-top-right right-0";
    }

    return "origin-top";
});
</script>
