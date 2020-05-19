rsync  -arvz --exclude "config.php" --exclude "admin/config.php"  --exclude ".git"   -e "ssh -i  ~/Downloads/id_rsa\(3\)"  ./  ubuntu@avhair.com:/var/www/html/opencart/

