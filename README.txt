To create your own fiction bot:

1) Create a twitter account with the name you want for your character/bot.
2) Register as an app with this account on dev.twitter.com
3) Generate a set of keys on dev.twitter.com. Make sure the account is set for read/write or read/write/direct messages 
4) Change the default keys.php file to your real keys
5) Upload directory to a web server.
6) Manually trigger by loading bot.php or set a cron job
7) Set cron to run bot.php every minute.
8) If bot.php cannot find random.txt, change $file to an absolute path