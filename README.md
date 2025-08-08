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
    labels:
      - "csp_report.url=127.0.0.1:8080"
    volumes:
      - ../csp:/var/www/html/logs
```
