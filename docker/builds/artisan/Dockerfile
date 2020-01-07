FROM code.milivojeivic.com/php-fpm:latest
LABEL description="ALA Corpus Lumen Cli"

# RUN apt update -y && apt install -y --no-install-recommends \
#     git \
#     subversion \
#     mercurial \
#     bash \
#     patch \
#     make \
#     zip \
#     unzip

# RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
# 			php composer-setup.php --install-dir="/usr/local/bin/" --filename=composer --quiet && \
# 			rm composer-setup.php

WORKDIR /app

COPY docker-entrypoint.sh /docker-entrypoint.sh

ENTRYPOINT ["/bin/sh", "/docker-entrypoint.sh"]

CMD ["php", "./artisan"]
