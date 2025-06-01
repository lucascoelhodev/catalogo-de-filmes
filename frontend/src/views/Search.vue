<template>
  <div class="search-page">
    <input v-model="query" @keyup.enter="searchMovies(1)" placeholder="Digite o nome do filme" />
    <button @click="searchMovies(1)">Buscar</button>

    <div v-if="loading">Carregando...</div>

    <div v-if="movies.length === 0 && !loading">Nenhum filme encontrado.</div>

    <div>
      <MovieCard v-for="movie in movies" :key="movie.id" :movie="movie" :isFavorite="favoritesMap.has(movie.id)"
        @add="addFavorite" @remove="removeFavorite" />
    </div>

    <div v-if="totalPages > 1" class="pagination">
      <button :disabled="currentPage === 1" @click="searchMovies(currentPage - 1)">Anterior</button>

      <button v-for="page in pagesToShow" :key="page" :class="{ active: page === currentPage }"
        @click="searchMovies(page)">
        {{ page }}
      </button>

      <button :disabled="currentPage === totalPages" @click="searchMovies(currentPage + 1)">Próxima</button>
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
      currentPage: 1,
      totalPages: 1,
    }
  },
  created() {
    this.loadFavorites()
  },
  methods: {
    async searchMovies(page = 1) {
      
      if (!this.query.trim()) return;
      this.loading = true;
      this.currentPage = page;
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        const response = await axios.get(
          `${apiBaseUrl}tmdb/search?query=${encodeURIComponent(this.query)}&page=${page}`
        );
        this.movies = response.data.results;
        this.totalPages = response.data.total_pages || 1; // Ajuste se a API retornar um campo diferente
      } catch (error) {
        alert('Erro ao buscar filmes');
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
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
  computed: {
    pagesToShow() {
      const maxPagesToShow = 5; 
      let start = Math.max(this.currentPage - Math.floor(maxPagesToShow / 2), 1);
      let end = start + maxPagesToShow - 1;

      if (end > this.totalPages) {
        end = this.totalPages;
        start = Math.max(end - maxPagesToShow + 1, 1);
      }

      const pages = [];
      for (let i = start; i <= end; i++) {
        pages.push(i);
      }
      return pages;
    }
  }

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

.pagination {
  margin-top: 1rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}
.pagination button.active {
  font-weight: bold;
  background-color: #007bff;
  color: white;
  border-radius: 4px;
}

</style>
