Docker quick start

1. Build and run the container:

```bash
docker compose up --build
```

2. Open the app in your browser: http://localhost:8000

Notes:
- The container will copy `.env.example` to `.env`, create `database/database.sqlite`, run migrations and seeders, then start the built-in PHP server.
- If you want the container to rebuild assets during development, rebuild the container or run `npm install && npm run dev` inside the container.
