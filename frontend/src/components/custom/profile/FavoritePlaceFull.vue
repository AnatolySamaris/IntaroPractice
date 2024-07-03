<template>
  <article class="flex min-h-[600px] max-h-[600px] w-full gap-4 p-4">
    <div class="flex flex-col gap-4">
      <header class="flex justify-between">
        <h2>{{ cardHeaderText }}</h2>
      </header>
      <div
        class="rounded-xl self-center w-full min-h-[128px] max-h-[128px] bg-center bg-cover bg-[url(https://place-hold.it/256px)]"
      ></div>
      <div class="h-full max-h-full overflow-hidden">
        <ScrollArea class="max-h-full h-full overflow-hidden pr-2">
          {{ cardDescriptionText }}
        </ScrollArea>
      </div>
      <footer class="flex w-full justify-end items-end">
        <Button class="gap-2"><Heart /> {{ cardLikesAmount }}</Button>
      </footer>
    </div>
  </article>
</template>

<script setup>
import Button from '@/components/ui/button/Button.vue'
import ScrollArea from '@/components/ui/scroll-area/ScrollArea.vue'

import { ref } from 'vue'
import { Heart } from 'lucide-vue-next'

const cardHeaderText = ref('Московский кремль')
const cardDescriptionText = ref(
  'Внезапно, сторонники тоталитаризма в науке набирают популярность среди определенных слоев населения, а значит, должны быть подвергнуты целой серии независимых исследований. В целом, конечно, высокое качество позиционных исследований создаёт предпосылки для как самодостаточных, так и внешне зависимых концептуальных решений. Таким образом, экономическая повестка сегодняшнего дня выявляет срочную потребность прогресса профессионального сообщества. В рамках спецификации современных стандартов, многие известные личности, превозмогая сложившуюся непростую экономическую ситуацию, представлены в исключительно положительном свете. Предварительные выводы неутешительны: социально-экономическое развитие создаёт предпосылки для прогресса профессионального сообщества.'
)
const cardLikesAmount = ref(69)
</script>
