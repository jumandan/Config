PHP=/usr/bin/php
DEST := $(dir $(lastword $(MAKEFILE LIST)))
PHPUNIT=${DEST}../bin/phpunit
TESTLIST:=$(wildcard ${DEST}*Test.php)

test: $(TESTLIST:.php=.tested)

%.tested: %.php
	${PHP} ${PHPUNIT} $<
