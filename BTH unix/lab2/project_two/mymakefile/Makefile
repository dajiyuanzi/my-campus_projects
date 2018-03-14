all: ./server

./server: ./objects/server.o
	gcc -Wall ./objects/server.o -o ./server

./objects/server.o: ./src/server.c ./include/header.h ./config.h
	gcc -c -Wall ./src/server.c -o ./objects/server.o

clean:
	rm -rf ./objects/*.o ./server
