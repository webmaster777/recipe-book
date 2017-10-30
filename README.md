# Recipe Book

This is just a small project I've set up in 2 days,
just to experiment how quickly I was able to set up a
simple CRUD application using:

* [PHP-DI](http://php-di.org/) for dependency injection
* [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html) for models
* [Twig](https://twig.symfony.com/) for views
* Handwritten controllers

## Requirements
* php (I built this using 7.0)
* sqlite extension/lib
* [composer](https://getcomposer.org)

## Installation

1. clone the repo
2. run `composer install --no-dev`
3. `vendor/bin/doctrine orm:schema-tool:create`
4. run `./run.sh` and point your browser to `http://localhost:9901/`

## Features
1. List of recipes
2. CReate, Update and Delete recipes + cooking steps
3. Search recipes (by title)

## What could be next?
* [ ] use slim for routing?
* [ ] a view action
* [ ] better handling of cooking steps / clientside additions
