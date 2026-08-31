.PHONY: run shell composer build test

# Interactive pattern runner
run:
	@./run

# Open container bash shell
shell:
	@./run bash

# Run composer commands: make composer ARGS="dump-autoload"
composer:
	@./run composer $(ARGS)

# Run test suite
test:
	@./run test

# Build docker image
build:
	@./run build
