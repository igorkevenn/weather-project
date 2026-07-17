<template>
  <section class="history card">
    <h2 class="section-title">Últimas buscas</h2>

    <p v-if="!items.length" class="history__empty">Nenhuma busca ainda.</p>

    <ul v-else class="history__list">
      <li v-for="item in items" :key="item.id" class="history__item">
        <button class="history__pick" type="button" @click="emit('select', item.city_name)">
          <strong>{{ item.city_name }}</strong>
          <span>{{ Math.round(item.temperature) }}° · {{ item.description }}</span>
        </button>
        <button class="history__remove" type="button" aria-label="Remover" @click="emit('remove', item.id)">
          ×
        </button>
      </li>
    </ul>
  </section>
</template>

<script setup lang="ts">
import type { HistoryItem } from '@/types/Api/weather.type'

defineProps<{
  items: HistoryItem[]
}>()

const emit = defineEmits<{
  select: [city: string]
  remove: [id: number]
}>()
</script>

<style scoped lang="scss">
.history__empty {
  margin: 0;
  color: var(--text-muted);
  font-size: 0.9rem;
}

.history__list {
  margin: 0;
  padding: 0;
  list-style: none;
  display: grid;
  gap: 0.4rem;
}

.history__item {
  display: flex;
  gap: 0.4rem;
  align-items: stretch;
}

.history__pick {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 0.1rem;
  padding: 0.7rem 0.85rem;
  border: 0;
  border-radius: 8px;
  background: var(--bg);
  color: var(--text);
  text-align: left;
  transition: background 0.15s ease;

  strong {
    font-size: 0.9rem;
    font-weight: 500;
  }

  span {
    color: var(--text-muted);
    font-size: 0.8rem;
    text-transform: capitalize;
  }

  &:hover {
    background: var(--surface-hover);
  }
}

.history__remove {
  width: 2.25rem;
  border: 0;
  border-radius: 8px;
  background: var(--bg);
  color: var(--text-muted);
  font-size: 1.1rem;
  line-height: 1;
  transition: background 0.15s ease, color 0.15s ease;

  &:hover {
    background: var(--danger-soft);
    color: var(--danger);
  }
}
</style>
