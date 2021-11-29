# php-blog

## docker-compose installation

### edit /etc/hosts
Add a line like
```
127.0.0.1 php-blog.local
```

### allow write access to compiled templates for the web server
```
chmod a+w var/templates/compiled
```

### run docker-compose
```
docker-compose up
```
