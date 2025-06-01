<template>
  <div class="search-page">
    <input v-model="query" @keyup.enter="searchMovies" placeholder="Digite o nome do filme" />
    <button @click="searchMovies">Buscar</button>

    <div v-if="loading">Carregando...</div>

    <div v-if="movies.length === 0 && !loading">Nenhum filme encontrado.</div>

    <div>
      <MovieCard v-for="movie in movies" :key="movie.id" :movie="movie" :isFavorite="favoritesMap.has(movie.id)"
        @add="addFavorite" @remove="removeFavorite" />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import MovieCard from '../components/MovieCard.vue'

export default {
  components: { MovieCard },
  data() {
    return {
      query: '',
      movies: [],
      loading: false,
      favoritesMap: new Map(),
    }
  },
  created() {
    this.loadFavorites()
  },
  methods: {
    async searchMovies() {
      if (!this.query.trim()) return;
      this.loading = true;
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        const response = await axios.get(
          `${apiBaseUrl}tmdb/search?query=${encodeURIComponent(this.query)}`
        );
        this.movies = response.data.results;
      } catch (error) {
        alert('Erro ao buscar filmes');
        console.error(error);
      } finally {
        this.loading = false;
      }
    }
    ,
    async loadFavorites() {
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        const res = await axios.get(`${apiBaseUrl}movie`)
        this.favoritesMap = new Map(res.data.map((f) => [f.tmdb_id, true]))
      } catch {
        this.favoritesMap = new Map()
      }
    },
    async addFavorite(movie) {
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        await axios.post(`${apiBaseUrl}movie`, {
          tmdb_id: movie.id,
          title: movie.title,
          poster_path: movie.poster_path,
          release_date: movie.release_date,
        });

        this.favoritesMap.set(movie.id, true)
      } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
          alert(`Erro ao adicionar favorito: ${error.response.data.message}`);
        } else {
          alert(`Erro ao adicionar favorito: ${error.message || 'Erro desconhecido'}`);
        }
        console.error(error);
      }
    },
    async removeFavorite(tmdbId) {
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        await axios.delete(`${apiBaseUrl}movie/${tmdbId}`)
        this.favoritesMap.delete(tmdbId)
      } catch {
        alert('Erro ao remover favorito')
      }
    },
  },
}
</script>

<style>
.search-page {
  max-width: 600px;
  margin: 2rem auto;
}

input {
  padding: 0.5rem;
  width: 80%;
  font-size: 1rem;
}

button {
  padding: 0.5rem 1rem;
  margin-left: 0.5rem;
  cursor: pointer;
  background-color: #61dafb;
  border: none;
  border-radius: 4px;
}
</style>
