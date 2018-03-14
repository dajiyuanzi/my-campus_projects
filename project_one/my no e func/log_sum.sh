#!/bin/bash
# Remind user the usage of this program
USAGE="Please follow the usage: $0 [-n N] [-e] (-c|-2|-r|-F|-t) <FILE NAME>"

# -c: Which IP address makes the most number of connection attempts
# $1 is the number of lines need to print out, $2 is the file need to analyze
cresult(){
   # Get attempt number of  IPs
    printf 'IPs\t\tTimes\n'
    awk ' { tot[$1]++ } END { for (i in tot) printf "%s\t %s\n", i,tot[i]} ' $2 | sort -rn -k2 | head -$1
}

cresult2(){
  awk '{ print $1 }' $2 | sort -rn | uniq -c | sort -rn | awk '{ print $2,$1 }' | head -$1
}

# -2: Which IP address makes the most number of successful attempts
# $1 is the number of lines need to print out, $2 is the file need to analyze
tworesult(){
    # result code in 2XX 3XX is successful
    if cut -d " " -f9 $2 | grep -q "^[23][0-9][0-9]"; then 
        # Print out the successful attempts
        printf 'IPs\t\tTimes\n'
        awk ' $9~/^[23][0-9][0-9]/ {printf "%s\t\n", $1} ' $2 | sort -rn | uniq -c | sort -rn | awk '{printf "%s\t %s\n", $2,$1}' |head -$1
    else
      # No successful attempts in the log
      echo "There is no successful connection!"
    fi
}
#-r: What are the most common results codes and where do they come from? (first get the sequence of most common codes and then grep IP of per code in the sequence)
rresult(){
  #empty the file, including no empty line
  cat /dev/null > temp.sh 
  # list and sequence all result code without duplication
  for loop in `cut -d " " -f9 $2 | sort -rn | uniq -c |sort -rn | tr -s " " | cut -d " " -f3` 
  do
    #per result code to be matched in file with outputing its same line IP and then added to temp file; as first column all same by "grep", sort can set same line successive together for uniq duplicated lines
    cat $2 | awk '{ print $9,$1 }'| grep "^${loop}" | sort -rn -k2 | uniq -c | sort -rn | awk '{ print $2,$3 }' >> temp.sh 
  done
  head -$1 temp.sh
}
#the ResultCode-IP combination is sorted, rather than firstly sort result code and then IP
rresult2(){
  #empty the file, including no empty line
  cat /dev/null > temp.sh 
  # list and sequence all result code without duplication
  for loop in `cut -d " " -f9 $2 | sort -rn | uniq -c |sort -rn | tr -s " " | cut -d " " -f3` 
  do
    #per result code to be matched in file with outputing its same line IP and then added to temp file; as first column all same by "grep", sort can set same line successive together for uniq duplicated lines
    cat $2 | awk '{ print $9,$1 }'| grep "^${loop}" | sort -rn -k2 | uniq -c >> temp.sh 
  done
  cat ./temp.sh | sort -rn | awk '{ print $2,$3 }' | head -$1
}


#-F: What are the most common result codes that indicate failure (no auth, not found etc) and where do they come from?
fresult(){ #first list all result code, then code in 2XX is successful and other fault.
  cat /dev/null > temp.sh #empty the file, including no empty line
  for loop in `cut -d " " -f9 $2 | sort -rn | uniq -c |sort -rn | tr -s " " | cut -d " " -f3` # list and sequence all result code without duplication
  do
    if [ $loop -lt 200 -o $loop -gt 399 ]; then #only successful result code(in 2XX 3XX) can be to match the file
      #per "successful" result code to be matched in file with outputing its same line IP and then added to temp file; as first column all same by "grep", sort can set same line successive together for uniq duplicated lines
      awk '{ print $9,$1 }' $2 | grep "^${loop}" | sort -rn -k2 | uniq -c | sort -rn | awk '{ print $2,$3 }' >> temp.sh
    fi
  done
  head -$1 temp.sh
}
#the ResultCode-IP combination is sorted, rather than firstly sort result code and then IP
fresult2(){ #first list all result code, then code in 2XX is successful and other fault.
  cat /dev/null > temp.sh #empty the file, including no empty line
  for loop in `cut -d " " -f9 $2 | sort -rn | uniq -c |sort -rn | tr -s " " | cut -d " " -f3` # list and sequence all result code without duplication
  do
    if [ $loop -lt 200 -o $loop -gt 399 ]; then #only successful result code(in 2XX 3XX) can be to match the file
      #per "successful" result code to be matched in file with outputing its same line IP and then added to temp file; as first column all same by "grep", sort can set same line successive together for uniq duplicated lines
      awk '{ print $9,$1 }' $2 | grep "^${loop}" | sort -rn -k2 | uniq -c >> temp.sh
    fi
  done
  cat ./temp.sh | sort -rn | awk '{ print $2,$3 }' | head -$1
}


#-t: Which IP number get the most bytes sent to them?
# $1 is the number of lines need to print out, $2 is the file need to analyze
tbytes(){
  cat $2 | awk ' { tot[$1]+=int($10) } END { for (i in tot) printf "%s\t %s\n", i, tot[i] } ' | sort -rn -k2 | head -$1
}

tbytes2(){
  cat /dev/null > temp.sh
  for loop in `awk '{ print $1 }' $2 | sort | uniq`
  do
    b=0
    for a in `grep "^${loop}" $2 | awk '{ print $10 }'`
    do
      if [[ $a != "-" ]]; then
        let b+=a
      fi
    done
    echo "${loop} ${b}" >> temp.sh
  done
  cat ./temp.sh | sort -rn -k2 | head -$1
}

#-e: Compare the DNS in file to dns.blacklist.txt. If same DNS available, output its IP.
# $1 is the number of lines need to print out, $2 is the file need to analyze
eblacklist(){
  awk '{ tot[$11] } END { for (i in tot) printf "%s\n", i}' $2 > temp.sh
  cat /dev/null > temp2.sh
  for loop in `cat dns.blacklist.txt`
  do
    if [[ -n ${loop} && -n `grep "${loop}" temp.sh` ]]; then
      awk '{print $11,$1}' thttpd.log | grep "${loop}" | awk '{ tot[$0] } END { for (i in tot) printf "%s\tBlacklist\n", i}' >> temp2.sh
    fi
  done
  head -$1 temp2.sh
}


# According to the command line parameter, print out result
# $1 is the number of print out lines; $2 is the command; $3 is the file needs to be analyzed.
print_log(){ 
  case $2 in 
    -c) 
    cresult $1 $3
    #cresult2 $1 $3
    ;;
    -2)
    tworesult $1 $3
    ;;
    -r) 
    #rresult $1 $3
    rresult2 $1 $3
    ;;
    -F) 
    #fresult $1 $3
    fresult2 $1 $3
    ;;
    -t) 
    tbytes $1 $3
    #tbytes2 $1 $3
    ;;
    -e) eblacklist $1 $3
    ;;
    *) echo ${USAGE}
    ;;
  esac
}


#MAIN STARTS
pa1='^[0-9]+$' #pattern of printing out limitation lines
pa2='^-[c2rFte]$' #pattern of commands option
# Check whether user provides the arguments: [-n N ] [-e] (-c|-2|-r|-F|-t) file
if [[ $# == 4 ]]; then 
  if [[ $1 == '-n' && $2 =~ $pa1 && $3 =~ $pa2 && -n $4 ]]; then
    print_log $2 $3 $4
  else
    echo ${USAGE}
  fi
elif [[ $# == 5 ]]; then
  if [[ $1 == '-n' && $2 =~ $pa1 && $3 =~ '-e' && $4 =~ $pa2 && -n $5 ]]; then
    echo "-e is under development, you can try beta version by [-n N ] -e file"
  else
    echo ${USAGE}
  fi
# Check whether user provides the arguments:(-c|-2|-r|-F|-t) file
elif [[ $# == 2 ]]; then 
  if [[ $1 =~ $pa2 && -n $2 ]]; then
    #If no line limited, get the number of whole file lines
    line=`grep -c "" $2` 
    print_log $line $1 $2
  else
    echo ${USAGE}
  fi  
else
  echo ${USAGE}
fi

