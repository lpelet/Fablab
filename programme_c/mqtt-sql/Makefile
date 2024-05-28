CFLAGS=$(shell mysql_config --cflags)
LIBS=$(shell mysql_config --libs)

active_machine: active_machine.c
	gcc -o active_machine active_machine.c -lpaho-mqtt3c -lpaho-mqtt3a $(CFLAGS) $(LIBS)