      COMPONENT = so-o
        VERSION = 1.0
       REVISION = 1

       SOO_SRCS = So-o.php Object.php OL.php Hello.php Once.php Application.php Responder.php
   
   LICENSE_FILE = LICENSE

      TAR_FILES = $(LICENSE_FILE) $(SOO_SRCS) Makefile
      ZIP_FILES = $(TAR_FILES)
 
#.SILENT:

project:

clean:

wipe:	clean
	rm -f $(COMPONENT).tar.gz $(COMPONENT).zip

tar:
	tar -zcf $(COMPONENT).tar.gz $(TAR_FILES)

zip:
	zip $(COMPONENT).zip $(ZIP_FILES)
