<template>
  <article class="flex max-h-[212px]">
    <Card class="flex gap-4 p-4">
      <div class="flex flex-col gap-2">
        <CardHeader class="p-0">
          <CardTitle>{{ cardHeaderText }}</CardTitle>
        </CardHeader>
        <CardContent class="p-0 max-h-full overflow-hidden">
          {{ cardDescriptionText }}
        </CardContent>
        <CardFooter class="flex gap-4 p-0">
          <Button class="gap-2"><Heart /> {{ cardLikesAmount }}</Button>
          <Dialog>
            <DialogTrigger as-child>
              <Button variant="ghost">Подробнее</Button>
            </DialogTrigger>
            <DialogContent class="sm:max-w-[600px]">
              <FavoritePlaceFull></FavoritePlaceFull>
            </DialogContent>
          </Dialog>
        </CardFooter>
      </div>
      <div
        class="rounded-xl self-center min-w-[162px] max-w-[162px] min-h-[162px] max-h-[162px] bg-center bg-[url(https://place-hold.it/256px)]"
      ></div>
    </Card>
  </article>
</template>

<script setup>
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import { Dialog, DialogContent, DialogTrigger } from '@/components/ui/dialog'
import Button from '@/components/ui/button/Button.vue'
import axios from 'axios'

import { ref, onMounted } from 'vue'
import { Heart } from 'lucide-vue-next'

const cardHeaderText = ref('Московский кремль')
const cardDescriptionText = ref(
  'Внезапно, сторонники тоталитаризма в науке набирают популярность среди определенных слоев населения, а значит, должны быть подвергнуты целой серии независимых исследований. В целом, конечно, высокое качество позиционных исследований создаёт предпосылки для как самодостаточных, так и внешне зависимых концептуальных решений. Таким образом, экономическая повестка сегодняшнего дня выявляет срочную потребность прогресса профессионального сообщества. В рамках спецификации современных стандартов, многие известные личности, превозмогая сложившуюся непростую экономическую ситуацию, представлены в исключительно положительном свете. Предварительные выводы неутешительны: социально-экономическое развитие создаёт предпосылки для прогресса профессионального сообщества.'
)
</script>
