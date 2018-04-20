Install the application
========================

You need to install Composer if you don't already get it.  
First, create a Database and use the SQL code fil it. It already contain some data (tricks and categories).*

-----------------

Once the database is installed, you can clone the project in your directory.

## 1th step: Parameters

Go to the app/config/parameters file and fil those fields accordind to your settings:
    database_host:  database_port:  database_name:  database_user:  database_password:  mailer_transport:  mailer_host:  mailer_user:  mailer_password:
    
If you need more informations about how to configure this fail for the mail sending check this link:[mail sending](https://symfony.com/doc/3.4/email.html) and if u are using gmail check here:[Gmail](https://symfony.com/doc/3.4/email/gmail.html)
    
## 2th step: Composer dependencies

Do the command composer update that will install all the depencies.

_(You can delete the SQL File cloned at the same time as the project)_

# That's it! You can now use the application!


