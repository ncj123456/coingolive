
**Join our slack group:**
http://slack.coingolive.com

## Installation Using docker-compose
```bash
$ git clone https://github.com/CoinGoLive/coingolive.git
$ cd coingolive/
$ docker-compose up
```
**You can visit http://localhost/setup.php to complete setup.**

## Writing Permission

 - **public/assets/img/coin/** - images of cryptocurrencies, cron saves the images
 - **public/assets/moedas.json** - list of all cryptocurrencies, used in the search options, updated file via cron
 - **log/** - error logs

# Config

 - **define.php** - configuration file (database connection)
 - **app/route.php** - route of the application, call the controllers

# Crons

 - **php console/execute.php coin-change** update data exchanges prices, data used in tool "*Cryptocurrency Change in 24h*"
 - **php console/execute.php moeda** -- updates all cryptocurrencies data,  data used in tools "*Max Price*" and "*All-Time High*"

scheduling cron:
```bash
# m h  dom mon dow command
*/5 * * * * /usr/bin/php /var/www/coingolive/console/execute.php moeda
* * * * * /usr/bin/php /var/www/coingolive/console/execute.php coin-change
```
![alt text](https://raw.githubusercontent.com/CoinGoLive/coingolive/master/screenshot.png)
![alt text](https://raw.githubusercontent.com/CoinGoLive/coingolive/master/screenshot1.png)
![alt text](https://raw.githubusercontent.com/CoinGoLive/coingolive/master/screenshot2.png)
Free Theme:  Material Kit  Bootstrap 4
https://demos.creative-tim.com/material-kit/index.html