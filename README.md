# News Blog

[TOCM]

[TOC]

#Requirements

##PHP >= 7.3.11

[download](https://www.php.net/downloads.php#v7.3.11)

Finished downloading extract all content

##Composer 1.9

[How to install](https://getcomposer.org/download/)

Indicate the PHP folder to finish the installation

##Laravel 7.x

[How to install](https://laravel.com/docs/7.x#installation)

#Download

[Github Download](https://github.com/ciuffetelli/NewsBlog/archive/master.zip)

##Extract the content

Choose a location with simple access. `example c:\project`

#Installation

All commands must be executed in Prompt Comand at the project folder.

##Create autoload

```
composer dump-autoload
```

##Install database tables

```
php artisan migrate:refresh --seed
```

#Execute

All commands must be executed in Prompt Comand at the project folder.

##Start server
```
php artisan serve
```

##Open

[home](http://127.0.0.1:8000)

###Administrador Login

user: `admin@dailynews.com`
password: `102030`

#Suporte

[seufetelli@gmail.com](mailto:seufetelli@gmail.com)

#Credits

Daniel Ciuffetelli
seufetelli@gmail.com
