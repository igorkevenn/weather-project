<template>
  <svg
    class="pollution-icon"
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
    <!-- CO: nuvem / gás -->
    <template v-if="name === 'co'">
      <path d="M7 16a4 4 0 1 1 0-8 5 5 0 0 1 9.5 1.5A3.5 3.5 0 1 1 17 16H7z" />
      <path d="M9 14h6" />
    </template>

    <!-- NO / NO2: molécula -->
    <template v-else-if="name === 'no' || name === 'no2'">
      <circle cx="8" cy="12" r="2.5" />
      <circle cx="16" cy="12" r="2.5" />
      <path d="M10.5 12h3" />
      <circle v-if="name === 'no2'" cx="12" cy="7" r="1.5" fill="currentColor" stroke="none" />
    </template>

    <!-- O3: sol / camada -->
    <template v-else-if="name === 'o3'">
      <circle cx="12" cy="12" r="4" />
      <path d="M12 2v2M12 20v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M2 12h2M20 12h2" />
    </template>

    <!-- SO2: fábrica -->
    <template v-else-if="name === 'so2'">
      <path d="M4 20V10l4-2v12M12 20V6l4-2v16M20 20V12l2-1v9" />
      <path d="M2 20h20" />
    </template>

    <!-- PM2.5 / PM10: partículas -->
    <template v-else-if="name === 'pm2_5' || name === 'pm10'">
      <circle cx="7" cy="10" r="1" fill="currentColor" stroke="none" />
      <circle cx="12" cy="8" r="1.2" fill="currentColor" stroke="none" />
      <circle cx="17" cy="11" r="0.9" fill="currentColor" stroke="none" />
      <circle cx="10" cy="14" r="1.1" fill="currentColor" stroke="none" />
      <circle cx="15" cy="15" r="1.3" fill="currentColor" stroke="none" />
      <circle v-if="name === 'pm10'" cx="12" cy="12" r="1.4" fill="currentColor" stroke="none" />
    </template>

    <!-- NH3: frasco / químico -->
    <template v-else-if="name === 'nh3'">
      <path d="M9 3h6l1 4H8l1-4z" />
      <path d="M8 7h8v12a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V7z" />
      <path d="M10 11h4" />
    </template>

    <!-- fallback -->
    <template v-else>
      <circle cx="12" cy="12" r="8" />
      <path d="M12 8v4M12 16h.01" />
    </template>
  </svg>
</template>

<script setup lang="ts">
defineProps<{
  name: string
  size?: number
}>()
</script>

<style scoped>
.pollution-icon {
  flex-shrink: 0;
  color: var(--icon-color);
}
</style>
