<script setup>
const props = defineProps({
  class: String,
  increase: Function
})

const handleIncrease = () => {
  props.increase?.()
}
</script>

<template>
  <button
    @click="handleIncrease"
    :class="`flex items-center justify-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ${ props.class ?? ''}`"
  >
    <slot />
  </button>
</template>
