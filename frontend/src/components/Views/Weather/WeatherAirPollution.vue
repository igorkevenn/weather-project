<template>
  <section v-if="pollution" class="air card">
    <h2 class="section-title">Qualidade do ar</h2>
    <p class="air__aqi">
      <span class="air__badge" :class="aqiClass">AQI {{ pollution.aqi }}</span>
      {{ pollution.aqi_label }}
    </p>
    <ul class="air__list">
      <li v-for="(value, key) in pollution.components" :key="key">
        <PollutionIcon :name="String(key)" :size="18" />
        <div class="air__info">
          <strong>{{ label(String(key)) }}</strong>
          <span>{{ formatValue(value) }}</span>
        </div>
      </li>
    </ul>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import PollutionIcon from '@/components/Common/PollutionIcon.vue'
import { pollutionLabels } from '@/helpers/pollutionIcons'
import type { AirPollution } from '@/types/Api/weather.type'

const props = defineProps<{
  pollution: AirPollution | null
}>()

const aqiClass = computed(() => {
  const aqi = props.pollution?.aqi
  if (!aqi) return ''
  if (aqi <= 2) return 'air__badge--good'
  if (aqi === 3) return 'air__badge--moderate'
  return 'air__badge--bad'
})

function label(key: string) {
  return pollutionLabels[key] ?? key.toUpperCase()
}

function formatValue(value: number) {
  return Number.isInteger(value) ? String(value) : value.toFixed(2)
}
</script>

<style scoped lang="scss">
.air__aqi {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  margin: 0 0 0.85rem;
  font-size: 0.95rem;
}

.air__badge {
  display: inline-flex;
  padding: 0.25rem 0.6rem;
  border-radius: 6px;
  background: var(--bg);
  font-size: 0.8rem;
  font-weight: 600;

  &--good {
    background: var(--good-soft);
    color: var(--good);
  }

  &--moderate {
    background: var(--warning-soft);
    color: var(--warning);
  }

  &--bad {
    background: var(--danger-soft);
    color: var(--danger);
  }
}

.air__list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  gap: 0.5rem;
  margin: 0;
  padding: 0;
  list-style: none;
}

.air__list li {
  display: flex;
  align-items: flex-start;
  gap: 0.55rem;
  padding: 0.65rem 0.75rem;
  border-radius: 8px;
  background: var(--bg);
}

.air__info {
  display: flex;
  flex-direction: column;
  gap: 0.1rem;
  min-width: 0;

  strong {
    color: var(--text);
    font-size: 0.72rem;
    font-weight: 500;
    line-height: 1.2;
  }

  span {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-variant-numeric: tabular-nums;
  }
}
</style>
