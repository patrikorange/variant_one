FROM phalconphp/ubuntu-16.04:php-7.2

RUN apt-get update \
 && apt-get install -y --no-install-recommends php7.2-sqlite3 \
 && rm -rf /var/lib/apt/lists/*

RUN wget https://github.com/phalcon/phalcon-devtools/archive/v3.4.3.tar.gz \
 && tar xfz v3.4.3.tar.gz \
 && rm -f v3.4.3.tar.gz \
 && mv phalcon-devtools-3.4.3 /usr/src/phalcon-devtools \
 && ln -sf /usr/src/phalcon-devtools/phalcon /usr/local/bin/phalcon

WORKDIR /var/www/html

CMD phalcon migration run

CMD phalcon serve --port=80