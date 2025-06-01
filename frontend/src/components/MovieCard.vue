<template>
  <div class="movie-card">
    <img
      v-if="movie.poster_path"
      :src="`https://image.tmdb.org/t/p/w200${movie.poster_path}`"
      alt="Poster"
    />
    <div class="info">
      <h3>{{ movie.title }}</h3>
      <p>{{ movie.release_date_label }}</p>
      <button v-if="isFavorite" @click="$emit('remove', movie.id)">Remover</button>
      <button v-else @click="$emit('add', movie)">Adicionar</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    movie: Object,
    isFavorite: Boolean,
  },
}
</script>

<style>
.movie-card {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
  background: #f0f0f0;
  padding: 1rem;
  border-radius: 6px;
  align-items: center;
}
.movie-card img {
  border-radius: 4px;
}
.info h3 {
  margin: 0;
}
.info button {
  margin-top: 0.5rem;
  cursor: pointer;
  background-color: #61dafb;
  border: none;
  padding: 0.3rem 0.6rem;
  border-radius: 3px;
}
</style>
