FROM nginx:latest

COPY ./hosts/money.loc.conf /etc/nginx/conf.d/money.loc.conf

WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]