#!/bin/bash

cd `dirname $0`/..
mkdir -p web

for file in src/*.rss ; do
  echo $file
  sed 's/%%HOST%%/http:\/\/testdata.player.fm/g' $file > web/`basename $file`
done

#bakdir=/tmp/rssbak$$
#mkdir $bakdir
#mv -f *.bak $bakdir
