# HIPO
HIPO, the first real time &amp; open source platform for programming contest!

# Run
#### Server
````
git clone https://github.com/XZBox/HIPO.git
cd HIPO\server
php index.php
````
#### Client
Open `HIPO\server\client\app` you can also run it in chrome app mode by following commands
```
chorme --app=file://$PATH/HIPO/server/client/app
```

# Console
##### What is it?
Console is a place like command line (really it is) and gives you ability to run some commands in server.
Don't be worry about security, you have to login before run any commands

##### How to use it?
just open `console\indes.html` then use following command to connect and login into server
````
connect [host] [port]
login '[username]' '[password]'
````

# Open source libraries
#### Server:
1. [PHP-Websockets](https://github.com/ghedipunk/PHP-Websockets)
2. [PHPSocket](https://github.com/xzbox/PHPSocket)
3. [credis](https://github.com/colinmollenhour/credis)

#### Client
1. [Vue.js](https://vuejs.org/)
2. [jQuery](https://jquery.org/)
3. [DASHGUM FREE](https://github.com/natuchasca/Dashgum)

#### Console
1. [JQuery Terminal Emulator Plugin](http://terminal.jcubic.pl/)

# Thanks
Thanks to [Mr. Montazeri] (http://toorajmontazeri.com) for helping us
