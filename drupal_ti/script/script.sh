#!/bin/bash
# @file
# Script to run the functional JavaScript tests via travis-ci.
# Borrowed from https://github.com/drupalcommerce/commerce/blob/8.x-2.x/.travis-simpletest-js.sh
# Thanks to Matt Glaman and others.

# Add an optional statement to see that this is running in Travis CI.
echo "running drupal_ti/script/script.sh"

export ARGS=( $DRUPAL_TI_SIMPLETEST_JS_ARGS )

if [ -n "$DRUPAL_TI_SIMPLETEST_GROUP" ]
then
        ARGS=( "${ARGS[@]}" "$DRUPAL_TI_SIMPLETEST_GROUP" )
fi


cd "$DRUPAL_TI_DRUPAL_DIR"
{ php "$DRUPAL_TI_SIMPLETEST_FILE" --php $(which php) "${ARGS[@]}" || echo "1 fails"; } | tee /tmp/simpletest-result.txt

egrep -i "([1-9]+ fail[s]?)|(Fatal error)|([1-9]+ exception[s]?)" /tmp/simpletest-result.txt && exit 1
exit 0
