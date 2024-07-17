<template>
  <div class="flex flex-col gap-8">
    <header
      class="flex items-center justify-between h-[100px] pb-6 sticky top-0 border-4 border-indigo-100 border-b-purple-500 bg-white border-bottom"
    >
      <div class="flex items-center gap-6 mt-4 ml-16">
        <div class="flex items-center gap-2">
          <div
            @click="goToMain"
            class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 transition-colors rounded-xl px-4 py-1"
          >
            <Clapperboard size="32px" />
            <p class="text-xl font-semibold">Cinema</p>
          </div>
        </div>
      </div>
      <div class="flex items-center gap-6 mt-4 mr-16">
        <Avatar v-if="(isvisible = true)">
          <AvatarImage :src="`http://localhost/view/images/${avatar}`" alt="@radix-vue" />
          <AvatarFallback>CN</AvatarFallback>
        </Avatar>
        <Button v-if="(isVisibleAdmin = true)" @click="addAnime" class="w-[120px]" variant="link">
          Добавить аниме
        </Button>
        <nav class="flex gap-8" v-if="isvisible">
          <Button @click="goToProfile" class="w-[10px]" variant="link">Профиль</Button>
          <Button @click="goToAuth" class="w-[10px]" variant="link">Выйти</Button>
        </nav>
        <Button v-else @click="goToAuth" class="w-[10px]" variant="link">Войти</Button>
      </div>
    </header>
    <main class="flex gap-8 px-16">
      <Card class="h-fit">
        <nav class="flex flex-col gap-1">
          <RouterLink to="/profilePage/favorites">
            <Button
              @click="
                () => {
                  changeMenuSelect(1)
                  visibleDefault = false
                }
              "
              :variant="btnVariant1"
              class="flex gap-2 justify-start w-[250px]"
              ><Heart /> Избранное</Button
            >
          </RouterLink>
          <RouterLink to="/profilePage/history">
            <Button
              @click="
                () => {
                  changeMenuSelect(2)
                  visibleDefault = false
                }
              "
              :variant="btnVariant2"
              class="flex gap-2 justify-start w-[250px]"
              ><History /> История</Button
            >
          </RouterLink>

          <RouterLink to="/profilePage/settings">
            <Button
              @click="
                () => {
                  changeMenuSelect(3)
                  visibleDefault = false
                }
              "
              :variant="btnVariant3"
              class="flex gap-2 justify-start w-[250px]"
              ><Settings /> Настройки</Button
            >
          </RouterLink>
        </nav>
      </Card>

      <router-view />
    </main>
  </div>
</template>

<script setup>
import { Button } from '@/components/ui/button'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Heart, History, Settings } from 'lucide-vue-next'
import { Card } from '@/components/ui/card'
import { ref } from 'vue'
import { Clapperboard } from 'lucide-vue-next'
import { useRoute, useRouter } from 'vue-router'

const router = useRouter()

let visibleDefault = ref(true)

const goToAuth = () => {
  router.push('/auth')
}

const addAnime = () => {
  router.push('/addAnime')
}

const goToMain = () => {
  router.push('/')
}

const avatar = ref('')

if (localStorage.length !== 0) {
  avatar.value = localStorage.photo_user
}

console.log(localStorage)

let btnVariant1 = 'ghost'
let btnVariant2 = 'ghost'
let btnVariant3 = 'ghost'

function changeMenuSelect(btnID) {
  btnVariant1 = 'ghost'
  btnVariant2 = 'ghost'
  btnVariant3 = 'ghost'

  if (btnID == 1) btnVariant1 = ''
  else if (btnID == 2) btnVariant2 = ''
  else if (btnID == 3) btnVariant3 = ''
}
</script>
