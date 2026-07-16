#
# Makefile
#
# You can run it from the command line by typing eg.:
#   make install
#
# You can read a user-friendly introduction to Makefile basics here:
# https://gist.github.com/Isinlor/035399fe952f5e3ced4280a5cc635a84
#

ifeq ($(OS),Windows_NT)     # is Windows_NT on XP, 2000, 7, Vista, 10...
	SHELL := powershell.exe
	ENV_CMD=
	RUN_CMD=$(shell if (Test-Path env:OR_RUN_LOCAL) { echo ""; } else{ echo "docker-compose exec -T -w /app web"; })
else
	UID=$(shell id -u) 
	GID=$(shell id -g)
	ENV_CMD=env UID=$(UID) GID=$(GID)
	RUN_CMD=$(shell if [ -n "$$OR_RUN_LOCAL" ]; then echo ""; else echo "env UID=$(UID) GID=$(GID) docker-compose exec -T -w /app web"; fi)  # same as "uname -s"

endif

.DEFAULT_GOAL := help

.PHONY: start-nonlocal
start-nonlocal:
ifndef OR_RUN_LOCAL
	$(ENV_CMD) docker-compose up --build -d
endif

.PHONY: restart-selenium
restart-selenium:
# ifndef OR_RUN_LOCAL
# 	$(ENV_CMD) docker-compose restart selenium
# endif

.PHONY: start
start: ## Start Docker Compose Containers in background
	$(ENV_CMD) docker-compose up --build -d

.PHONY: start-forground
start-forground: ## Start Docker Compose Containers in forground
	$(ENV_CMD) docker-compose up --build

.PHONY: stop
stop: ## Stop Docker Compose Containers
	$(ENV_CMD) docker-compose stop

.PHONY: teardown
teardown: ## Teardown Docker Compose Containers
	$(ENV_CMD) docker-compose down
	
.PHONY: install
install: start-nonlocal composer vendor/autoload.php yarn css-compile ## Install all dependencies (including dev deps) for Open-Realty

.PHONY: composer
composer: ## Install PHP composer (This is run automatically by 'make install')
	$(RUN_CMD) ./composer_install.sh

.PHONY: vendor/autoload.php
vendor/autoload.php: ## Install PHP dependencies with composer (This is run automaticallyy by 'make install')
	$(RUN_CMD) php composer.phar install

.PHONY: yarn
yarn: ## Install Javascript dependencies with yarn (This is run automatically by 'make install')
	$(RUN_CMD) yarn install
	
.PHONY: clean
clean: ## Delete All installed PHP and Javascript Dependencies
	$(RUN_CMD) rm -rf src/node_modules
	$(RUN_CMD) rm -rf src/vendor

.PHONY: devignoreinstall
devignoreinstall: src/devignoreinstall ## Add devignoreinstall file

src/devignoreinstall:
	$(RUN_CMD)  touch src/devignoreinstall

.PHONY: install-dist
install-dist: composer vendor/autoload.php yarn css-compile ## Install all non dev dependencies for Open-Realty
	$(RUN_CMD) php composer.phar install --no-dev --quiet

.PHONY: bundle
bundle: install-dist ## Runs install-dist and then zips Open-Realty 
	mkdir -p dist
	cd src; zip -r ../dist/open-realty.zip . -x tests\* -x c3.php -x c3tmp\*

.PHONY: clean-test-output
clean-test-output:
	$(RUN_CMD) rm -Rf src/tests/_output/* 
	$(RUN_CMD) chmod +w src/tests/_output

.PHONY: test
test: install clean-test-output ## Run Unit Test
	$(RUN_CMD) bash -c 'XDEBUG_MODE=coverage src/vendor/bin/codecept run unit --xml  --html'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/report.xml); echo "$${CONTENT}" | sed "s+$$(pwd)/+/+g" > src/tests/_output/report.xml'

.PHONY: test-all
test-all: install clean-test-output## Run All Tests
	$(RUN_CMD) bash -c 'XDEBUG_MODE=coverage src/vendor/bin/codecept run --xml --html'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/report.xml); echo "$${CONTENT}" | sed "s+$$(pwd)/+/+g" > src/tests/_output/report.xml'

.PHONY: test-integration
test-integration: install clean-test-output ## Run Integration Test
	$(RUN_CMD) bash -c 'XDEBUG_MODE=coverage src/vendor/bin/codecept run integration --xml  --html'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/report.xml); echo "$${CONTENT}" | sed "s+$$(pwd)/+/+g" > src/tests/_output/report.xml'

.PHONY: test-acceptance
test-acceptance: install clean-test-output ## Run Acceptance Test
	$(RUN_CMD) bash -c 'XDEBUG_MODE=coverage src/vendor/bin/codecept run acceptance --xml --html'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/report.xml); echo "$${CONTENT}" | sed "s+$$(pwd)/+/+g" > src/tests/_output/report.xml'

.PHONY: coverage
coverage: install clean-test-output restart-selenium ## Run Unit test coverage
	$(RUN_CMD) bash -c 'XDEBUG_MODE=coverage src/vendor/bin/codecept run unit  --xml --html --coverage --no-colors --coverage-text --coverage-cobertura=cobertura.xml'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/report.xml); echo "$${CONTENT}" | sed "s+$$(pwd)/+/+g" > src/tests/_output/report.xml'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/cobertura.xml); echo "$${CONTENT}" | sed "s+filename=\"+filename=\"src/+g" > src/tests/_output/cobertura.xml'

.PHONY: coverage-all
coverage-all: install clean-test-output restart-selenium ## Run All test coverages
	$(RUN_CMD) bash -c 'XDEBUG_MODE=coverage src/vendor/bin/codecept run  --xml --html --coverage --no-colors --coverage-text --coverage-cobertura=cobertura.xml' 
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/report.xml); echo "$${CONTENT}" | sed "s+$$(pwd)/+/+g" > src/tests/_output/report.xml'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/cobertura.xml); echo "$${CONTENT}" | sed "s+filename=\"+filename=\"src/+g" > src/tests/_output/cobertura.xml'

	
.PHONY: coverage-integration
coverage-integration: install clean-test-output restart-selenium ## Run Integration test coverage
	$(RUN_CMD) bash -c 'XDEBUG_MODE=coverage src/vendor/bin/codecept run integration  --xml --html --coverage --no-colors --coverage-text --coverage-cobertura=cobertura.xml' 
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/report.xml); echo "$${CONTENT}" | sed "s+$$(pwd)/+/+g" > src/tests/_output/report.xml'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/cobertura.xml); echo "$${CONTENT}" | sed "s+filename=\"+filename=\"src/+g" > src/tests/_output/cobertura.xml'

	
.PHONY: coverage-acceptance
coverage-acceptance: install clean-test-output restart-selenium ## Run Acceptance test coverage
	$(RUN_CMD) bash -c 'XDEBUG_MODE=coverage src/vendor/bin/codecept run acceptance  --xml --html --coverage --no-colors --coverage-text --coverage-cobertura=cobertura.xml' 
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/report.xml); echo "$${CONTENT}" | sed "s+$$(pwd)/+/+g" > src/tests/_output/report.xml'
	$(RUN_CMD) bash -c 'CONTENT=$$(cat src/tests/_output/cobertura.xml); echo "$${CONTENT}" | sed "s+filename=\"+filename=\"src/+g" > src/tests/_output/cobertura.xml'


.PHONE: review
review: php-cs-fixer

.PHONY: php-cs-fixer
php-cs-fixer: install ## Run php-cs-fixer (Run Before Committing Code)
	$(RUN_CMD) src/vendor/bin/php-cs-fixer fix -v

.PHONY: php-cs-fixer-check
php-cs-fixer-check: install ## Run php-cs-fixer in dry run mode
	$(RUN_CMD) src/vendor/bin/php-cs-fixer fix --dry-run --using-cache=no
	
.PHONY: phpmd
phpmd: install ## Run PHP Mess Detector
	$(RUN_CMD)  src/vendor/bin/phpmd ./src text ruleset.xml

.PHONY: phpstan
phpstan: install ## Run PHP Static Analysis Tool (PHPStan)
	$(RUN_CMD)  src/vendor/bin/phpstan analyse ./src --level=max --no-progress

.PHONY: psalm
psalm: install  ## Run PHP Static Analysis Tool (Psalm)
	$(RUN_CMD)  src/vendor/bin/psalm

.PHONY: css-compile
css-compile: ## Compile SCSS files into CSS
	$(RUN_CMD) yarn run node-sass --include-path ./src/node_modules --output-style compressed --source-map true --source-map-contents true --precision 6 ./src/admin/template/material/assets/scss/material.scss -o ./src/admin/template/material/assets/css/

.PHONY: css-purge
css-purge:
	# $(RUN_CMD) purgecss --keyframes --css assets/css/starter.css --content index.html \"node_modules/bootstrap/js/dist/{util,modal}.js\" --output assets/css/

.PHONY: show-run-cmd
show-run-cmd: ## Show Run Command, useful for checking if we are running commands in docker vs local
	@echo "$(RUN_CMD)"

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
