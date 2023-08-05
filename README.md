# Login form & Limited Api login 

<h2>Icon Creations - Backend Task</h2>

Login form:- the scenario will be as follows
- if the user tries to enter his password 3 times wrong, an error message should say try again after 30 sec.
- if he tries again with a correct password for sure pass him, otherwise, the account should be blocked.

- List the users in a simple table with indexing two columns and order by both indexes

Also develop a simple postman API, to login the user from just two devices at the same time, so that he can't login from a third device.
If he tries to login from a third device, return a message that says "You're logged in from two devices", otherwise log him in normally.

## Framework

    Laravel - V.^10.10

## Packages And Main dependancies Used
<pre>
    <ul>
        <li>php              : ^8.1</li>
        <li>laravel/framework: ^10.10</li>
        <li>laravel/ui       : ^4.2</li>
        <li>tymon/jwt-auth  : ^2.0</li>
        <!-- <li>darkaonline/l5-swagger  : ^8.5</li> -->
    </ul>
</pre>

## Project Environment
<pre>
<code> copy .env.example .env</code>
set Your database local Config.,and set credentials to your Docker Config.
For Example:
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=homestead
    DB_USERNAME=homestead
    DB_PASSWORD=homestead
</pre>

## deployment

   after copping .env file and seeting your Database Credentials

   1- install composer with required dependancies
   
<pre><code>composer install</code></pre>

2- run npm install & npm run dev
    for using dashboard ui
   
<pre><code>run npm install & npm run dev</code></pre>

2- build and fill database 
   
<pre><code>php artisan migrate --seed</code></pre>

3- Serve Project on your port
   
<pre><code>php artisan serve --port=1234</code></pre>

## Users Route
    {APP_URL}/users

### Test User
    Email   : test@example.com
    Password: 123456
    
## Api Swagger Documentation Route
    --

## Api link
    {APP_URL}/api
