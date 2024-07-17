<template>
  <section class="flex flex-col gap-6 pb-16">
    <h3 class="font-bold">Избранное аниме</h3>
    <div v-for="item in items" :key="item.id_place" class="flex flex-col gap-4">
      <div class="flex gap-4">
        <article class="flex max-h-[196px]">
          <Card class="flex gap-4 p-4">
            <div class="flex flex-col gap-2">
              <CardHeader class="p-0">
                <CardTitle>{{ item.name_place }}</CardTitle>
              </CardHeader>
              <CardContent class="p-0 max-h-full overflow-hidden">
                {{ item.desc_place }}
              </CardContent>
              <CardFooter class="p-0">
                <Button @click="deleteFavorites(item.id_place)" class="gap-2"
                  ><Heart /> {{ item.favorites_count }}</Button
                >
              </CardFooter>
            </div>
            <img
              class="h-[70px] w-[80px] mr-4"
              :src="`http://localhost:8080/img${item.photo_place}`"
            />
          </Card>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import Button from '@/components/ui/button/Button.vue'
import axios from 'axios'

import { ref, onMounted } from 'vue'
import { Heart } from 'lucide-vue-next'

const placesAmount = ref() // Сколько всего избранных мест

console.log('ABOBA')

// удаление из избранного

const deleteFavorites = async (id) => {
  console.log(id)
  console.log(localStorage.id_user)

  const formData = new FormData()

  formData.append('id_place', id)
  formData.append('id_user', localStorage.id_user)

  for (const [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`)
  }

  try {
    const response = await axios.post('http://localhost:8080/delete_favorites.php', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    console.log(response.data)
    getFavorites()
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}

const items = ref([])

const getFavorites = async () => {
  const formData = new FormData()
  formData.append('id_user', localStorage.id_user)

  console.log(localStorage.id_user)
  try {
    const response = await axios.post('http://localhost:8080/get_user_favorites.php', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    placesAmount.value = response.data.total_count

    items.value = response.data.data

    console.log(response.data.data)
  } catch (error) {
    console.error('Ошибка:', error)
  }
}

onMounted(getFavorites)
</script>
