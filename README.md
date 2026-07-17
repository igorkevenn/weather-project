# Weather App 

Aplicação de previsão do tempo desenvolvida consumindo a [API da OpenWeatherMap](https://openweathermap.org/api) expondo os dados através de uma API REST própria, consumida por um frontend em Vue 3.

## Funcionalidades

- Busca de cidade por nome (geocoding) ou por coordenadas
- Clima atual: temperatura, sensação térmica, umidade, vento e pressão
- Previsão horária
- Qualidade do ar (AQI e poluentes), com selo colorido — verde (bom), amarelo (moderado), vermelho (ruim)
- Histórico das últimas 5 buscas, sempre de cidades diferentes, com opção de repetir ou remover uma busca

## Tecnologias

**Backend:** PHP 8.2 base (sem framework), PDO/MySQL, Nginx, Docker, Phinx para migrations.

**Frontend:** Vue 3, TypeScript, Vite, SCSS, Axios.

## Arquitetura

O backend não usa um framework — é uma estrutura enxuta em `backend/src/`, organizada por responsabilidade:

```
Http/Routes/api/*.php    → Roteamento (recebe a URI, delega e devolve a resposta)
Models/Api/{Recurso}/    → Listing (leitura) e Action (escrita) orquestram o caso de uso
Services/                → Integração com a API da OpenWeather
Repositories/            → Acesso a dados (PDO), implementam interfaces em Interfaces/
DTOs/                    → Objetos de transferência tipados entre as camadas
```

O frontend segue a mesma ideia de separação:

```
composables/Api/         → Chamadas HTTP por domínio (Weather, History)
components/Common/       → Peças reutilizáveis (ícones)
components/Views/Weather/→ Componentes específicos da tela de clima
views/                   → Composição das telas
assets/styles/main.scss  → Tokens de design (cores, espaçamento, tipografia)
```

## Como rodar o projeto

### Pré-requisitos

- Docker e Docker Compose
- Node.js 18+
- Uma chave de API gratuita da [OpenWeatherMap](https://home.openweathermap.org/api_keys)

### Backend

1. Copie o arquivo de ambiente e preencha sua chave da OpenWeather:

   ```bash
   cp .env.example .env
   ```

2. Suba os containers (Nginx + PHP-FPM + MySQL):

   ```bash
   docker compose up -d --build
   ```

3. Instale as dependências PHP e rode as migrations:

   ```bash
   docker exec weather_app_php sh -c "cd /var/www/html/backend && composer install"
   docker exec weather_app_php sh -c "cd /var/www/html/backend && vendor/bin/phinx migrate"
   ```

4. A API estará disponível em `http://localhost:8181`.

### Frontend

1. Copie o arquivo de ambiente:

   ```bash
   cd frontend
   cp .env.example .env
   ```

2. Instale as dependências e suba o servidor de desenvolvimento:

   ```bash
   npm install
   npm run dev
   ```

3. Acesse `http://localhost:5173`.

## Endpoints da API

| Método | Rota                  | Descrição                                             |
| ------ | --------------------- | ------------------------------------------------------ |
| GET    | `/api/geocode?q=`      | Busca cidades por nome                                  |
| GET    | `/api/weather?city=`   | Clima atual (aceita `city` ou `lat`/`lon`)              |
| GET    | `/api/forecast?city=`  | Previsão (aceita `city` ou `lat`/`lon`)                 |
| GET    | `/api/air-pollution?city=` | Qualidade do ar (aceita `city` ou `lat`/`lon`)     |
| GET    | `/api/history?limit=`      | Últimas buscas (padrão e máximo: 5)                |
| DELETE | `/api/history/{id}`   | Remove um item do histórico                             |

Toda resposta segue o formato `{ "status": boolean, "data": ... }`.

Todas as rotas acima já estão prontas para uso em [`docs/api.http`](api.http) — com a extensão [REST Client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client) no VS Code, basta abrir o arquivo e clicar em "Send Request" acima de cada requisição.

## Autor

Igor Kevenn
