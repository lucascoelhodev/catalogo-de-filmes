# Catálogo de Filmes - Aplicação Full Stack

Este projeto é um catálogo de filmes que integra a API pública do The Movie Database (TMDB) para busca de filmes e permite gerenciar localmente uma lista de favoritos.

---

## Como rodar o projeto localmente com Docker

### Requisitos
- Docker e Docker Compose instalados ([instruções](https://docs.docker.com/get-docker/))
- Chave de API do TMDB (veja seção abaixo)

### Passo a passo

1. Clone o repositório:
   ```bash
   git clone https://github.com/lucascoelhodev/catalogo-de-filmes.git
   cd catalogo-de-filmes
2. Copie o arquivo de ambiente e configure as variáveis:
   ```bash
   cp .env.example .env
Edite o .env para configurar:

APP_KEY: será gerada no próximo passo

DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

TMDB_API_KEY: sua chave da API do TMDB
3. Rode o composer install:
    ```bash
    composer install
    
4. Gere a chave da aplicação Laravel:
    ```bash
    docker-compose run --rm laravel.test php artisan key:generate
5. Suba os containers:
   ```bash
   docker-compose up -d
6. Rode as migrations:
   ```bash
   docker-compose exec laravel.test php artisan migrate
### Testando a aplicação
Execute dentro do container da aplicação:
    ```bash
    
    docker-compose exec laravel.test php artisan test
### Obtendo a chave da API do TMDB
1. Acesse: https://www.themoviedb.org/

2. Crie uma conta gratuita ou faça login

3. Vá para sua conta > Configurações > API

4. Solicite uma chave de API (gratuita)

5. Copie a chave e insira no arquivo .env na variável TMDB_API_KEY
### Subindo o frontend
1. Navegue até a pasta do frontend:
   ```bash
   cd frontend
2. Copie o arquivo de ambiente e configure as variáveis:
   ```bash
   cp .env.example .env
3. Instale as dependências:
   ```bash
   npm install
4. Suba o container:
    ```bash
   docker-compose up -d
5. Acesse via navegador: http://localhost:5174/
