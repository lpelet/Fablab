CFLAGS=$(shell mysql_config --cflags)
LIBS=$(shell mysql_config --libs)

open_door: open_door.c
	gcc -o open_door open_door.c -lpaho-mqtt3c -lpaho-mqtt3a $(CFLAGS) $(LIBS)