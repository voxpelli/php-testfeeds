#!/bin/bash
# Requires lame - install with "brew install lame" on osx

out=$1.mp3
shift
message=$*
aif=/tmp/$$.aif

say -o $aif $message
lame -m m $aif $out
