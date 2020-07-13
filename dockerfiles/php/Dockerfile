FROM node:12.18.1-slim AS node

from indava/php:7.3
COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /opt /opt
