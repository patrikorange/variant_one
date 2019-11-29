#!/bin/bash
set -e

mkdir -p .phalcon

phalcon serve --port=80

exec "$@"