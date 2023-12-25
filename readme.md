# Timesheet

### Local development

Run project
```bash
docker compose up --build -d
```

Run migrations and seed database with fake data
```bash
docker compose exec server php artisan migrate:fresh --seed
```

Visit website
```
http://localhost:8080
```

Login using `admin:abc123`
