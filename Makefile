.PHONY: configure install update migrate reset

build: build_less build_js
	@echo "Done."

build_less:
	@echo "Compiling less files..."
	@./node_modules/less/bin/lessc --yui-compress ./public/less/reset.less > \
		./public/css/reset.min.css
	@./node_modules/less/bin/lessc --yui-compress ./public/less/main.less > \
		./public/css/main.min.css

build_js:
	@echo "Minfying javascripts..."
	@./node_modules/uglify-js/bin/uglifyjs -o public/js/main.min.js \
		public/js/main.js

configure:
	@chmod 777 -R app/storage/
	@echo "Configured application."

install:
	@curl -sS https://getcomposer.org/installer | php
	@./composer.phar install
	@npm install
	@./node_modules/bower/bin/bower install
	@echo "All dependencies installed."
	@php artisan migrate

update:
	@./composer.phar update
	@npm update
	@./node_modules/bower/bin/bower update
	@echo "All dependencies updated."
	@php artisan migrate

migrate:
	@php artisan migrate

reset:
	@php artisan migrate:reset