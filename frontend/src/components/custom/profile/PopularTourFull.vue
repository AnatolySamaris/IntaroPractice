<template>
  <article class="flex flex-col min-h-[600px] max-h-[600px] gap-2 p-4 w-full">
    <header class="flex flex-col w-full gap-4">
      <!-- <div
        class="rounded-xl self-center w-full min-h-[128px] max-h-[128px] bg-cover bg-center"
        :class="calcImageURL"
      ></div> -->
      <img
        class="rounded-xl self-center w-full min-h-[128px] max-h-[128px] bg-center"
        :src="tourImageURL"
        alt=""
      />
      <h3>{{ tourName }}</h3>
    </header>
    <div class="overflow-hidden h-full">
      <ScrollArea class="max-h-full h-full overflow-hidden pr-2">
        {{ tourDescription }}
      </ScrollArea>
    </div>
    <footer class="p-0 flex gap-4 items-end justify-end">
      <Button @click="$emit('flyTo')">Лететь сюда</Button>
    </footer>
  </article>
</template>

<script setup>
import Button from '@/components/ui/button/Button.vue'
import ScrollArea from '@/components/ui/scroll-area/ScrollArea.vue'
import { ref, computed } from 'vue'

const props = defineProps(['tourName', 'tourDescription', 'tourImageURL'])
const emits = defineEmits(['flyTo'])

const calcImageURL = computed(() => {
  return 'bg-[url(' + tourImageURL.value + ')]'
})

const tourName = ref(props.tourName)
const tourDescription = ref(props.tourDescription)
const tourImageURL = ref(props.tourImageURL)
</script>
