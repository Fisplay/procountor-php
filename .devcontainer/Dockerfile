# See here for image contents: https://github.com/microsoft/vscode-dev-containers/tree/v0.202.5/containers/php/.devcontainer/base.Dockerfile

# [Choice] PHP version (use -bullseye variants on local arm64/Apple Silicon): 8, 8.0, 7, 7.4, 7.3, 8-bullseye, 8.0-bullseye, 7-bullseye, 7.4-bullseye, 7.3-bullseye, 8-buster, 8.0-buster, 7-buster, 7.4-buster, 7.3-buster
ARG VARIANT="8.0-apache-bullseye"
FROM mcr.microsoft.com/vscode/devcontainers/php:0-${VARIANT}

# [Choice] Node.js version: none, lts/*, 16, 14, 12, 10
ARG NODE_VERSION="none"
RUN if [ "${NODE_VERSION}" != "none" ]; then su vscode -c "umask 0002 && . /usr/local/share/nvm/nvm.sh && nvm install ${NODE_VERSION} 2>&1"; fi

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo " \
    zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20200930/xdebug.so \n \
    xdebug.mode=debug \n \
    xdebug.start_with_request=yes \n \
    xdebug.client_port=9003 \n \
    xdebug.client_host=host.docker.internal \n \
    max_nesting_level=512 \n \
    " > /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -o /usr/local/bin/psysh https://psysh.org/psysh && chmod +x /usr/local/bin/psysh

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1
