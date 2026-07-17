<template>
  <section v-if="weather" class="current card">
    <div class="current__top">
      <div>
        <p class="current__city">{{ weather.city_name }}</p>
        <p class="current__desc">{{ weather.description }}</p>
      </div>
      <img
        v-if="weather.icon"
        :src="weatherIconUrl(weather.icon, true)"
        :alt="weather.description"
        class="current__icon"
        loading="lazy"
        decoding="async"
      />
    </div>

    <p class="current__temp">{{ Math.round(weather.temperature) }}°</p>

    <ul class="current__meta">
      <li><WeatherMetaIcon name="feels_like" />Sensação {{ Math.round(weather.feels_like) }}°</li>
      <li><WeatherMetaIcon name="humidity" />Umidade {{ weather.humidity }}%</li>
      <li><WeatherMetaIcon name="wind" />Vento {{ weather.wind_speed }} m/s</li>
      <li><WeatherMetaIcon name="pressure" />Pressão {{ weather.pressure }} hPa</li>
    </ul>
  </section>
</template>

<script setup lang="ts">
import { weatherIconUrl } from '@/helpers/openWeather'
import WeatherMetaIcon from '@/components/Common/WeatherMetaIcon.vue'
import type { Weather } from '@/types/Api/weather.type'

defineProps<{
  weather: Weather | null
}>()
</script>

<style scoped lang="scss">
.current__top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
}

.current__city {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 600;
}

.current__desc {
  margin: 0.2rem 0 0;
  color: var(--text-muted);
  font-size: 0.9rem;
  text-transform: capitalize;
}

.current__icon {
  width: 72px;
  height: 72px;
  object-fit: contain;
  flex-shrink: 0;
}

.current__temp {
  margin: 0.75rem 0;
  font-size: 3rem;
  font-weight: 600;
  line-height: 1;
  letter-spacing: -0.03em;
}

.current__meta {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem 1rem;
  margin: 0;
  padding: 0;
  list-style: none;
  color: var(--text-muted);
  font-size: 0.85rem;

  li {
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }
}
</style>
