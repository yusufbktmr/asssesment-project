up:
	docker-compose up -d --build

down:
	docker-compose down

restart:
	docker-compose down && docker-compose up -d --build

logs:
	docker-compose logs -f

bash:
	docker exec -it app bash

migrate:
	docker exec -it app php artisan migrate

seed:
	docker exec -it app php artisan db:seed
