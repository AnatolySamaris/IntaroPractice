<template>
  <div class="flex flex-col h-screen justify-between">
    <header
      class="flex items-center justify-between w-full pb-6 fixed top-0 border-4 border-indigo-100 border-b-purple-500 bg-white border-bottom"
    >
      <div class="flex items-center gap-6 mt-4 ml-16">
        <div class="flex items-center gap-2">
          <div
            class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 transition-colors rounded-xl px-4 py-1"
          >
            <Clapperboard size="32px" />
            <p class="text-xl font-semibold">Cinema</p>
          </div>

          <div class="relative w-full max-w-sm items-center ml-4">
            <Input
              v-model="query"
              id="search"
              type="text"
              placeholder="Введите название аниме"
              class="pl-10 bg-purple-100"
            />
            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
              <Search class="size-5 text-muted-foreground" />
            </span>
          </div>
        </div>
      </div>
      <div class="flex items-center gap-6 mt-4 mr-16">
        <Avatar v-if="isvisible">
          <AvatarImage :src="`http://localhost/view/images/${avatar}`" alt="@radix-vue" />
          <AvatarFallback>CN</AvatarFallback>
        </Avatar>
        <Button v-if="isVisibleAdmin" @click="getRating" class="w-[80px]" variant="link">
          Топ рейтинг
        </Button>
        <Button v-if="isVisibleAdmin" @click="addAnime" class="w-[120px]" variant="link">
          Добавить аниме
        </Button>

        <nav class="flex gap-8" v-if="isvisible">
          <Button @click="goToProfile" class="w-[10px]" variant="link">Профиль</Button>
          <Button @click="goToAuth" class="w-[10px]" variant="link">Выйти</Button>
        </nav>
        <Button v-else @click="goToAuth" class="w-[10px]" variant="link">Войти</Button>
      </div>
    </header>
    <main class="flex flex-col items-center justify-center pt-36 bg-white">
      <headerMain class="grid md:grid-cols-2 xl:grid-cols-3 mb-12 gap-32">
        <card
          v-for="item in queryItems"
          :key="item"
          class="h-[480px] w-[290px] bg-indigo-100 flex flex-col justify-between border-4 border-black"
        >
          <headerCard class="flex flex-col items-center mt-4 gap-4">
            <p class="font-bold">{{ item.title_anime }}</p>
            <img
              class="h-[220px] w-[170px]"
              :src="`http://localhost/view/images/${item.anime_img}`"
            />
          </headerCard>
          <mainCard class="flex flex-col items-start ml-4 gap-1 w-full overflow-hidden">
            <div class="font-semibold">
              Название:
              <span class="font-normal text-violet-700">{{ item.title_anime }}</span>
            </div>
            <div class="font-semibold">
              Директор: <span class="font-normal text-violet-700">{{ item.director }}</span>
            </div>
            <div class="font-semibold">
              Студия: <span class="font-normal text-violet-700">{{ item.studio_manufacture }}</span>
            </div>
            <div class="font-semibold">
              Жанр: <span class="font-normal text-violet-700">{{ item.name_genre }}</span>
            </div>
          </mainCard>

          <footerCard class="flex items-center justify-between">
            <router-link :to="{ path: `/animeCard/${item.title_anime}` }"> </router-link>
            <div class="flex">
              <Button class="text-pink-500 w-[50px]" variant="link">Открыть</Button>
              <Button
                v-if="isvisible"
                @click="addView(item.title_anime, item.year_release)"
                class="text-green-500 w-[120px]"
                variant="link"
                >Посмотреть</Button
              >
            </div>
            <Toaster />
            <div v-if="isVisibleAdmin" class="flex flex-wrap items-center gap-4 mr-4">
              <router-link :to="{ path: `/editAnime/${item.title_anime}` }">
                <Cog
                  class="cursor-pointer active:bg-orange-600 transition-colors rounded-full"
                  size="28px"
                  color="#ffae00"
                />
              </router-link>

              <CircleX
                @click="deleteAnime(item.title_anime)"
                class="cursor-pointer active:bg-red-600 transition-colors rounded-full"
                size="28px"
                color="#ff0000"
              />
            </div>
          </footerCard>
        </card>
      </headerMain>
      <div class="flex items-center h-screen gap-5 flex-col" v-if="isSearch > 0">
        <img src="../img/default.svg" class="h-[300px] w-[300px]" />
        <p class="text-2xl cursor-default font-semibold">Ничего не найдено</p>
        <p @click="clearSearch" class="text-x text-indigo-700 rounded-md cursor-pointer">
          Очистите поиск и попробуйте снова
        </p>
      </div>
    </main>

    <footer class="border-4 border-indigo-100 border-t-purple-500">
      <p class="text-x font-semibold ml-4">@ Дод И Ко</p>
    </footer>
  </div>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'
import { Input } from '@/components/ui/input'
import { Search } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Toaster } from '@/components/ui/toast'
import { useToast } from '@/components/ui/toast/use-toast'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Clapperboard } from 'lucide-vue-next'
import {
  Pagination,
  PaginationEllipsis,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev
} from '@/components/ui/pagination'
import { CircleX } from 'lucide-vue-next'
import { Cog } from 'lucide-vue-next'
import jsPDF from 'jspdf'
import pdfMake from 'pdfmake/build/pdfmake'
import pdfFonts from 'pdfmake/build/vfs_fonts'

const { toast } = useToast()

const router = useRouter()

const goToProfile = () => {
  router.push('/profilePage')
}

const addAnime = () => {
  router.push('/addAnime')
}

const goToAuth = () => {
  router.push('/auth')
}

// добавляем в просмотренные

const addView = async (title, year) => {
  const formData = new FormData()
  formData.append('title', title)
  formData.append('year', year)
  formData.append('email', localStorage.email)
  formData.append('history', title)

  try {
    const response = await axios.post('http://localhost/addView', formData)

    console.log(response.data)

    if (response.data.status == 'success') {
      toast({
        description: 'Аниме добавлено в просмотренные'
      })
    } else {
      alert('Ошибка добавления')
    }
  } catch (error) {
    console.error('Ошибка при скачивании файла:', error)
  }
}

// удаляем аниме

const deleteAnime = async (title) => {
  const formData = new FormData()
  formData.append('title', title)

  try {
    const response = await axios.post('http://localhost/deleteAnime', formData)

    console.log(response.data)
    getProfileUser()
  } catch (error) {
    console.error('Ошибка при скачивании файла:', error)
  }
}

// скачиваем книгу

const downloadBook = async (id) => {
  const formData = new FormData()
  formData.append('id', id)

  console.log(id)
  try {
    const response = await axios.post('http://localhost/downloadBook', formData, {
      responseType: 'Blob'
    })

    console.log(response.data)

    console.log(response.headers)

    const url = window.URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', 'file.txt') // Получаем имя файла из заголовка
    document.body.appendChild(link)
    link.click()
    link.remove()
  } catch (error) {
    console.error('Ошибка при скачивании файла:', error)
  }
}

// поиск

const query = ref('')

const queryItems = computed(() => {
  let search = query.value.toLowerCase()
  let filteredItems = items.value.filter((elem) => {
    return (
      elem.title_anime.toLowerCase().includes(search) ||
      elem.studio_manufacture.toLowerCase().includes(search)
    )
  })

  return filteredItems
})

let isSearch = computed(() => {
  return queryItems.value.length === 0
})

// очистка поля

const clearSearch = () => {
  query.value = ''
}

const items = ref([])

const avatar = ref('')

const getProfileUser = async () => {
  try {
    const response = await axios.get('http://localhost:8080/retailcrm/user/test@email.for/profile')
    items.value = response.data

    console.log(items.value)
  } catch (err) {
    console.error(err)
  }
}

onMounted(getProfileUser)

const jsonData = ref([])

function generatePDF() {}

// скачиваем топ рейтинг аниме
const getRating = async () => {
  try {
    const response = await axios.get('http://localhost/getTopRating')
    const animeData = response.data

    console.log(animeData)

    const documentDefinition = {
      content: []
    }

    animeData.forEach((elem) => {
      documentDefinition.content.push({
        text: `${elem.title_anime}, Рейтинг: ${Math.floor(elem.average_rating)}`,
        fontSize: 12,
        margin: [0, 0, 0, 10] // отступы сверху, справа, снизу, слева
      })
    })

    pdfMake.vfs = pdfFonts.pdfMake.vfs // Регистрируем шрифты

    pdfMake.createPdf(documentDefinition).download('newFile.pdf')
  } catch (err) {
    console.error(err)
  }
}

console.log(localStorage)

const isvisible = ref(true)

const isVisibleAdmin = ref(false)

if (localStorage.role == 'admin') {
  isVisibleAdmin.value = true
} else {
  isVisibleAdmin.value = false
}

if (localStorage.length !== 0) {
  isvisible.value = true

  avatar.value = localStorage.photo_user
} else {
  isvisible.value = false
}
</script>

<style scoped>
mainCard {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-left: 1rem;
  gap: 0.25rem;
  width: 100%; /* Или установите другую ширину по вашему усмотрению */
  word-break: break-word; /* Это позволяет тексту переноситься на новую строку */
}
</style>
