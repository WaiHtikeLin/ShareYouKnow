# ShareYouKnow
ShareYouKnow is a multi-user knowledge sharing platform wrriten in Laravel(v6.18.25).
>Note: It's not a complete project. Many other features will be added on future commits.

## Current Features
- upload articles with a chosen category
- edit, delete uploaded articles
- like, comment and save the articles
- rate the article with five rating classes
- browse articles by categories
- real-time notifications
- view your uploaded and saved articles
- search articles by title
- view the average rating of an article

## Installation
- git clone https://github.com/WaiHtikeLin/ShareYouKnow.git projectname
- cd projectname
- composer install
- npm install
- php artisan key:generate to regenerate secure key
- create new database and edit .env file for DB settings
- php artisan migrate —seed
- edit .env file for APP configuration and Google API Configuration
- storage and bootstrap/cache directories should be writable
- php artisan storage:link
- php artisan serve

## Requirements
- See https://laravel.com/docs/6.x/installation#server-requirements
- Mysql
