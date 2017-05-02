# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)
<br>
<code>$ composer install</code>     
<code>$ cp .env.example .env</code>     
check .env      
<code>$ php artisan key:generate</code>     
<code>$ php artisan migrate --seed</code>           
<code>$ cp storage/app/config_backup.json storage/app/config.json</code>      
<code>$ sudo chmod 755 -R ../web/</code>      
<code>$ sudo chmod o+w -R storage/</code>       
<code>$ sudo vim /etc/apache2/sites-available/web.conf</code>     
```sh
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/web/public

    <Directory /var/www/html/web>
        AllowOverride All
    </Directory>
```
<code>$ sudo a2dissite 000-default.conf</code>      
<code>$ sudo a2ensite web.conf</code>     
<code>$ sudo a2enmod rewrite</code>     
<code>$ sudo service apache2 restart</code>     