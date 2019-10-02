FROM silarhi/php-apache:7.3-symfony

RUN apt-get update -qq && \
    curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    apt-get install -y nodejs && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    npm install -g yarn && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#TODO: créer utilisateur associé au groupe www-data avant de faire la copie et l'installation des dépendances.
ADD . /app/
# fix sqlite db access right (db test)
RUN chmod -R 777 src/bdd

RUN composer install
RUN yarn
RUN yarn build
RUN chown -R www-data:www-data /app

