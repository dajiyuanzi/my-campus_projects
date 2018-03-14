#!/bin/bash
# Remind user the usage of this program
USAGE="Please follow the usage: $0 [-n N] [-e] (-c|-2|-r|-F|-t) <FILE NAME>"

cleartemp(){
  cat /dev/null > $1
}
# -c: Which IP address makes the most number of connection attempts
# $1 is the number of lines need to print out, $2 is the e command,
# $3 is the file need to analyze
cresult(){
    cleartemp temp
   # Get attempt number of  IPs
    awk ' { tot[$1]++ } END { for (i in tot) printf "%s\t %s\n", i,tot[i]} ' $3 | sort -rn -k2 | head -$1 > temp
    printf 'IPs\t\tTimes\n'
    blackfilter temp $2 "-c"
}

# -2: Which IP address makes the most number of successful attempts
# $1 is the number of lines need to print out, $2 is the e command,
# $3 is the file need to analyze
tworesult(){
    # result code in 2XX 3XX is successful
    if cut -d " " -f9 $3 | grep -q "^[23][0-9][0-9]"; then 
        # Print out the successful attempts
        printf 'IPs\t\tTimes\n'
        awk ' $9~/^[23][0-9][0-9]/ {printf "%s\t\n", $1} ' $3 | sort -rn | uniq -c | sort -rn | awk '{printf "%s\t %s\n", $2,$1}' |head -$1 > temp
        blackfilter temp $2 "-2"
    else
      # No successful attempts in the log
      echo "There is no successful connection!"
    fi
}
#-r: What are the most common results codes and where do they come from? (first get the sequence of most common codes and then grep IP of per code in the sequence)
rresult(){
  #empty the file, including no empty line
  cleartemp temp
  # list and sequence all result code without duplication
  for loop in `cut -d " " -f9 $3 | sort -rn | uniq -c |sort -rn | tr -s " " | cut -d " " -f3` 
  do
    #per result code to be matched in file with outputing its same line IP and then added to temp file; as first column all same by "grep", sort can set same line successive together for uniq duplicated lines
    cat $3 | awk '{ print $9,$1 }'| grep "^${loop}" | sort -rn -k2 | uniq -c | sort -rn | awk '{ print $2,$3 }' >> temp
  done
  head -$1 temp > tempp
  cleartemp temp
  printf 'Code\t IP\n'
  blackfilter tempp $2 "-r"
}

#-F: What are the most common result codes that indicate failure (no auth, not found etc) and where do they come from?
fresult(){ #first list all result code, then code in 2XX is successful and other fault.
  cleartemp temp #empty the file, including no empty line
  cleartemp tempp
  for loop in `cut -d " " -f9 $3 | sort -rn | uniq -c |sort -rn | tr -s " " | cut -d " " -f3` # list and sequence all result code without duplication
  do
    if [ $loop -lt 200 -o $loop -gt 399 ]; then #only successful result code(in 2XX 3XX) can be to match the file
      #per "successful" result code to be matched in file with outputing its same line IP and then added to temp file; as first column all same by "grep", sort can set same line successive together for uniq duplicated lines
      awk '{ print $9,$1 }' $3 | grep "^${loop}" | sort -rn -k2 | uniq -c | sort -rn | awk '{ print $2,$3 }' >> temp
    fi
  done
  head -$1 temp > tempp
  cleartemp temp
  printf 'Code\t IP\n'
  blackfilter tempp $2 "-F"
}

#-t: Which IP number get the most bytes sent to them?
# $1 is the number of lines need to print out, $2 is the e command,
# $3 is the file need to analyze
tbytes(){
  cleartemp temp
  cat $3 | awk ' { tot[$1]+=int($10) } END { for (i in tot) printf "%s\t %s\n", i, tot[i] } ' | sort -rn -k2 | head -$1 > temp
  printf 'IPs\t\t Bytes\n'
  blackfilter temp $2 "-t"
}

# $1 is the file need to analyze; $2 is the command -e; $3 is -r or -F
blackfilter(){
  if [ "$2" = "-e" ]; then
    eblacklist $1 $3
  else
    cat $1
  fi
}

#-e: Compare the DNS in file to dns.blacklist.txt. If same DNS available, output its IP.
# $1 is the file need to analyze; $2 is the command -r or -F
eblacklist(){
    i=0
    # get IP from the result temp file
    if [[ "$2" = "-F" || "$2" = "-r" ]]; then
      ips=`awk '{printf "%s\n", $2}' $1`
    else
      ips=`awk '{printf "%s\n", $1}' $1`
    fi
    for loop in ${ips}
    do
      let i=i+1
      curntLine=$( sed "${i}q;d" $1 ) # get the IP of current line
    
      host ${loop} > temp1 # host command: get domain of the input IP
      if grep -q -s "domain name pointer" temp1; then # If IP accessible, the output of host command is appended string "domain name pointer".
        host=$( awk '{print $5}' temp1 )
        hostname=${host::-1} # Remove the last bite as it is useless.
        # echo ${loop} ${hostname}
        # look up the hostname in blacklist
        if grep -q -s $hostname $blacklist; then # If no matched, dont output error.
          sed -i "${i}s/.*/${curntLine}   blacklisted/" $1 # apped the string "blacklisted" to the output line end.
        fi
      fi
    done
    cleartemp temp1
    cat $1
    cleartemp $1

}


# According to the command line parameter, print out result
# $1 is the number of print out lines; $2 is the -e command; 
# $3 is the other command; $4 is the file needs to be analyzed.
print_log(){ 
  case $3 in 
    -c) 
    cresult $1 $2 $4
    #cresult2 $1 $3
    ;;
    -2)
    tworesult $1 $2 $4
    ;;
    -r) 
    rresult $1 $2 $4
    #rresult2 $1 $3
    ;;
    -F) 
    fresult $1 $2 $4
    #fresult2 $1 $3
    ;;
    -t) 
    tbytes $1 $2 $4
    #tbytes2 $1 $3
    ;;

    *) echo ${USAGE}
    ;;
  esac
}


#MAIN STARTS
pa1='^[0-9]+$' #pattern of printing out limitation lines
pa2='^-[c2rFt]$' #pattern of commands option
blacklist="dns.blacklist.txt"
earg="no"
# Check whether user provides the arguments: [-n N ] [-e] (-c|-2|-r|-F|-t) file
if [[ $# == 4 ]]; then 
  if [[ $1 == '-n' && $2 =~ $pa1 && $3 =~ $pa2 && -n $4 ]]; then  
    print_log $2 $earg $3 $4
  else
    echo ${USAGE}
  fi
elif [[ $# == 5 ]]; then
  if [[ $1 == '-n' && $2 =~ $pa1 && $3 =~ '-e' && $4 =~ $pa2 && -n $5 ]]; then
    print_log $2 $3 $4 $5
  else
    echo ${USAGE}
  fi
# Check whether user provides the arguments:(-c|-2|-r|-F|-t) file
elif [[ $# == 2 ]]; then 
  if [[ $1 =~ $pa2 && -n $2 ]]; then
    #If no line limited, get the number of whole file lines
    line=`grep -c "" $2` 
    print_log $line $earg $1 $2
  else
    echo ${USAGE}
  fi  
elif [[ $# == 3 ]]; then 
  if [[ $1 == '-e' && $2 =~ $pa2 && -n $3 ]]; then
    #If no line limited, get the number of whole file lines
    line=`grep -c "" $3` 
    print_log $line $1 $2 $3
  else
    echo ${USAGE}
  fi
else
  echo ${USAGE}
fi

