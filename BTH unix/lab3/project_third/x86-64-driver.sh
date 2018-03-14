#!/bin/bash
if [[ $# != 1 ]]; then
	echo "USAGE: input only one file named with the '.calc' ending"
	exit
fi

if [[ `echo "$1" | cut -d"." -f2` != 'calc' ]]; then
	echo "USAGE: input a file named with the '.calc' ending"
	exit
fi

#get filename without .calc, notice: $1 is file path, which cannot be used as string dirrectly, it needs echo firstly
#input=`echo $1`
fname=`echo $1 | cut -d "." -f1`

#create assemble .s file in bin folder
assemble_file="bin/$fname.s"

# append the prologue header, assembled code and epilogue end.
cat "src/prologue.s" > $assemble_file
#the only way to execute exe file
"bin/calc3i.exe" < "src/$1" >> $assemble_file #< input redirect，file path after < is the input taking place the keyboard input
cat "src/epilogue.s" >> $assemble_file

# finally compile and link to produce machine code, notice: if fact func used, it needs the fact.s as source code.
if [[ $fname == 'fact' ]]; then
	gcc $assemble_file "src/fact.s" -o "bin/$fname"
else
	gcc $assemble_file -o "bin/$fname"
fi 
