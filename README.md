# Recipe Book

This is just a small project I've set up in 2 days,
just to experiment how quickly I was able to set up a
simple CRUD application using:

* Doctrine ORM for models
* Twig for views
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
