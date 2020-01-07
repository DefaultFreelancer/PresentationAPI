# ALA Corpus API

## General

Development and whole production is setup to work on containers. We are building and providing our own Docker images.

> In development we are using a few images from Docker hub but in production they're going to be omitted or migrated to our registry before use.

Milivojeivic Private Registry is hosted on `https://code.milivojeivic.com/`.

To use our registry you need to login:

```bash
docker login -u username code.milivojeivic.com
```

> Get the password from the project lead.

## Setting up the environment

The is a multi container environment which enables you to develop the API while keeping the other services as they are. However, if needed you can adjust your `docker-compose.yml` in order to mount some local data to it and adjust other needed settings.

1. Configure

Set all the needed configuration files, create folders, etc.. This will create `docker-compose.yml` file from `docker-compose.template.yml`.

```bash
make configure
```

2. Initiate the project

Start the containers, install dependencies and setup API.

```bash
make init
```

3. Use it and start developing

Try using the API via browser [http://127.0.0.1](http://127.0.0.1) or point your RESTfull client to `http://127.0.0.1/api/`.

> Default user info:
>  * Username: -
>  * Password: -

## Docker usage

Since this is a multi-container setup and if you're running any of multiple containers services with scale parameter you should always start containers with:

```bash
make up
```

When container are running you can use standard `docker` and `docker-compose` commands. Just don't use `docker-compose up` because it will run each service with one container.

### Using Composer

You can run and use composer with dedicated _composer_ script:

```bash
./composer.sh [ARGS...]
```

### Using Lumen Console

You can run ad use Lumen Console with dedicated _lumen_ script:

```bash
./lumen.sh [ARGS...]
```

### Using Artisan Console

You can run ad use Artisan Console with dedicated _artisan_ script:

```bash
./artisan.sh [ARGS...]
```

## Containers

For the development the whole setup is based on `docker-compose.template.yml` which can be adjusted to your needs. You can add services, adjust ports, adjust settings, volumes, etc. Whatever you need to be efficient at your work.

> Refer to `docker-compose.*` file for up to date information.

## Lumen PHP Framework

### Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

### Working with seeders and database

#### Migrate and seed the data

```bash
./composer.sh dumpautoload && ./artisan.sh migrate:fresh --seed
```
