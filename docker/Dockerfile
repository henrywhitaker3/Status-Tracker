FROM linuxserver/nginx
LABEL maintainer=henrywhitaker3@outlook.com

ENV CHECK_INTERVAL=60
ENV CHECK_TIMEOUT=10

COPY . /site
COPY ./docker/root /

EXPOSE 80 443

VOLUME ["/run"]
VOLUME ["/config"]
