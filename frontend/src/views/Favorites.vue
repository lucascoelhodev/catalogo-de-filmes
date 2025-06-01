<template>
  <div class="favorites-page">
    <h2>Filmes Favoritos</h2>

    <select v-model="selectedGenre" @change="loadFavorites(1)">
      <option value="">Todos os gêneros</option>
      <option v-for="g in genres" :key="g.id" :value="g.id">{{ g.name }}</option>
    </select>

    <div v-if="favorites.length === 0">Nenhum filme favorito salvo.</div>

    <div>
      <MovieCard v-for="movie in favorites" :key="movie.tmdb_id" :movie="movie" :isFavorite="true"
        @remove="removeFavorite" />
    </div>

    <div v-if="totalPages > 1" class="pagination">
      <button :disabled="currentPage === 1" @click="loadFavorites(currentPage - 1)">Anterior</button>

      <button v-for="page in pagesToShow" :key="page" :class="{ active: page === currentPage }"
        @click="loadFavorites(page)">
        {{ page }}
      </button>

      <button :disabled="currentPage === totalPages" @click="loadFavorites(currentPage + 1)">Próxima</button>
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
      favorites: [],
      genres: [],
      selectedGenre: '',
      currentPage: 1,
      totalPages: 1,
    }
  },
  async created() {
    await this.loadGenres()
    await this.loadFavorites(1)
  },
  methods: {
    async loadGenres() {
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        const response = await axios.get(`${apiBaseUrl}genres`);
        this.genres = response.data.data;
      } catch (error) {
        console.error('Erro ao carregar gêneros:', error);
        this.genres = [];
      }
    },

    async loadFavorites(page = 1) {
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        const params = { page };
        if (this.selectedGenre) {
          params.genre_id = this.selectedGenre;
        }
        const response = await axios.get(`${apiBaseUrl}movie`, { params });
        this.favorites = response.data.data;
        this.currentPage = response.data.meta.pagination.current_page;
        this.totalPages = response.data.meta.pagination.total_pages;
      } catch (error) {
        console.error('Erro ao carregar favoritos:', error);
        this.favorites = [];
        this.currentPage = 1;
        this.totalPages = 1;
      }
    },

    async removeFavorite(tmdbId) {
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        await axios.delete(`${apiBaseUrl}movie/${tmdbId}`);
        // Recarrega a página atual para atualizar a lista (considerando paginação)
        this.loadFavorites(this.currentPage);
      } catch (error) {
        console.error('Erro ao remover favorito:', error);
        alert('Erro ao remover favorito');
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
.favorites-page {
  max-width: 600px;
  margin: 2rem auto;
}

select {
  margin-bottom: 1rem;
  padding: 0.5rem;
  font-size: 1rem;
}

.pagination {
  margin-top: 1rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}

button[disabled] {
  opacity: 0.5;
  cursor: not-allowed;
}

.pagination button.active {
  font-weight: bold;
  background-color: #007bff;
  color: white;
  border-radius: 4px;
}
</style>
