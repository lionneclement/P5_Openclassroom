# P5_Openclassroom
Create your first blog in php
## Prerequisite 
1) Download Wamp, Xampp or Lamp

## Clone
1) Go to www directory.
2) Make a clone with `git clone https://github.com/lionneclement/P5_Openclassroom.git`
3) Init composer with `composer init` 
4) With the sql file create your database in phpmyadmin
5) Add in the root of the project a new file .env with 
    ```
    DB_HOST="localhost"
    DB_NAME="your name"
    DB_USER="your user"
    DB_PASSWORD="your password"
    ```
   Default password and user: 'root','' or 'root','root'
6) In apache change httpd-vhosts.conf from
    ```
    DocumentRoot "${INSTALL_DIR}/www"
    <Directory "${INSTALL_DIR}/www/">
    ```
    To
    ```
    DocumentRoot "${INSTALL_DIR}/www/P5_Openclassroom/src/public"
    <Directory "${INSTALL_DIR}/www/P5_Openclassroom/src/public/">
    ```
 Normally everything works, if you have a error send me an mail to lionneclement@gmail.com or create a issue