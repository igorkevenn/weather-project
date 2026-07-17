<template>
  <svg
    class="weather-meta-icon"
    :width="size"
    :height="size"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.75"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
  >
    <!-- Sensação: termômetro -->
    <template v-if="name === 'feels_like'">
      <path d="M10 14.6V5a2 2 0 1 1 4 0v9.6a3.5 3.5 0 1 1-4 0z" />
      <circle cx="12" cy="16" r="1" fill="currentColor" stroke="none" />
    </template>

    <!-- Umidade: gota -->
    <template v-else-if="name === 'humidity'">
      <path d="M12 3s6 6.5 6 10.5a6 6 0 0 1-12 0C6 9.5 12 3 12 3z" />
    </template>

    <!-- Vento: linhas de fluxo -->
    <template v-else-if="name === 'wind'">
      <path d="M3 8h9a2.5 2.5 0 1 0-2.5-2.5" />
      <path d="M3 12.5h13a2.5 2.5 0 1 1-2.5 2.5" />
      <path d="M3 17h7a2 2 0 1 1-2 2" />
    </template>

    <!-- Pressão: manômetro -->
    <template v-else-if="name === 'pressure'">
      <circle cx="12" cy="13" r="7" />
      <path d="M12 13l3-3" />
      <path d="M9 4h6" />
    </template>
  </svg>
</template>

<script setup lang="ts">
withDefaults(
  defineProps<{
    name: 'feels_like' | 'humidity' | 'wind' | 'pressure'
    size?: number
  }>(),
  {
    size: 16,
  },
)
</script>

<style scoped>
.weather-meta-icon {
  flex-shrink: 0;
  color: var(--icon-color);
}
</style>
