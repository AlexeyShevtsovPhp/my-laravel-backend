install:
	docker compose build

start:
	docker compose up -d

stop:
	docker compose stop

migrate:
	docker exec -it thisone-my-php-app-1 php artisan migrate

seed:
	docker exec -it thisone-my-php-app-1 php artisan db:seed

full: install start migrate seed
