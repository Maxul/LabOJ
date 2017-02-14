#!/bin/bash

# only used for Lab Online Judge

CC=gcc
CXX=g++

HINT=hint
COMPARE=compare
SANDBOX=sandbox

RESULT=(
	"UN-USED"

	"Accepted"

	"Compile Error"

	"Memory Limit Exceeded"
	"Output Limit Exceeded"

	"Runtime Error"
	"System Error"

	"Time Limit Exceeded"

	"Presentation Error"
	"Wrong Anwser"
)

# OJ user_source.c testdata_directory
if [[ $# -ne 2 ]]; then
	echo "Usage: $0 source_file testdata_directory"
	exit 1
fi

SOURCE=$1   
PROBLEM=$2

# compose variable names
DIR=`dirname -z $(pwd)/$0`

# obtain base name with extension
BIN=`basename $SOURCE`
# strip suffix
BIN=${BIN%%.*}

IN=`ls $PROBLEM/*.in`
TEMP=`openssl rand -hex 5 2>/dev/null`

# try compiling the SOURCE file
case ${SOURCE##*.} in
	c) $CC -o $BIN -Wall -lm -std=c11 $SOURCE ;;
	cpp) $CXX -o $BIN -Wall -std=c++11 $SOURCE ;;
	*) echo "Unsupported language type." ;;
esac

if [[ 0 -ne $? ]]; then
	status="Compile Error"
else
	# compiled successfully, execute it and compare the output
	for infile in $IN; do
		outfile=${infile%.*}.out
		$DIR/$SANDBOX $BIN <$infile >$TEMP
		status=${RESULT[$?]}

		# successfully pass the execute path
		if [ "$status" != "Accepted" ]; then
			break
		else
			$DIR/$COMPARE $outfile $TEMP
			status=${RESULT[$?]}

			# drop hints for what's wrong
			if [ "$status" != "Accepted" ]; then
				$DIR/$HINT $infile $outfile $TEMP
				break
			fi
		fi
	done

	# remove the binary executeable file
	rm $BIN $TEMP
fi

# print the RESULT and append it to destination
echo -e "$BIN \t $status" | tee -a $PROBLEM/result

