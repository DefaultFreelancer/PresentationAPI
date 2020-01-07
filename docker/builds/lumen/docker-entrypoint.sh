#!/bin/sh
set -e

# If 1st argument is not php append command
if [ "$1" != "php" ]; then
	set -- php ~/.composer/vendor/bin/lumen "$@"
fi

exec "$@"
