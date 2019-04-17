install:
	docker run --user $$(id -u):$$(id -g) -v $(CURDIR):/var/www -w /var/www node:latest yarn install
clean:
	docker run -v $(CURDIR):/var/www -w /var/www node:latest rm -Rf ./node_modules
