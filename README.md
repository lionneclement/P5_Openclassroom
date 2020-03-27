# P5_Openclassroom

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/44ba56a099a5428f96e22bcefa2c00c1)](https://app.codacy.com/manual/lionneclement/P5_Openclassroom?utm_source=github.com&utm_medium=referral&utm_content=lionneclement/P5_Openclassroom&utm_campaign=Badge_Grade_Settings)

Create your first blog in php
## Prerequisite 
1) Download Wamp, Xampp or Lamp

## Clone
1) Go to www directory.
2) Make a clone with `git clone https://github.com/lionneclement/P5_Openclassroom.git`
3) Init composer with `composer init` 
4) With the p5.sql file create your database in phpmyadmin

   By default a user was created with email=admin@gmail.com and password=azertyuiopqsd
5) Add in the root of the project a new file .env with 
    ```
    DB_HOST="localhost"
    DB_NAME="your name"
    DB_USER="your user"
    DB_PASSWORD="your password"
    RECAPTCHA="your number"
    ```
   Default password and user: 'root','' or 'root','root'

   For the Recaptcha i use v2 Checkbox.
   [Recaptcha documentation](https://developers.google.com/recaptcha/docs/display#automatically_render_the_recaptcha_widget)

   Don't forget to change the code to html.

6) Move the "Vendor\twbs\bootstrap\dist" folder in the "src\public" folder
7) In apache change httpd-vhosts.conf from
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
