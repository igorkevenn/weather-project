<template>
  <AppLayout>
    <WeatherSearchBar v-model="cityQuery" :loading="loading" @search="loadCity" />

    <p v-if="errorMessage" class="page__error">{{ errorMessage }}</p>

    <WeatherCurrent :weather="current" />
    <WeatherForecast :items="forecastItems" />
    <WeatherAirPollution :pollution="pollution" />
    <WeatherHistory :items="history" @select="loadCity" @remove="removeHistory" />
  </AppLayout>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import WeatherSearchBar from '@/components/Views/Weather/WeatherSearchBar.vue'
import WeatherCurrent from '@/components/Views/Weather/WeatherCurrent.vue'
import WeatherForecast from '@/components/Views/Weather/WeatherForecast.vue'
import WeatherAirPollution from '@/components/Views/Weather/WeatherAirPollution.vue'
import WeatherHistory from '@/components/Views/Weather/WeatherHistory.vue'
import useWeather from '@/composables/Api/Weather/useWeather'
import useHistory from '@/composables/Api/History/useHistory'
import type {
  AirPollution,
  ForecastItem,
  HistoryItem,
  Weather,
} from '@/types/Api/weather.type'

const cityQuery = ref('São Paulo')
const current = ref<Weather | null>(null)
const forecastItems = ref<ForecastItem[]>([])
const pollution = ref<AirPollution | null>(null)
const history = ref<HistoryItem[]>([])
const errorMessage = ref<string | null>(null)

const weatherApi = useWeather()
const historyApi = useHistory()

const loading = computed(() => weatherApi.loading.value || historyApi.loading.value)

async function loadHistory() {
  const data = await historyApi.list(5)
  history.value = data?.registers ?? []
}

async function loadCity(city: string) {
  if (!city) return

  cityQuery.value = city
  errorMessage.value = null

  const [weatherData, forecastData, pollutionData] = await Promise.all([
    weatherApi.getCurrent(city),
    weatherApi.getForecast(city),
    weatherApi.getAirPollution(city),
  ])

  if (weatherApi.error.value) {
    errorMessage.value = weatherApi.error.value
  }

  current.value = weatherData?.weather ?? null
  forecastItems.value = (forecastData?.forecast.list ?? []).slice(0, 8)
  pollution.value = pollutionData?.airPollution ?? null

  await loadHistory()
}

async function removeHistory(id: number) {
  await historyApi.remove(id)
  await loadHistory()
}

onMounted(async () => {
  await loadHistory()
  await loadCity(cityQuery.value)
})
</script>

<style scoped lang="scss">
.page__error {
  margin: 0;
  padding: 0.85rem 1rem;
  border-radius: var(--radius);
  background: var(--danger-soft);
  color: var(--danger);
  font-size: 0.9rem;
}
</style>
