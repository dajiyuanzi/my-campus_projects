
LYC = lexyacc-code

JUST_MAKE_IT_AS_BUILD:
	bison -o $(LYC)/y.tab.c -y -d $(LYC)/calc3.y			
	flex -o $(LYC)/lex.yy.c $(LYC)/calc3.l

	gcc	-c $(LYC)/y.tab.c -o $(LYC)/y.tab.o	
	gcc	-c $(LYC)/lex.yy.c -o $(LYC)/lex.yy.o	
	gcc $(LYC)/y.tab.o $(LYC)/lex.yy.o $(LYC)/calc3i.c -o bin/calc3i.exe	

clean:
	rm -rf ./bin/*
	rm -rf $(LYC)/y.tab.c $(LYC)/lex.yy.c $(LYC)/y.tab.o $(LYC)/lex.yy.o bin/calc3i.exe