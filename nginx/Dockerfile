# nginx/Dockerfile
FROM nginx:latest

# Utwórz folder snippets
RUN mkdir -p /etc/nginx/snippets

# Skopiuj plik fastcgi-php.conf
COPY fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

# Skopiuj konfigurację NGINX
COPY nginx.conf /etc/nginx/nginx.conf
COPY conf.d /etc/nginx/conf.d
