<template>
  <div class="favorites-page">
    <h2>Filmes Favoritos</h2>

    <select v-model="selectedGenre" @change="filterByGenre">
      <option value="">Todos os gêneros</option>
      <option v-for="g in genres" :key="g.id" :value="g.id">{{ g.name }}</option>
    </select>

    <div v-if="favorites.length === 0">Nenhum filme favorito salvo.</div>

    <div>
      <MovieCard v-for="movie in favorites" :key="movie.tmdb_id" :movie="movie" :isFavorite="true"
        @remove="removeFavorite" />
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
    }
  },
  computed: {

    filteredFavorites() {

      if (!this.selectedGenre) return this.favorites
      return this.favorites.filter((movie) =>
        movie.genre_ids?.includes(parseInt(this.selectedGenre))
      )
    },
  },
  async created() {
    await this.loadGenres()
    await this.loadFavorites()
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

    async loadFavorites() {
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        const response = await axios.get(`${apiBaseUrl}movie`);
        this.favorites = response.data.data;
      } catch (error) {
        console.error('Erro ao carregar favoritos:', error);
        this.favorites = [];
      }
    },

    async removeFavorite(tmdbId) {
      try {
        const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
        await axios.delete(`${apiBaseUrl}movie/${tmdbId}`);
        this.favorites = this.favorites.filter((f) => f.tmdb_id !== tmdbId);
      } catch (error) {
        console.error('Erro ao remover favorito:', error);
        alert('Erro ao remover favorito');
      }
    },

    filterByGenre() {
      const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
      const params = {};
      if (this.selectedGenre) {
        params.genre_id = this.selectedGenre;
      }
      axios.get(`${apiBaseUrl}movie`, { params })
        .then(response => {
          this.favorites = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    }

  },

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
</style>
