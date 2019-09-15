install:
	cp env.dist .env && cp behat.yml.dist behat.yml && composer install

	docker-compose up -d
	docker exec -it hotel-app /bin/bash ./wait-for-it.sh db:3306
	docker exec -it hotel-app ./bin/console doctrine:schema:update --force
	docker exec -it hotel-app ./bin/console doctrine:fixtures:load -q

runTests:
	./vendor/bin/behat
