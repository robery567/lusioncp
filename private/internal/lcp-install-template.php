<?php
if(function_exists('apache_request_headers')) {
  $headers = apache_request_headers();
} else {
  $headers = $_SERVER;
}

if(array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
  $the_ip = $headers['X-Forwarded-For'];
} else if(array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
  $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
} else {
  $the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
}

$company_url = file_get_contents("https://www.lusioncp.me/lcpmain/apiservice.php?action=get_company_url&ip={$the_ip}");

$content = '
#!/bin/bash

#
# LusionCP Pre-Installation script
# Version: 1.7
#

#
# Currently supported OS:
#
#   FreeBSD 10, FreeBSD 9, FreeBSD 8
#

# Function for fetching the data
CLIENTPROC="' . $company_url . '"
LCPROOT="/root/lcp"
VERSION="uname -r | cut -c1"

download() {
    fetch --no-verify-peer "$1" -output="$2"
}

update_procent() {
    fetch --no-verify-peer "$CLIENTPROC?action=install_percent&percent=$1" -output="$LCPROOT/install/install.$1"
}

# Checking if FreeBSD or not
if [ "$(uname -s)" == "FreeBSD" ]; then
type="bsd"
fi

if [ "$VERSION" != "8" -a  "$VERSION" != "1" -a "$VERSION" != "9" ]; then
echo "Error: currently only FreeBSD 9 or 10 is supported"
exit 1
fi

# This makes the 1% of installation
# (originally for testing the API)
# and prepares the installation process
echo "export BATCH=yes" >> /root/.bash_profile
echo "export CLIENTPROC=\''.$company_url.'\'" >> /root/.bash_profile
echo "export DOWNLOAD=\''.$company_url.'/download/\'" >> /root/.bash_profile
mkdir lcp && cd lcp
mkdir tmp && chmod -R 0777 tmp
mkdir install
mkdir backup
touch setup.log
cd $LCPROOT/install
update_procent 1
cd $LCPROOT

cd $LCPROOT
fetch --no-verify-peer $DOWNLOAD/lcp-install-$type -output=lcp-install-$type
chmod +x lcp-install-$type
sh lcp-install-$type > $LCPROOT/setup.log
';
