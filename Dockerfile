# Use the official PHP image as the base image
FROM php:7.4

# install mysql driver docker image
RUN docker-php-ext-installb mysqli

# Set the working directory within the container
WORKDIR /var/www/html

# Copy the PHP application files into the container
COPY . /var/www/html

# Expose the necessary port (e.g., 80 for HTTP)
EXPOSE 80

# Specify the command to run the PHP application
CMD ["php", "-S", "0.0.0.0:80"]