# php-blog

## Docker-compose installation

### Edit /etc/hosts
Add a line like
```
127.0.0.1 php-blog.local
```

### Allow write access to compiled templates for the web server
```
chmod a+w var/templates/compiled
```

### Run docker-compose
```
docker-compose up
```
