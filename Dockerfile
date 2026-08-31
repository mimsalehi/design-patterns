FROM php:8.3-cli-alpine

# Install system dependencies and build essentials
RUN apk update && apk add --no-cache \
    bash \
    git \
    curl \
    unzip \
    linux-headers

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Set default command
CMD ["bash"]
