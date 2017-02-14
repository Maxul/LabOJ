#!/bin/bash

code=`ls ./code/*.{c,cpp}`

for c in $code; do
#	/usr/bin/time -v ./OJ.sh $c ../test/data
    bash ../src/LabOJ.sh $c ./data/
    echo "return code: $?"
    echo
done

