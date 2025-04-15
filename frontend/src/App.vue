<script setup>
import { ref } from 'vue';
import { Button } from './components/btns'
import { IconPlus, IconMinus } from './components/icons'

const number = ref(50)
const randowHexColor = ref([
  Math.floor(Math.random() * 16777215).toString(16),
  Math.floor(Math.random() * 16777215).toString(16),
  Math.floor(Math.random() * 16777215).toString(16),
  Math.floor(Math.random() * 16777215).toString(16),
])

const handleIncrease = () => {
  number.value++;
  generateRandomHexColor();
}

const generateRandomHexColor = () => {  
  randowHexColor.value.shift();
  randowHexColor.value.push(Math.floor(Math.random() * 16777215).toString(16));
}

const decrease = () => {
  if (number.value > 20){
    number.value--
    generateRandomHexColor();
  }
}
</script>

<template>
  <div class="flex justify-center items-center h-[100vh] w-full">
    <div class="flex flex-col items-center space-y-4">
      <span
        class="text-center font-bold p-4 rounded gradient-text"
        :style="{
          fontSize: number + 'px',
          backgroundImage: `linear-gradient(to right, #${randowHexColor[0]}, #${randowHexColor[1]}, #${randowHexColor[2]}, #${randowHexColor[3]})`
        }"
      >
        {{ number }}
      </span>
      <div class="flex space-x-2">
        <Button :increase="handleIncrease">
          <IconPlus />
          <span>Increase</span>
        </Button>
        <Button :increase="decrease" :class="`bg-red-500 hover:bg-red-700`">
          <IconMinus />
          <span>Decrease</span>
        </Button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.gradient-text {
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-fill-color: transparent;
}
</style>
