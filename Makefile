export WWWGROUP=${WWWGROUP:-$(id -g)}
export WWWUSER=${WWWUSER:-$UID}
BACKEND_ENV=docker run --rm -i --user $(shell id -u):$(shell id -g) -v $(shell git rev-parse --show-superproject-working-tree --show-toplevel | head -1):/var/www/html -w /var/www/html laravelsail/php82-composer:latest
SAIL=$(shell git rev-parse --show-superproject-working-tree --show-toplevel | head -1)/vendor/bin/sail
COMPOSER=docker run --rm -i --user `id -u`:`id -g` -v `git rev-parse --show-superproject-working-tree --show-toplevel | head -1`:/app composer:2.3.10
BACKEND_ROOT=$(shell git rev-parse --show-superproject-working-tree --show-toplevel | head -1)

.Pony: setup-local
setup-local:
	@make setup

.Pony: setup-ci
setup-ci:
	@make setup

# swagger-ui:
# 	(cd utils && docker compose up swagger_ui -d --no-recreate )
# 	open http://localhost:8080/

.Pony: setup
setup:
	(cp .env.example .env)
	(${BACKEND_ENV} composer install --ignore-platform-reqs)
	(${BACKEND_ENV} php artisan key:generate)
	@make up
	@make generate
	# (${SAIL} pint)

.Pony: build
build:
	(${BACKEND_ENV} composer install --ignore-platform-reqs)
	(${SAIL} build ${BUILD_OPTIONS})

.Pony: generate
generate:
	# (${BACKEND_ENV} php artisan ide-helper:generate)
    # TODO: 接続先をPostgresに変更する
	# @make migrate
    # TODO: ide-helper入れる
	# @make annotation
	# TODO: OpenAPI スキーマ
	# @make oas-generate

.Pony: up
up:
	(${SAIL} up -d --build)

.Pony: down
down:
	(${SAIL} down)

.Pony: destroy
destroy:
	(${SAIL} down -v)

.Pony: test
test:
	(${SAIL} test --coverage --coverage-clover clover.xml  )

.Pony: lint
lint:
	(${SAIL} pint)
	@make phpstan

.Pony: oas-generate
oas-generate:
	(${SAIL} artisan openapi:generate > $(shell pwd)/documents/api/schema.json)

.Pony: route-check
route-check:
	(${SAIL} artisan route:list)

.Pony: all-containers-build
all-containers-build:
	@make build

.Pony: trivy
trivy:
	trivy image $(shell docker images --format "{{.Repository}}:{{.Tag}}" | grep -v "<none>:<none>")

.Pony: tinker
tinker:
	(${SAIL} tinker)

.Pony: ash
ash:
	(${SAIL} exec laravel.test ash)

.Pony: migrate
migrate:
	(${SAIL} artisan migrate)

.Pony: annotation
annotation:
	(${SAIL} artisan ide-helper:model --write)

.Pony: phpstan
phpstan:
	(${BACKEND_ENV} vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=2G)

# make require-dev package=<package name>で利用可能
.Pony: require-dev
require-dev:
	@if [ -z "$(package)" ]; then \
		echo "package variable is not set. Example: make require-dev package=laravel/sail"; \
		exit 1; \
	fi
	$(COMPOSER) require --dev $(package)

# make require package=<package name>で利用可能
.Pony: require
require:
	@if [ -z "$(package)" ]; then \
		echo "package variable is not set. Example: make require package=laravel/sail"; \
		exit 1; \
	fi
	$(COMPOSER) require $(package)
