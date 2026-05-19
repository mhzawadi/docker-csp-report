FROM alpine:3.23
LABEL org.opencontainers.image.authors="matt@horwood.biz"

# Install required deb packages
RUN apk update && apk upgrade && \
    apk add gnupg nginx php84-fpm php84-json php84 php84-phar curl git \
    && mkdir -p /var/www/html/ \
    && mkdir -p /run/nginx \
    && rm -f /var/cache/apk/*; \
    [ -f /usr/bin/php ] && rm -f /usr/bin/php; \
    ln -s /usr/bin/php84 /usr/bin/php; \
    mkdir /var/www/html/logs;

COPY docker/config /config
RUN cp /config/php.ini /etc/php84/php.ini && \
    cp /config/php-fpm.conf /etc/php84/php-fpm.conf && \
    cp /config/php_fpm_site.conf /etc/php84/php-fpm.d/www.conf && \
    cp /config/nginx_site.conf /etc/nginx/http.d/default.conf;

WORKDIR /var/www/html
COPY src/public/* .

EXPOSE 8080
ENTRYPOINT ["/config/start.sh"]
CMD ["nginx", "-g", "daemon off;"]

## Health Check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s \
  CMD curl -i -X POST http://127.0.0.1:8080 \
  -H "application/reports+json" \
  --data '{"csp-report":{"document-uri":"https://www.horwood.biz","referrer":"https://www.horwood.biz/","violated-directive":"docker health check","effective-directive":"docker health check","original-policy":"docker health check","disposition":"docker health check","blocked-uri":"https://www.horwood.biz/","status-code":200,"script-sample":"docker health check"}}' || exit 1
