FROM nginx:1.25.3-alpine3.18-slim

COPY settings/default.conf /etc/nginx/conf.d/
WORKDIR /usr/share/nginx/public/
RUN touch /usr/share/nginx/public/index.php
