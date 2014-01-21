#!/bin/bash
host='http://testdata.player.fm'
for file in *.rss ; do
  echo $file
  sed -i.bak 's/%%HOST%%/$host/g' $file
done
