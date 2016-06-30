[![Build](https://img.shields.io/wercker/ci/wercker/docs.svg?maxAge=2592000)]()
[![License](https://img.shields.io/aur/license/yaourt.svg?maxAge=2592000)]()
[![Timer](https://img.shields.io/badge/Relace-V0.75-blue.svg)](https://github.com/Qti3e/PHPSocket/releases/tag/0.75)

# PHPSocket
Advanced PHP server-client platform to make real time web applications, based on the power of [WebSocket](https://en.wikipedia.org/wiki/WebSocket) and [vue.js](https://vuejs.org/)

Read [API Documention](http://qti3e.github.io/PHPSocket/docs/) for more details.

# Database
I'm using redis (most powerful NoSQL key-value store) in the server-side and iDb.js in client side

# How to run it?
First of what you need Redis and PHP.
After downloading repository you need to run ```index.php``` in cgi mode:
```
$ git clone https://github.com/Qti3e/PHPSocket.git
$ cd PHPSocket\server
$ php index.php
```
That's it!
# Client
Open ```client/app.html``` if it doesn't worked make sure that your host address is true in app.js line 22.

```#20:var host = "127.0.0.1",```

but you have to change it into the right IP address that's show on line 4 of server

```Listening on : 127.0.0.1:8085```

# Todo List
1. Encrypt client-server's data
