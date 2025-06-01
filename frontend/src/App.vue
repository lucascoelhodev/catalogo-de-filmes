<template>
  <div>
    <nav class="navbar">
      <router-link to="/">Buscar Filmes</router-link>
      <router-link to="/favorites">Favoritos</router-link>
    </nav>
    <router-view />
  </div>
</template>

<style>
.navbar {
  background-color: #1e1e2f;
  padding: 1rem;
  display: flex;
  gap: 1rem;
}

.navbar a {
  color: white;
  text-decoration: none;
  font-weight: bold;
}

.navbar a.router-link-active {
  border-bottom: 2px solid #61dafb;
}
</style>
