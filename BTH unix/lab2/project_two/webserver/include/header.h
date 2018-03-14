#include <stdio.h>
#include <ctype.h>
#include <sys/types.h>
#include <netinet/in.h>
#include <sys/socket.h>
#include <unistd.h>
#include <stdlib.h>
#include <string.h>
#include <sys/stat.h>
#include <signal.h>  
#include <sys/wait.h> 
#include <sys/param.h> 
 
#define QUEUE_MAX_COUNT 100
#define BUFF_SIZE 1024
#define DIE(str) perror(str);exit(-1); //Eg: when socket handling fails, output error. 

#define SERVER_STRING "Server: myserver/1.0"
#define WEB_PATH "../www" //Notice: the path is based on the final executable file, instead of C file place.

