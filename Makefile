THIS_FILE := $(lastword $(MAKEFILE_LIST))

-include .env

test:
	vendor/bin/phing tests

cs:
	vendor/bin/phing cs-fix

cs-dry-run:
	vendor/bin/phing cs

c-inst:
	vendor/bin/phing composer
