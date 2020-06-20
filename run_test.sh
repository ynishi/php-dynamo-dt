#!/bin/sh

docker run --rm -it -v $(pwd):/code --workdir=/code phpunit5
docker run --rm -it -v $(pwd):/code --workdir=/code phpunit7
