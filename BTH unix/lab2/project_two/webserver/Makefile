HEADER = header.h
HDIR = include
CON = config.h
CC      = gcc
HFILE = $(patsubst %,$(HDIR)/%,$(HEADER))
CFLAGS  = -w -I$(HDIR)-I$(CON)-private
RM      = rm -f
ODIR = objects
OBJ = server.o
OFLIE = $(patsubst %,$(ODIR)/%,$(OBJ))
DEP = $(OFLIE:%.o=%.d)
SDIR = src
SOURCE = server.c
SFLIE = $(patsubst %,$(SDIR)/%,$(SOURCE))


TARGET = server
$(TARGET): $(OFLIE) $(HFILE)
	$(CC) -MMD -Wall $(OFLIE) -o $(TARGET)
	# Include all .d files
-include $(DEP)
$(OFLIE): $(SFLIE) $(HFILE)
	$(CC) -MMD -c -Wall $(SFLIE) $(CFLAGS) -o $@
.PHONY : clean
clean:
	$(RM) $(OFLIE)
	$(RM) $(TARGET)
	$(RM) $(DEP)