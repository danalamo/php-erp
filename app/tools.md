

https://docs.bitnami.com/aws/infrastructure/nginx/administration/control-services/

sudo /opt/bitnami/ctlscript.sh restart apache
sudo /opt/bitnami/ctlscript.sh restart php-fmp
sudo /opt/bitnami/ctlscript.sh restart mysql

validators
- https://validator.w3.org/
- http://jigsaw.w3.org/css-validator/
- https://paragonie.com/blog/2015/06/preventing-xss-vulnerabilities-in-php-everything-you-need-know

http://54.84.144.132/

/opt/bitnami/apache2/logs








# Capture the value of mykey in the query string
RewriteCond "%{QUERY_STRING}"  "(.*(?:^|&))mod_rewrite=([^&]*)&?(.*)&?$"
RewriteCond "%2"               !=not-so-secret-value
RewriteRule "(.*)"             "-" [F]




