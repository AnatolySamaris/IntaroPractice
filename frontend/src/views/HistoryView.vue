<template>
  <section class="flex flex-col gap-6 w-full pb-16">
    <div class="flex flex-col gap-2">
      <h3 class="font-bold">Просмотренные аниме</h3>
    </div>
    <div class="flex flex-col">
      <Table class="w-full">
        <TableHeader>
          <TableRow>
            <TableHead class="font-bold">Название аниме</TableHead>
            <TableHead class="font-bold">Год релиза</TableHead>
            <TableHead class="font-bold">Дата просмотра</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody v-for="item in historyData" :key="item">
          <TableRow>
            <TableCell>{{ item.title_anime }}</TableCell>
            <TableCell>{{ item.year_release }}</TableCell>
            <TableCell>{{ item.date_view }}</TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </section>
</template>

<script setup>
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow
} from '@/components/ui/table'

import { onMounted, ref, computed } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'

const historyData = ref([])

console.log(localStorage)

const animeFetch = async () => {
  const formData = new FormData()
  formData.append('email', localStorage.email)

  try {
    const response = await axios.post('http://localhost/getView', formData)

    historyData.value = response.data
    console.log(response.data)
  } catch (error) {
    console.error('Ошибка при скачивании файла:', error)
  }
}

onMounted(animeFetch)
</script>
