<template>
  <div class="flex flex-col gap-8 justify-center items-center w-full">
    <!-- Шапка сайта -->
    <div class="flex flex-col w-full">
      <Header :is-calculator-opened="true" />
      <!-- Поле полей ввода -->
      <div
        class="flex flex-col gap-6 justify-center items-center shadow-md rounded-br-[100px] rounded-bl-[100px] bg-white pb-8"
      >
        <h2>Куда летим?</h2>
        <div class="flex flex-col gap-8 w-full px-48">
          <!-- Первая строка параметров -->
          <div class="flex justify-between">
            <!-- Откуда/куда -->
            <div class="flex gap-4 items-end">
              <!-- Откуда -->
              <div class="flex flex-col gap-1">
                <p>Откуда</p>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                      <p>{{ cityNames[fromCityPosition] }}</p>
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent class="w-56">
                    <DropdownMenuLabel>Откуда</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup v-model="fromCityPosition">
                      <DropdownMenuRadioItem value="Bangalore"> Бангалор </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Chennai"> Ченнаи </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Delhi"> Дели </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Hyderabad"> Хайдарабад </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Kolkata"> Калькутта </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Mumbai"> Мумбаи </DropdownMenuRadioItem>
                    </DropdownMenuRadioGroup>
                  </DropdownMenuContent>
                </DropdownMenu>
              </div>
              <!-- Кнопка замены местами -->
              <Button @click="swapCities" variant="outline" size="icon" class="rounded-full"
                ><ArrowLeftRight size="16px"
              /></Button>
              <!-- Куда -->
              <div class="flex flex-col gap-1">
                <p>Куда</p>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                      <p>{{ cityNames[toCityPosition] }}</p>
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent class="w-56">
                    <DropdownMenuLabel>Куда</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup v-model="toCityPosition">
                      <DropdownMenuRadioItem value="Bangalore"> Бангалор </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Chennai"> Ченнаи </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Delhi"> Дели </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Hyderabad"> Хайдарабад </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Kolkata"> Калькутта </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Mumbai"> Мумбаи </DropdownMenuRadioItem>
                    </DropdownMenuRadioGroup>
                  </DropdownMenuContent>
                </DropdownMenu>
              </div>
            </div>

            <!-- Вылет/посадка -->
            <div class="flex gap-4 items-end">
              <!-- Вылет -->
              <div class="flex flex-col gap-1">
                <p>Вылетаем</p>

                <div class="flex gap-1 items-center">
                  <Popover>
                    <PopoverTrigger as-child>
                      <Button variant="outline">
                        <CalendarIcon class="mr-2 h-4 w-4" />
                        {{
                          valueTo ? df.format(valueTo.toDate(getLocalTimeZone())) : 'Выберите дату'
                        }}
                      </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0">
                      <Calendar v-model="valueTo" initial-focus />
                    </PopoverContent>
                  </Popover>
                  <Input
                    type="numbert"
                    v-model="hourTo"
                    class="w-14 text-center"
                    placeholder="ЧЧ"
                  />
                  <p>:</p>
                  <Input type="numbert" v-model="minTo" class="w-14 text-center" placeholder="ММ" />
                </div>
              </div>
              <!-- Посадка -->
              <div class="flex flex-col gap-1">
                <p>Прилетаем</p>
                <div class="flex gap-1 items-center">
                  <Popover>
                    <PopoverTrigger as-child>
                      <Button variant="outline">
                        <CalendarIcon class="mr-2 h-4 w-4" />
                        {{
                          valueBack
                            ? df.format(valueBack.toDate(getLocalTimeZone()))
                            : 'Выберите дату'
                        }}
                      </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0">
                      <Calendar v-model="valueBack" initial-focus />
                    </PopoverContent>
                  </Popover>
                  <Input
                    type="numbert"
                    v-model="hourBack"
                    class="w-14 text-center"
                    placeholder="ЧЧ"
                  />
                  <p>:</p>
                  <Input
                    type="numbert"
                    v-model="minBack"
                    class="w-14 text-center"
                    placeholder="ММ"
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Вторая строка параметров -->
          <div class="flex gap-8 items-end">
            <!-- Кол-во пассажиров, остановок, класс обслуж. и авиакомпания -->
            <div class="flex gap-4 items-end">
              <!-- Кол-во пассажиров -->
              <div class="flex flex-col gap-1">
                <p>Кол-во пассажиров</p>
                <div class="flex flex-wrap items-center justify-between h-[40px] w-[190px]">
                  <Button
                    @click="minusPeopleCount"
                    variant="outline"
                    size="icon"
                    class="rounded-full"
                    >–</Button
                  >
                  <p>{{ countPeople }} чел.</p>
                  <Button
                    @click="plusPeopleCount"
                    variant="outline"
                    size="icon"
                    class="rounded-full"
                    >+</Button
                  >
                </div>
              </div>
              <!-- Кол-во пересадок -->
              <div class="flex flex-col gap-1">
                <p>Кол-во остановок</p>
                <div class="flex flex-wrap items-center justify-between h-[40px] w-[190px]">
                  <Button
                    @click="minusStopsCount"
                    variant="outline"
                    size="icon"
                    class="rounded-full"
                    >–</Button
                  >
                  <p>{{ countStops }}</p>
                  <Button @click="plusStopsCount" variant="outline" size="icon" class="rounded-full"
                    >+</Button
                  >
                </div>
              </div>
              <!-- Класс -->
              <div class="flex flex-col gap-1">
                <p>Выберите класс</p>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                      <p>{{ classNames[classPlane] }}</p>
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent class="w-56">
                    <DropdownMenuLabel>Откуда</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup v-model="classPlane">
                      <DropdownMenuRadioItem value="Zero"> Эконом </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="One"> Бизнес </DropdownMenuRadioItem>
                    </DropdownMenuRadioGroup>
                  </DropdownMenuContent>
                </DropdownMenu>
              </div>
              <!-- Авиакомпания -->
              <div class="flex flex-col gap-1">
                <p>Авиакомпания</p>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                      <p>{{ airCompaniesNames[airCompanyPosition] }}</p>
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent class="w-56">
                    <DropdownMenuLabel>Авиакомпания</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup v-model="airCompanyPosition">
                      <DropdownMenuRadioItem value="AirIndia"> Air India </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Vistara"> Vistara </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Indigo"> Indigo </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="AirAsia"> AirAsia </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="GoFirst"> GO FIRST </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="SpiceJet"> SpiceJet </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="StarAir"> StarAir </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Trujet"> Trujet </DropdownMenuRadioItem>
                    </DropdownMenuRadioGroup>
                  </DropdownMenuContent>
                </DropdownMenu>
              </div>
            </div>
            <Button @click="searchTicket" class="flex gap-2 w-full"><Calculator />Расчитать</Button>
          </div>
        </div>
      </div>
    </div>
    <!-- Область просмотра -->
    <div class="flex flex-col w-full max-w-[800px] gap-8 pb-16">
      <!-- Карточка с вычисленной ценой -->
      <div class="flex justify-center items-center w-full">
        <div class="flex flex-col items-start gap-4 w-full">
          <h3>Результат подсчёта</h3>
          <Card class="flex items-center w-full gap-2">
            <div class="px-12 py-6 bg-green-300 rounded-tl-lg rounded-bl-lg">
              <p class="text-xl font-bold text-nowrap">{{ priceML }}</p>
            </div>
            <!-- Выравнивание столбцов -->
            <div class="flex items-center w-full px-4">
              <!-- Первый столбец -->
              <div class="flex flex-col gap-2 w-full items-center">
                <div class="flex gap-2 font-medium w-full">
                  <PlaneTakeoff />Из {{ cityNames[fromCityPosition] }}
                </div>
                <div class="flex gap-2 font-medium w-full">
                  <PlaneLanding />В {{ cityNames[toCityPosition] }}
                </div>
              </div>
              <!-- Второй столбец -->
              <div class="flex flex-col gap-2 w-full">
                <div class="flex gap-2 font-medium w-full">
                  <ArrowLeftRight />{{ airCompaniesNames[airCompanyPosition] }}
                </div>
                <div class="flex gap-2 font-medium w-full">
                  <BaggageClaim />{{ classNames[classPlane] }}
                </div>
              </div>
            </div>
          </Card>
        </div>
      </div>
      <!-- Популярные направления -->
      <div v-if="visiblePopular" class="flex justify-center items-center w-full">
        <div class="flex flex-col items-start gap-4">
          <div class="flex items-center gap-2">
            <h3>Популярные места в {{ cityNames[toCityPosition] }}</h3>
            <Button @click="popularPlace" variant="link" class="w-[50px] mt-2">Найти</Button>
          </div>

          <!-- Фильтры и сортировка -->
          <div class="flex flex-wrap gap-4">
            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button class="flex gap-2" variant="outline">
                  <Filter /> {{ filterRoute[filter] }}
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent class="w-56">
                <DropdownMenuLabel>Фильтрация</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuRadioGroup v-model="filter">
                  <DropdownMenuRadioItem value="S7"> S7 </DropdownMenuRadioItem>
                  <DropdownMenuRadioItem value="AeroFlot"> Аэрофлот </DropdownMenuRadioItem>
                </DropdownMenuRadioGroup>
              </DropdownMenuContent>
            </DropdownMenu>

            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button class="flex gap-2" variant="outline">
                  <ArrowDownUp /> {{ sortRoute[sort] }}
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent class="w-56">
                <DropdownMenuLabel>Сортировка</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuRadioGroup v-model="sort">
                  <DropdownMenuRadioItem value="cheap"> Сначала дешевые </DropdownMenuRadioItem>
                  <DropdownMenuRadioItem value="exp"> Сначала дорогие </DropdownMenuRadioItem>
                </DropdownMenuRadioGroup>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>

          <!-- Популярные места карточка-->
          <div v-for="place in places" :key="place.id_place" class="flex flex-col gap-4 w-full">
            <article class="flex max-h-[212px]">
              <Card class="flex gap-4 p-4">
                <div class="flex flex-col gap-2">
                  <CardHeader class="p-0">
                    <CardTitle>{{ place.name_place }}</CardTitle>
                  </CardHeader>
                  <CardContent class="p-0 max-h-full overflow-hidden">
                    {{ place.desc_place }}
                  </CardContent>
                  <CardFooter class="flex gap-4 p-0">
                    <Button @click="addFavorites(place.id_place)" class="gap-2"
                      ><Heart /> {{ place.favorites_count }}</Button
                    >
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
              </Card>
            </article>
          </div>
          <!-- </ScrollArea> -->
        </div>
      </div>
      <!-- Популярные направления -->
      <div v-if="visiblePopular" class="flex justify-center items-center w-full">
        <div class="flex flex-col items-start gap-4">
          <h3>Популярные направления</h3>
          <!-- TODO: ПОДУМАТЬ, НУЖНЫ ЛИ ФИЛЬТРЫ ИМЕННО ДЛЯ ПОПНАПРАВЛЕНИЙ ИЛИ ХВАТИТ ДЛЯ ПОПМЕСТ -->
          <!-- Фильтры и сортировка -->
          <!-- <div class="flex flex-wrap gap-4">
            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button class="flex gap-2" variant="outline">
                  <Filter /> {{ filterRoute[filter] }}
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent class="w-56">
                <DropdownMenuLabel>Фильтрация</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuRadioGroup v-model="filter">
                  <DropdownMenuRadioItem value="S7"> S7 </DropdownMenuRadioItem>
                  <DropdownMenuRadioItem value="AeroFlot"> Аэрофлот </DropdownMenuRadioItem>
                </DropdownMenuRadioGroup>
              </DropdownMenuContent>
            </DropdownMenu>

            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button class="flex gap-2" variant="outline">
                  <ArrowDownUp /> {{ sortRoute[sort] }}
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent class="w-56">
                <DropdownMenuLabel>Сортировка</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuRadioGroup v-model="sort">
                  <DropdownMenuRadioItem value="cheap"> Сначала дешевые </DropdownMenuRadioItem>
                  <DropdownMenuRadioItem value="exp"> Сначала дорогие </DropdownMenuRadioItem>
                </DropdownMenuRadioGroup>
              </DropdownMenuContent>
            </DropdownMenu>
          </div> -->
          <!-- TODO: подумать, действительно ли необходим скролл или можно всё в одну линию выстроить -->
          <!-- Просмотр популярных направлений -->
          <!-- <ScrollArea class="h-[800px] w-full rounded-md border p-4"> -->
          <div v-for="item in items" :key="item.id_place" class="flex flex-col gap-4 w-full">
            <PopularTour
              :tour-name="item.name_city"
              tour-description="И нет сомнений, что представители современных социальных резервов формируют глобальную экономическую сеть и при этом — функционально разнесены на независимые элементы. Предварительные выводы неутешительны: глубокий уровень погружения создаёт предпосылки для инновационных методов управления процессами.И нет сомнений, что представители современных социальных резервов формируют глобальную экономическую сеть и при этом — функционально разнесены на независимые элементы. Предварительные выводы неутешительны: глубокий уровень погружения создаёт предпосылки для инновационных методов управления процессами."
              :tour-image-u-r-l="`http://localhost:8080/img${item.photo_city}`"
            ></PopularTour>
          </div>
          <!-- </ScrollArea> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Header from '../components/custom/profile/header.vue'
import PopularTour from '@/components/custom/profile/PopularTour.vue'
import FavoritePlace from '@/components/custom/profile/FavoritePlace.vue'
import { ref, onMounted, watch } from 'vue'
import { DateFormatter, getLocalTimeZone } from '@internationalized/date'
import { Card } from '@/components/ui/card'
import { cn } from '@/lib/utils'
import { DateTimePicker } from 'vue-drumroll-datetime-picker'
import { Heart } from 'lucide-vue-next'

import {
  Calendar as CalendarIcon,
  ArrowLeftRight,
  Calculator,
  PlaneLanding,
  PlaneTakeoff,
  BaggageClaim,
  Plane
} from 'lucide-vue-next'
import { Calendar } from '@/components/ui/calendar'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuLabel,
  DropdownMenuRadioGroup,
  DropdownMenuRadioItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger
} from '@/components/ui/dropdown-menu'
import { ScrollArea } from '@/components/ui/scroll-area'
import { ArrowDownUp } from 'lucide-vue-next'
import { Filter } from 'lucide-vue-next'
import axios from 'axios'

const aboba = ref('1111')

const cityNames = {
  Default: 'Выберите город',
  Bangalore: 'Бангалор',
  Chennai: 'Ченнаи',
  Delhi: 'Дели',
  Hyderabad: 'Хайдарабад',
  Kolkata: 'Калькутта',
  Mumbai: 'Мумбаи'
}

const airCompaniesNames = {
  Default: 'Выберите компанию',
  AirIndia: 'Air India',
  Vistara: 'Vistara',
  Indigo: 'Indigo',
  AirAsia: 'AirAsia',
  GoFirst: 'GO FIRST',
  SpiceJet: 'SpiceJet',
  StarAir: 'StarAir',
  Trujet: 'Trujet'
}

const classNames = {
  Default: 'Выберите класс',
  Zero: 'Эконом',
  One: 'Бизнес'
}

const sortRoute = {
  Default: 'Сортировка',
  cheap: 'Сначала дешевые',
  exp: 'Сначала дорогие'
}

const filterRoute = {
  Default: 'Фильтры',
  S7: 'S7',
  AeroFlot: 'Аэрофлот'
}

const sort = ref('Default')
const filter = ref('Default')
const fromCityPosition = ref('Default')
const toCityPosition = ref('Default')
const airCompanyPosition = ref('Default')
const classPlane = ref('Default')

const countPeople = ref(1)
const countStops = ref(0)

const valueTo = ref()
const valueBack = ref()

const hourTo = ref()
const minTo = ref()

const hourBack = ref()
const minBack = ref()

// запрос на популярные данные из БД

const items = ref([])

// ниже на добавление в избранное

const addFavorites = async (id) => {
  console.log(id)
  console.log(localStorage.id_user)

  const formData = new FormData()

  formData.append('id_place', id)
  formData.append('id_user', localStorage.id_user)

  for (var pair of formData.entries()) {
    console.log(pair[0] + ': ' + pair[1])
  }

  try {
    const response = await axios.post('http://localhost:8080/add_favorites.php', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    console.log(response.data)

    alert('Популярное место добавлено в избранное')
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}

// здесь популярные места

const places = ref([])

const popularPlace = async () => {
  const formData = new FormData()

  formData.append('name_city', cityNames[toCityPosition.value])

  for (var pair of formData.entries()) {
    console.log(pair[0] + ': ' + pair[1])
  }

  try {
    const response = await axios.post('http://localhost:8080/places_sort.php', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    places.value = response.data

    console.log(response.data)
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}

const popularRoots = async () => {
  try {
    const response = await axios.get('http://localhost:8080/popular_root.php')
    items.value = response.data

    console.log(items.value)
  } catch (err) {
    console.error(err)
  }
}

onMounted(popularRoots)

// ниже логика отображение популярных

let visiblePopular = ref(true)

let priceML = ref()

const searchTicket = async () => {
  console.log('КЛИК')

  console.log(valueTo.value.year)
  console.log(valueTo.value.month)
  console.log(valueTo.value.day)

  const data = {
    position: fromCityPosition.value,
    positionTo: toCityPosition.value,
    classPlane: classPlane.value,
    airCompany: airCompanyPosition.value,
    countStops: countStops.value,
    depFrom: `${valueTo.value.year}-${valueTo.value.month}-${valueTo.value.day} ${hourTo.value}:${minTo.value}`,
    depTo: `${valueBack.value.year}-${valueBack.value.month}-${valueBack.value.day} ${hourBack.value}:${minBack.value}`
  }

  console.log(data)

  try {
    const response = await axios.post('http://127.0.0.1:5000/getTicket', data, {
      headers: {
        'Content-Type': 'application/json'
      }
    })

    console.log(response.data)

    priceML.value = Math.trunc(response.data.data.price) + ' ₽'
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }

  visiblePopular.value = false
}

const plusPeopleCount = () => {
  if (countPeople.value < 9) countPeople.value++
}

const minusPeopleCount = () => {
  if (countPeople.value > 1) countPeople.value--
}

const plusStopsCount = () => {
  if (countStops.value < 2) countStops.value++
}

const minusStopsCount = () => {
  if (countStops.value > 0) countStops.value--
}

// Меняем город отправления и прибытия местами
const swapCities = () => {
  let tempPos = fromCityPosition.value
  fromCityPosition.value = toCityPosition.value
  toCityPosition.value = tempPos
}

const df = new DateFormatter('ru', {
  dateStyle: 'long'
})
</script>
