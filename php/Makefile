INSTDIR=/var/www/html/hiwa

.phony: installphp installcss installimg install

none:
	echo "Not doing anything unless told what."

installphp: 
	cp *.php *.phplib ${INSTDIR}

installcss:
	cp *.css  ${INSTDIR}

installimg:
	cp *.png ${INSTDIR}
	
install: installphp installcss installimg
	
