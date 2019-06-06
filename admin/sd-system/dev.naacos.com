server {
        listen 80;
        listen [::]:80;
	server_name dev.naacos.com;

	access_log		/mnt/data/sites/naacos.com/log/dev.naacos.com-access.log;
	error_log		/mnt/data/sites/naacos.com/log/dev.naacos.com-error.log;

	return 302 https://$server_name$request_uri;
}

server {
	listen 443 ssl http2;
	listen [::]:443 ssl http2;
	server_name dev.naacos.com;

        access_log              /mnt/data/sites/naacos.com/log/dev.naacos.com-access.log;
        error_log               /mnt/data/sites/naacos.com/log/dev.naacos.com-error.log;

	#include snippets/ssl-params.conf;

	ssl on;
	ssl_certificate		/etc/ssl/certs/wildcard.naacos.com.pem;
	ssl_certificate_key	/etc/ssl/private/wildcard.naacos.com.key;
#	ssl_client_certificate	/etc/ssl/certs/cloudflare.crt;
#	ssl_verify_client on;

        root /mnt/data/sites/naacos.com/dev/dev;
        index index.html index.htm index.php;

        location / {
                try_files $uri $uri/ =404;
		ssi on;
        }

	location ~* \.php$ {
		fastcgi_pass	unix:/run/php/php7.2-fpm.sock;
		include		fastcgi_params;
		fastcgi_param	SCRIPT_FILENAME		$document_root$fastcgi_script_name;
		fastcgi_param	SCRIPT_NAME		$fastcgi_script_name;
	}
}
