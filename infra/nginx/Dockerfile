FROM nginx:1.25.3-alpine3.18-slim

RUN apk add openssl-dev~=3.1.4-r1

COPY settings/default.conf /etc/nginx/conf.d/
WORKDIR /usr/share/nginx/public/
RUN touch /usr/share/nginx/public/index.php
