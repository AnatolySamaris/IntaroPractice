<template>
  <div class="flex items-center justify-between h-screen w-screen">
    <!-- Блок с красивостями -->
    <div class="flex flex-col w-full justify-between h-full pl-12 dark:border-r lg:flex bg-image">
      <div
        @click="goToMain"
        class="flex items-center text-lg font-medium gap-2 w-fit pt-10 pb-2 px-8 bg-[rgba(255,255,255,0.65)] hover:cursor-pointer transition-colors hover:bg-[rgba(255,255,255,0.80)] rounded-bl-lg rounded-br-lg"
      >
        <Clapperboard />

        <p class="text-black text-2xl font-semibold">Cinema</p>
      </div>

      <div
        class="flex items-center gap-2 w-[680px] pb-10 pt-4 px-8 bg-[rgba(255,255,255,0.65)] rounded-tl-lg rounded-tr-lg"
      >
        <blockquote class="space-y-2">
          <p class="text-base text-black font-semibold">«Чем дальше в лес Скибиди Доп Ес Ес»</p>
          <footer class="text-sm text-black">— Сунь Цзы</footer>
        </blockquote>
      </div>
    </div>

    <!-- Блок с формой входа -->
    <div class="flex flex-col justify-center items-center gap-4 px-24 h-full bg-white shadow-2xl">
      <h2>Войдите</h2>
      <div class="border-t h-5 w-96 border-purple-600"></div>

      <div class="grid w-full max-w-sm items-center gap-1.5">
        <form class="w-96 space-y-6" @submit="onSubmit">
          <FormField v-slot="{ componentField: EmailField }" name="email">
            <FormItem>
              <FormLabel>Почта</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Введите вашу почту" v-bind="EmailField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField: PasswordField }" name="password">
            <FormItem>
              <FormLabel>Пароль</FormLabel>
              <FormControl>
                <Input type="password" placeholder="Введите ваш пароль" v-bind="PasswordField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <div class="flex flex-col">
            <Toaster />
            <div class="flex">
              <Button type="submit" class="bg-purple-500 w-32 text-white mr-5"> Войти </Button>
              <Button @click="goToRegister" class="w-64 bg-slate-400"> Зарегистрироваться </Button>
            </div>
          </div>
        </form>
      </div>
      <Button @click="goToMain" class="w-[50px] mt-2" variant="link">На главную</Button>
    </div>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import { Toaster } from '@/components/ui/toast'
import { useToast } from '@/components/ui/toast/use-toast'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import * as z from 'zod'
import { h } from 'vue'
import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage
} from '@/components/ui/form'
import { ref } from 'vue'
import axios from 'axios'
import { Clapperboard } from 'lucide-vue-next'

// Переход на страницу регистрации

const router = useRouter()

const goToRegister = () => {
  router.push('/registerPage')
}

// Валидация полей ввода

const formSchema = toTypedSchema(
  z.object({
    email: z
      .string({ required_error: 'Поле не должно быть пустым' })
      .email('Это не действительная почта'),
    password: z
      .string({ required_error: 'Поле не должно быть пустым' })
      .min(3, { message: 'Пароль должен содержать минимум 3 символа' })
      .max(20, { message: 'Пароль должен содержать не больше 20 символов' })
  })
)

const { handleSubmit, errors } = useForm({
  validationSchema: formSchema
})

const goToMain = () => {
  localStorage.clear()
  router.push('/')
}

const onSubmit = handleSubmit(async (formData) => {
  const apiFormData = new FormData()
  const userData = formData

  const hashedPassword = await hashPassword(userData.password)

  apiFormData.append('email', userData.email)
  apiFormData.append('password', hashedPassword)

  console.log(userData)

  try {
    const response = await axios.post('http://localhost/auth-user', apiFormData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    console.log(response.data)

    if (response.data.status == 'success') {
      localStorage.clear()
      localStorage.setItem('id_profile', response.data.id_profile)
      localStorage.setItem('role', response.data.role)
      localStorage.setItem('full_name', response.data.full_name)
      localStorage.setItem('photo_user', response.data.photo_user)
      localStorage.setItem('email', response.data.email)
      router.push('/')
    }

    // Высплывашка тостер

    const { toast } = useToast()

    if (response.data.status == 'error') {
      toast({
        description: 'Ошибка авторизации, введен не правильный логин или пароль',
        variant: 'destructive'
      })
    }
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
})

// ниже функция для хеширования пароля
async function hashPassword(password) {
  const encoder = new TextEncoder()
  const data = encoder.encode(password)
  const hashBuffer = await crypto.subtle.digest('SHA-256', data)
  const hashArray = Array.from(new Uint8Array(hashBuffer))
  const hashHex = hashArray.map((b) => b.toString(16).padStart(2, '0')).join('')
  return hashHex
}
</script>

<style scoped>
.bg-image {
  background-image: url('../img/kanobu.png');
  background-size: cover; /* Масштабировать изображение, чтобы оно покрывало весь элемент */
  background-position: center; /* Центрировать изображение */
  background-repeat: no-repeat; /* Не повторять изображение */
}
</style>
