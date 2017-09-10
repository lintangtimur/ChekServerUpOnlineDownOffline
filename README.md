# ChekServerUpOnlineDownOffline
check server or domain is online or down

## USAGE
1. Edit conf.json
2. If you want add new server, place it into "key" server or port
```json
  {
    "Description" : [
      "Make with Love @stlintangtimur"
    ],
    "server" : [
      "sintak.unika.ac.id",
      "unika.ac.id",
      "google.com",
      "sgp-1.valve.net"
    ],
    "port" :
      {
        "telnet" : 21,
        "ssh" : 22,
        "http" : 80,
        "ssl" : 443,
        "mysql" : 3306
      }
  }

```
3. check server online with code below
```php
$srv = new Server();
$srv->addServer('conf.json')->parse();
$srv->updown();
```
4. if you want check open port `$srv->checkOpenPort();`

## Contributon
Contribution is welcome, open
[Pull Request](https://github.com/lintangtimur/ChekServerUpOnlineDownOffline/pulls)

## Issue
If have any issue please make it in here
[Create New Issue](https://github.com/lintangtimur/ChekServerUpOnlineDownOffline/issues)

# LICENSE
MIT License

Copyright (c) 2017 stelin

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
