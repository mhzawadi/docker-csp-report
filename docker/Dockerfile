FROM alpine:3.21
LABEL org.opencontainers.image.authors="matt@horwood.biz"

# Install required deb packages
RUN apk update && apk upgrade && \
    apk add gnupg unit-php84 php84-json php84 php84-phar curl git \
    && mkdir -p /var/www/html/ \
    && mkdir -p /run/nginx \
    && rm -f /var/cache/apk/*; \
    [ -f /usr/bin/php ] && rm -f /usr/bin/php; \
    ln -s /usr/bin/php84 /usr/bin/php;

COPY docker/config /config

WORKDIR /var/www/html
COPY src/public/csp-report.php .

EXPOSE 8080
ENTRYPOINT ["/config/start.sh"]
CMD ["unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]

## Health Check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s \
  CMD curl -i -X POST http://127.0.0.1:8080 \
  -H "application/reports+json" \
  --data '{"csp-report":{"document-uri":"https://www.horwood.biz","referrer":"https://www.horwood.biz/","violated-directive":"docker health check","effective-directive":"docker health check","original-policy":"docker health check","disposition":"docker health check","blocked-uri":"https://www.horwood.biz/","status-code":200,"script-sample":"docker health check"}}' || exit 1
