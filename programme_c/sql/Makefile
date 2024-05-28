CFLAGS=$(shell mysql_config --cflags)
LIBS=$(shell mysql_config --libs)

read_table: read_table.c
	gcc -o read_table read_table.c $(CFLAGS) $(LIBS)

update_status_machine : update_status_machine.c
	gcc -o update_status_machine update_status_machine.c $(CFLAGS) $(LIBS)

check_uid: check_uid.c
	gcc -o check_uid check_uid.c $(CFLAGS) $(LIBS)