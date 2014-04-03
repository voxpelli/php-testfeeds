#!/bin/bash
# in bash_profile, use export testdata_dest=user@testdata.player.fm
ssh -n $testdata_dest 'cd testdata; git pull; bin/media.sh; exit'
