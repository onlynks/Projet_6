Install the application
========================

You need to install Composer if you don't already get it.  
First, create a Database and use the file DatabaseFile.sql to fill it. It already contain some data (tricks and categories).*

-----------------

Once the database is installed, you can clone the project in your directory.

## 1th step: Parameters

Go to the app/config/parameters file and fill those fields accordind to your settings:

``` parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: p6
    database_user: root
    database_password: null
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
```

If you need more informations about how to configure this fail for the mail sending check here[mail sending](https://symfony.com/doc/3.4/email.html) and if u are using gmail check here[Gmail](https://symfony.com/doc/3.4/email/gmail.html)
    
## 2th step: Composer dependencies

Do the command composer update that will install all the depencies.

_(You can delete the SQL File cloned at the same time as the project)_

# That's it! You can now use the application!


