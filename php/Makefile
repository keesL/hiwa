INSTDIR=/var/www/html/hiwa

.phony: installphp installcss install

none:
	echo "Not doing anything unless told what."

installphp: 
	cp *.php *.phplib ${INSTDIR}

installcss:
	cp *.css  ${INSTDIR}
	
install: installphp installcss
	
