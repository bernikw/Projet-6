# Projet SnowTricks
---

## Badge Codacy
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/749d37ed748a4a2a806697de1f2d5616)](https://www.codacy.com/gh/bernikw/Projet-6/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=bernikw/Projet-6&amp;utm_campaign=Badge_Grade)

## SnowTricks
Project 6 of PHP/Symfony course for OpenClassrooms

This is a community blog related to Snowboard tricks. Users can manage tricks once they are created their account and log in. It is made with Symfony 6.1 framework without extern bundles.

## Build with

* Symfony 6.1
* Bootstrap 5.0
* Composer
* Twig

## Getting started

### Installation

1. Git clone the project.

https://github.com/bernikw/Projet-6.git

2. Install libraries with https://getcomposer.org/

composer install

3. Create database

- Configure database in .env file end serveur SMTP

- Create database: 

 symfony console doctrine:database:create

-  Create database structure:

symfony console make:migration

- Insert fixtures data:

symfony console doctrine:fixtures:load


4. Launch the site
 * symfony serve
