ATEDI
=========

# Download
Open your CMD and copy this line : 
```

git clone https://github.com/ndlaprovidence/Atedi.git
```

# Install
When download is complete, open your CMD 
and execute these commands :
```
cd atedi

composer install
```
(Composer is free to download at this link : https://getcomposer.org/download/)

# Create database

Start a DBMS like MySQL included into Wamp server (free to download at this link : http://www.wampserver.com/)

Then copy .env file to .env.local 
and update .env.local tu configure your database :
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/atedi

```
Replace db_user with : **root**

Replace db_password with : (let it blank)


Finaly, execute this line :
```
php bin/console doctrine:database:create
```

# Load database
There are some default datau that you can load into the database. Open your CMD in the Atedi directory and copy these lines :
```
php bin/console doctrine:migrations:migrate
```
```
php bin/console doctrine:fixtures:load
```

# Run
Once you've installed everything, execute this line in the atedi directory :
```
php -S localhost:8000 -t public
=======

```
You can access to your local server with localhost:8000

# Sign in
Next, you will have to connect with the default admin account.

* Email : admin@gmail.com

* Password : admin
