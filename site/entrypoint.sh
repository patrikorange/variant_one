#!/bin/bash
set -e

mkdir -p .phalcon

phalcon serve

exec "$@"