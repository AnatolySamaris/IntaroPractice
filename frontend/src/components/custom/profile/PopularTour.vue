<template>
  <article class="w-full">
    <Card class="flex flex-col min-h-[392px] max-h-[392px] gap-4 p-4 w-full">
      <CardHeader class="p-0 w-full gap-4">
        <!-- <div
          class="rounded-xl self-center w-full min-h-[128px] max-h-[128px] bg-center"
          :class="calcImageURL"
        ></div> -->
        <img
          class="rounded-xl self-center w-[400px] min-h-[128px] max-h-[128px]"
          :src="tourImageURL"
          alt=""
        />
        <CardTitle>{{ tourName }}</CardTitle>
      </CardHeader>
      <CardContent class="p-0 max-h-full overflow-hidden">
        {{ tourDescription }}
      </CardContent>
      <CardFooter class="p-0 flex gap-4 justify-end">
        <Dialog>
          <DialogTrigger as-child>
            <Button variant="ghost">Подробнее</Button>
          </DialogTrigger>
          <DialogContent class="sm:max-w-[600px]">
            <PopularTourFull
              :tour-name="tourName"
              :tour-description="tourDescription"
              :tour-image-u-r-l="tourImageURL"
            ></PopularTourFull>
          </DialogContent>
        </Dialog>
        <Button @click="$emit('fluTo')">Лететь сюда</Button>
      </CardFooter>
    </Card>
  </article>
</template>

<script setup>
import PopularTourFull from './PopularTourFull.vue'

import Button from '@/components/ui/button/Button.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Dialog, DialogContent, DialogTrigger } from '@/components/ui/dialog'
import CardFooter from '@/components/ui/card/CardFooter.vue'
import { ref, computed } from 'vue'

const props = defineProps(['tourName', 'tourDescription', 'tourImageURL'])
const emits = defineEmits(['flyTo'])

const calcImageURL = computed(() => {
  console.log('bg-[url(' + tourImageURL.value + ')]')
  return 'bg-[url(' + tourImageURL.value + ')]'
})

const tourName = ref(props.tourName)
const tourDescription = ref(props.tourDescription)
const tourImageURL = ref(props.tourImageURL)
</script>
