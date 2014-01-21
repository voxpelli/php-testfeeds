#!/bin/bash
for file in *.rss ; do
  echo $file
  sed -i.bak 's/%%HOST%%/http:\/\/testdata.player.fm/g' $file
done

bakdir=/tmp/rssbak$$
mkdir $bakdir
mv -f *.bak $bakdir
