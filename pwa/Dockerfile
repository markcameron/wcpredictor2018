# base image
FROM nginx:1.16.0-alpine

# Labels
LABEL xyz.kram.maintainer="Mark CAMERON <mark.cameron.dev@gmail.com>" \
    xyz.kram.os="Alpine" \
    xyz.kram.sourceurl="https://github.com/markcameron/wcpredictor2018"

# copy artifact build from the 'build environment'
COPY ./dist /usr/share/nginx/html

# copy the overwrite the nginx default config file with our own custom one
COPY ./default.conf /etc/nginx/conf.d/default.conf

# expose port 80
EXPOSE 80

# run nginx
CMD ["nginx", "-g", "daemon off;"]
