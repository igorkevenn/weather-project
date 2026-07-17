<template>
  <section v-if="items.length" class="forecast card">
    <h2 class="section-title">Previsão</h2>
    <div class="forecast__track">
      <article v-for="item in items" :key="item.timestamp" class="forecast__item">
        <p class="forecast__when">{{ formatWhen(item.datetime) }}</p>
        <img
          v-if="item.icon"
          :src="weatherIconUrl(item.icon, true)"
          :alt="item.description"
          class="forecast__icon"
          loading="lazy"
          decoding="async"
        />
        <p class="forecast__temp">{{ Math.round(item.temperature) }}°</p>
        <p class="forecast__desc">{{ item.description }}</p>
      </article>
    </div>
  </section>
</template>

<script setup lang="ts">
import { weatherIconUrl } from '@/helpers/openWeather'
import type { ForecastItem } from '@/types/Api/weather.type'

defineProps<{
  items: ForecastItem[]
}>()

function formatWhen(datetime: string) {
  const date = new Date(datetime.replace(' ', 'T') + 'Z')
  return new Intl.DateTimeFormat('pt-BR', {
    weekday: 'short',
    hour: '2-digit',
    minute: '2-digit',
  }).format(date)
}
</script>

<style scoped lang="scss">
.forecast__track {
  display: grid;
  grid-auto-flow: column;
  grid-auto-columns: minmax(96px, 1fr);
  gap: 0.5rem;
  overflow-x: auto;
  padding-bottom: 0.5rem;
  scrollbar-width: thin;
  scrollbar-color: var(--line) transparent;

  &::-webkit-scrollbar {
    height: 6px;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: var(--line);
    border-radius: 3px;
  }
}

.forecast__item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.25rem;
  padding: 0.75rem 0.5rem;
  border-radius: 8px;
  background: #fff;
  text-align: center;
}

.forecast__icon {
  width: 44px;
  height: 44px;
  object-fit: contain;
  margin: 0.15rem 0;
}

.forecast__when,
.forecast__desc {
  margin: 0;
  color: var(--text-muted);
  font-size: 0.75rem;
  text-transform: capitalize;
}

.forecast__temp {
  margin: 0;
  font-size: 1rem;
  font-weight: 600;
}
</style>
