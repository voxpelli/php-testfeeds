TestFeeds
=========

Some test RSS feeds

Installing
==========

1. git clone
2. bin/make.sh
3. ensure public web folder is pointing at web/

Static Feeds
============

Just visit the root, e.g. http://testdata.player.fm to find the static RSS feeds.

Dynamic Feeds
=============

The root, e.g. http://testdata.player.fm will update every 10 seconds. Items are
consistent, ie when the latest item is relegated to 2nd place in 10 seconds,
it will retain its title, pubDate, and other properties.

Examples:

* http://testdata.player.fm
* http://testdata.player.fm/dynamic?interval=60 # posts change every 60 seconds
* http://testdata.player.fm/dynamic?time=1391473816944 # time of latest post
