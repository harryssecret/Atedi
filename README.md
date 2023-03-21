# Atedi
[![forthebadge](https://forthebadge.com/images/badges/powered-by-black-magic.svg)](https://forthebadge.com)

Atedi is a software made to manage quotation for IT companies. It was made by Dylan Hochet and Remi Leyssenne, but this fork adds some features such as compatibility with Dolibarr.

# Table of Contents
1. [Installation](#installation)
    1. [With Docker](#installation-with-docker-recommended)
    2. [Manual](#manual-installation)

# Installation

## Installation with Docker (recommended)
A docker image will be provided when the project will be updated to the latest docker version. Please follow the issue related to it.

## Manual installation
First, make sure to have `php8.1` installed with `curl`, and `xml` extensions.

```bash
git clone https://github.com/ndlaprovidence/Atedi.git
cd atedi
composer install
```

### Database creation
First, make sure to have MySQL installed on your machine and is up running.

Copy .env file to .env.local and update them with your database credentials :
```
DATABASE_URL=mysql://changeme:changeme@127.0.0.1:3306/atedi
```

```sql
CREATE DATABASE atedi;
CREATE USER 'atediUser'@'localhost' IDENTIFIED BY 'changethispass';
GRANT ALL PRIVILEGES ON atedi.* TO 'atediUser'@'localhost';
FLUSH PRIVILEGES; 
``` 
or use `composer bin/console d:d:c`

Then, apply migrations :
```bash
php bin/console doctrine:migrations:migrate
```

Atedi comes with some test data that you can load to play with the software, you just need to run the following command.
```bash
php bin/console doctrine:fixtures:load
```

### Launch it
Once everything is installed, use the built in php dev server (not recommended for production, use caddy, nginx or apache) :
```
php -S localhost:8000 -t public
```
Then, login with the defaults credentials : `admin@gmail.com` / `admin`.
