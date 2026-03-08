# Horwood PHP CSP report tool

This will log all CSP reports to a log file

## Running it

There is an example compose file in the docker directory, this will start a container on port 8080 and mount `csp` to `/var/www/html/logs`

```
---
services:
  csp-report:
    image: mhzawadi/csp-report
    ports:
      - "8080:8080"
    container_name: csp-report
    environment:
      - TZ=Europe/London
    volumes:
      - ../csp:/var/www/html/logs
```

## Testing

There is a test script that will get this to log, just run `./test.sh`

```bash
curl -i -X POST http://127.0.0.1:8080 \
  -H "application/reports+json" \
  --data '{"csp-report":{"document-uri":"https://www.horwood.biz","referrer":"https://www.horwood.biz/","violated-directive":"docker health check","effective-directive":"docker health check","original-policy":"docker health check","disposition":"docker health check","blocked-uri":"https://www.horwood.biz/","status-code":200,"script-sample":""}}'
```
