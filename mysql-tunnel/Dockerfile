FROM alpine:latest

RUN apk add --update bash openssh-client && rm -rf /var/cache/apk/*

RUN mkdir -p /root/.ssh

COPY docker-entrypoint.sh /usr/local/bin/
RUN ["chmod", "+x", "/usr/local/bin/docker-entrypoint.sh"]

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 3306