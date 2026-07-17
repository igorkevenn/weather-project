<template>
  <div class="layout">
    <header class="layout__header">
      <h1 class="layout__brand">Previsão do tempo</h1>
      <p class="layout__tag">Clima, previsão e qualidade do ar</p>
    </header>
    <main class="layout__main">
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped lang="scss">
.layout {
  width: min(720px, calc(100% - 2rem));
  margin: 0 auto;
  padding: 2rem 0 3rem;
}

.layout__header {
  margin-bottom: 1.5rem;
}

.layout__brand {
  margin: 0;
  font-size: 1.5rem;
  font-weight: 600;
  letter-spacing: -0.02em;
}

.layout__tag {
  margin: 0.35rem 0 0;
  color: var(--text-muted);
  font-size: 0.9rem;
}

.layout__main {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}
</style>
