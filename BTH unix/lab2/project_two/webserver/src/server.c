//Notice: path of include is still based on the C file position for relative path, as it is firstly pre-compiled before the C file is compiled.
#include "../include/header.h"
#include "../config.h"

//inspect the char input of port num is of integer
int check_portnum(char *p) {
    while (*p) {
        if (*p < '0' || *p > '9')
            return 0; //not a integer num and false
        p++;//next char
    }
    return 1;
}

//Signal func will call this func to handle zombie child-process
void killzom(int signo) {
    int status;
    while (waitpid(-1, &status, WNOHANG) > 0); //WNOHANG: tell waitpid if there are no child-process which has exited, dont block.
}

//Responses of HTTP request
void rep_code(int client_fd, int code, char *message, int method){
    char buf[BUFF_SIZE];
    memset(&buf, 0, sizeof(buf));
    sprintf(buf, "HTTP/1.1 %d %s\r\nServer: %s\r\nContent-Type: text/html;charset=utf-8\r\nConnection: close\r\n\r\n", code, message, SERVER_STRING);
    write(client_fd, buf, strlen(buf));

    if ( code != 200 && method == 1 ){ //if head method, no body of html and only HTTP header can be returned.
        memset(&buf, 0, sizeof(buf));
        sprintf(buf, "<h2>%d %s</h2>", code, message);
        write(client_fd, buf, strlen(buf));
    }
    
    return ;
}

//MAIN START!!!
int main(int argc, char* argv[])
{
    /* define file descriptor */
    int server_fd = -1;
    int client_fd = -1;

    /* setup socket struct*/
    int port = DEFAULT_PORT;
    struct sockaddr_in client_addr;
    struct sockaddr_in server_addr;
    socklen_t client_addr_len = sizeof(client_addr);

    char buf[BUFF_SIZE];
    char recv_buf[BUFF_SIZE]; //Size can prevent too long url
    int hello_len = 0;
    char path_head[BUFF_SIZE] = WEB_PATH;
    char web_path[BUFF_SIZE];
    int i; // temp in loop
    pid_t pid;
    int daemon_on = 0; //0 off, 1 on
    int method = 1; //HTTP method type (GET or HEAD), 1 GET; 0 HEAD

    //Handle the input of GCC program execution
    if (argc > 1) {
        int i;
        for (i = 1; i < argc; i++) { //the array start from 0, so use < instead of <=
            if (strcmp(argv[i], "-h") == 0) {
                printf("Option Help\n(Full path of WWW web directory for Daemon running: %s)\n-h: Print help text\n-p N: Listen to port number\n-d: Run as a daemon\nConfig: In webserver/config.h, configure the default port, doc path and method.\n", WWW_PATH);
                if (argc == 2)
                    return 0;
            }
            else if (strcmp(argv[i], "-p") == 0 && (i + 1) < argc && check_portnum(argv[i + 1]) == 1 ) { //input of port num after -p must be inspected as integer
                i++;//next imput is port num
                port = atoi(argv[i]);
                printf("Listening to port number: %d\n", port);
            }
            else if (strcmp(argv[i], "-d") == 0) {
                //printf("Daemon is running!!!\n");
                daemon_on = 1;
                
                //the full path of WWW drectory when Daemon runs.
                memset(&path_head, 0, sizeof(path_head));
                sprintf(path_head, WWW_PATH);
            }
            else {
                printf("Wrong Input!!!\nUsage: %s <-h/-d/-s>\n Or %s -p <port>\n", argv[0], argv[0]);
                return 3;
            }
        }
    }
    else {
        printf("Default Configuration!!!\n");
    }

    //Daemon
    //As this program is newly born process, it cannot be the header of group process. As only header process can contact terminal, so it is not necessary to use 2 fork() to prevent accidential interaction with ternimal.
    //However, 2 fork() more safe. 
    if (daemon_on == 1) {
        //ingnoring signal can let child not become zombie, when parent process dont wait to collect child.
        if (signal(SIGCHLD, SIG_IGN) == SIG_ERR ) {
            printf("Cant ignore signal in init_daemon.");
            exit(1);
        }
        if ( (pid = fork()) > 0 )
            exit(0);//Parent process ends
        else if (pid < 0) {
            perror("fail to fork1");
            exit(1); // fail to firstly fork
        }
        //first child process continue the following
        setsid();// let fist child process become a leader group process and the leader of new session and cut contact and control of old session, terminal and process group. Notice: header process cannot use setsid.
        if ( (pid = fork()) >0 )
            exit(0);//end first child. As its parent ignores signal and doesnt wait, it is collected by init and not to be zombie 
        else if (pid < 0)
            exit(1);//fork fail

        //Second child process continues
        //second child is not group leader as son of first child (only group leader can contact terminal), so this eliminates accident to contact any terminal to ensure itself as daemon in background

        //Print PID of Daemon
        //Notice: print before stream descriptor closed or no way to cotact any terminal. 
        //In Daemon, if print() after close descriptor, as all connection to terminal and stream is cut after close descriptor, printed txt will be sent to
        printf("Daemon PID %d\n", getpid());

        // Close opened file descriptor. No matter what process, at least 3 standard streams must open (stdin 0, stdout 1, and stderr 2). Close them for no output for Daemon security.
        for (i = 0; i < getdtablesize(); ++i) 
            close(i);

        chdir("/");// change running directory to / root. If not changed root file, its ppid is not 1 and this may not be as one Daemon process.
        umask(0);// reset the file permission-code

    }//In 2nd child process(grandson), continue following handling

    //Run request handling
    /* create a socket */
    server_fd = socket(AF_INET, SOCK_STREAM, 0);
    if (server_fd == -1) {
        DIE("socket"); //defined macros
    }
    memset(&server_addr, 0, sizeof(server_addr));
    /* setup socket struct*/
    server_addr.sin_family = AF_INET;
    server_addr.sin_port = htons(port);
    server_addr.sin_addr.s_addr = htonl(INADDR_ANY);

    /* bind socket to the port */
    if (bind(server_fd, (struct sockaddr *)&server_addr, sizeof(server_addr)) < 0) {
        DIE("bind");
    }

    /* start socket listening for the request from client */
    if (listen(server_fd, QUEUE_MAX_COUNT) < 0) {
        DIE("listen");
    }

    //call child-process handler for the child-process which handles request. In BSD, only parent clean zombie.
    signal(SIGCHLD, killzom);

    //another way to clean zombie:
    //Dont wait for child and let init-process clean
    /*if(daemon_on==0){//This may be done when init Daemon
        if (signal(SIGCHLD, SIG_IGN) == SIG_ERR ) {
        printf("Cant ignore signal");
        exit(1);
        }
    }*/
    

    while (1) {
        /* accept request from client */
        client_fd = accept(server_fd, (struct sockaddr *)&client_addr, &client_addr_len);
        if (client_fd < 0) {
            DIE("accept");
        }
        //printf("accept a client\n");
        //printf("client socket fd: %d\n", client_fd);

        pid = fork(); //child process to handle request
        if (pid == 0) {
            // Request handle and response

            /* receive the request info and store it into recv_buf. The recv_buf only recive its size of bytes and so can prevent too long url. */
            hello_len = recv(client_fd, recv_buf, BUFF_SIZE, 0);

            //400 Bad Request
            //NULL request
            if (hello_len == -1) {
                rep_code(client_fd, 400, "Bad Request", method); //Sel-defined func to reponse.

                close(client_fd);
                DIE("recv");
            }

            //Get the Method Type of Request
            char head_buf[BUFF_SIZE];
            memset(&head_buf, 0, sizeof(head_buf)); //must clean value or wierd char in empty para
            //int i;
            for (i = 0; recv_buf[i] != ' '; i++)
                ;
            strncpy(head_buf, recv_buf, i);
            //printf("head_buf: %s\n", head_buf);

            //Determine the Request Method
            //501 Not implemented
            if (strcmp(head_buf, "GET") != 0 && strcmp(head_buf, "HEAD") != 0) {
                rep_code(client_fd, 501, "Not Implemented", method);

                close(client_fd);
                exit(0);
            }

            //if head method, no body of html and only HTTP header can be returned.
            if (strcmp(head_buf, "HEAD") == 0){
                method=0;
            }

            //Get the Requested File Path and Validate its Relative Path
            char path_buf[BUFF_SIZE];
            memset(&path_buf, 0, sizeof(path_buf)); //must clean value or wierd char in empty para
            memset(&web_path, 0, sizeof(web_path));
            int t;
            for (t = i + 1; recv_buf[t] != ' ' && t < (strlen(recv_buf)-2); ++t) //In geting method, i has been at cursor after GET or HEAD. Besides, simple request is in "GET /file"(no HTTP/1.0), so it is need to be ended.strlen -2 as there are 2 char extra (maybe \0 \n).       
                ;
            //printf("%s\n", recv_buf + i + 1);
            //printf("%d %d %d\n", t, i, strlen(recv_buf));
            strncpy(path_buf, recv_buf + i + 1, t - i - 1); //if no -1, space in the last. Actually 3rd para is t-(t+1).
            strncat(path_head, path_buf, 1024);
            realpath(path_head, web_path);

            //404 Not found
            if (access(web_path, F_OK) < 0) {
                rep_code(client_fd, 404, "Not Found", method);

                close(client_fd);
                exit(0);
            }

            //403 Forbidden
            if (access(web_path, R_OK) < 0) {
                rep_code(client_fd, 403, "Forbidden", method);

                close(client_fd);
                exit(0);
            }

            //200 OK
            /* send page file to the client */
            //open page
            FILE *web_file=NULL;
            web_file = fopen(web_path, "r");
            if (web_file == NULL) {
                //500 Internal Server Error
                rep_code(client_fd, 500, "Internal Server Error", method);

                close(client_fd);
                DIE("fopen");
            }

            rep_code(client_fd, 200, "OK", method);

            //Send index.html line by line
            if(method==1){
                while (!feof(web_file) && fgets(buf, sizeof(buf), web_file)) {
                    send(client_fd, buf, strlen(buf), 0);
                } 
            }
            
            close(client_fd);
            exit(0);
        }
        else if (pid < 0) {
            rep_code(client_fd, 500, "Internal Server Error", method);
            close(client_fd);
            DIE("fork");
        }

        /* In Father process, close the client socket for next client acception*/
        close(client_fd);
    }

    return 0;
}
