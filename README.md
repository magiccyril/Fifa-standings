Fifa Standings
========================

Simple standings system for the Fifa video game.

1) Download
--------------------------------

### Clone the git Repository

If you want to use Git, run the following commands:

``` bash
    git clone http://github.com/magiccyril/Fifa-standings.git
```

### Download an archive file

Download an archive
(http://github.com/magiccyril/Fifa-standings/zipball/master).
Unpack it somewhere under your web server root directory and you're done.
The web root is wherever your web server (e.g. Apache) looks when you
access `http://localhost` in a browser.

2) Installation
---------------

Once you've downloaded it, installation is easy, and basically
involves making sure your system is ready for Symfony.

### a) Check your System Configuration

Before you begin, make sure that your local system is properly configured
for Symfony. To do this, execute the following:

``` bash
    php app/check.php
```

If you get any warnings or recommendations, fix these now before moving on.

### b) Install the Vendor Libraries

You need to download all of the necessary vendor libraries. Run the following:

``` bash
    php bin/vendors install
```

Note that you **must** have git installed and be able to execute the `git`
command to execute this script. If you don't have git available, install
it !

### c) Configuration

Then, you have to do some simple configuration. Run the following:

``` bash
    cp app/config/parameters.ini.dist app/config/parameters.ini
```

And change values according to your database and your mailling system.

``` ini
; app/config/parameters.ini
; These parameters can be imported into other config files
; by enclosing the key with % (like %database_user%)
; Comments start with ';', as in php.ini
[parameters]
    database_driver   = pdo_mysql
    database_host     = localhost
    database_port     =
    database_name     = symfony
    database_user     = root
    database_password =

    mailer_transport  = smtp
    mailer_host       = localhost
    mailer_user       =
    mailer_password   =

    locale            = en

    secret            = ThisTokenIsNotSoSecretChangeIt
```

### d) Create database

Final step: you have to create the database and the schema. Fortunately Symfony
will help you to do this. Run the following:

``` bash
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
```

### e) That's all folks !

Configure your web server, and congratulations! You're now ready to use Fifa Standings.

What's inside?
---------------
Fifa Standings is built with:

* **Symfony** - The core framework ([documentation](http://symfony.com/doc/current/))
* **Twitter Bootstrap** - Frontend toolkit. ([documentation](http://twitter.github.com/bootstrap/))
* **jQuery** - Adds some frontend enhancement and animation.
  ([documentation](http://docs.jquery.com/Main_Page))

Enjoy!
