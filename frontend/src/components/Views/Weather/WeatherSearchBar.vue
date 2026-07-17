<template>
  <form class="search card" @submit.prevent="emit('search', query.trim())">
    <label class="search__label" for="city">Cidade</label>
    <div class="search__row">
      <input
        id="city"
        v-model="query"
        class="search__input"
        type="text"
        placeholder="São Paulo, Curitiba..."
        autocomplete="off"
        :disabled="loading"
      />
      <button class="search__btn" type="submit" :disabled="loading || !query.trim()">
        {{ loading ? '...' : 'Buscar' }}
      </button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'

const props = defineProps<{
  loading?: boolean
  modelValue?: string
}>()

const emit = defineEmits<{
  search: [city: string]
  'update:modelValue': [value: string]
}>()

const query = ref(props.modelValue ?? '')

watch(
  () => props.modelValue,
  (value) => {
    if (value !== undefined) query.value = value
  },
)

watch(query, (value) => emit('update:modelValue', value))
</script>

<style scoped lang="scss">
.search__label {
  display: block;
  margin-bottom: 0.5rem;
  color: var(--text-muted);
  font-size: 0.8rem;
  font-weight: 500;
}

.search__row {
  display: flex;
  gap: 0.5rem;
}

.search__input {
  flex: 1;
  min-height: 2.5rem;
  padding: 0 0.85rem;
  border: 1px solid var(--line);
  border-radius: 8px;
  background: var(--bg);
  color: var(--text);
  outline: none;

  &:focus {
    border-color: var(--text-muted);
  }

  &::placeholder {
    color: var(--text-muted);
  }
}

.search__btn {
  min-height: 2.5rem;
  padding: 0 1rem;
  border: 0;
  border-radius: 8px;
  background: var(--accent);
  color: var(--accent-text);
  font-weight: 500;
  font-size: 0.9rem;

  &:disabled {
    opacity: 0.45;
    cursor: not-allowed;
  }
}
</style>
