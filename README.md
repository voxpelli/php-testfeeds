TestData
========

Some easily-manipulated test resource serves to help HTTP client developers
simulate various conditions, including error conditions, in a deterministic way.

Installing
==========

1. git clone
2. bin/make.sh
3. ensure public web folder is pointing at web/

Dynamic Feeds
=============

The root, e.g. http://testdata.player.fm will update every 10 seconds. Items are
consistent, ie when the latest item is relegated to 2nd place in 10 seconds,
it will retain its title, pubDate, and other properties.

Examples:

* http://testdata.player.fm/
* http://testdata.player.fm?interval=60 # posts change every 60 seconds
* http://testdata.player.fm?time=1391473816944 # time of latest post

File Serving
============

File serving example:
  * http://testdata.player.fm/file.php?id=freakowild&type=true&length=true&prepause=2&postpause=5

  ID (default: freakowild) - mp3 filename (see git repo for options)
  type (default: true) - the response content header you want. "true" means guess actual type, "false" means no type or server's default.
  length (default: true) - the response length header you want. "true" means guess actual length, "false" means no length or server's default.
  prepause (default: 0) - a delay before sending
  postpause (default: 0) - a delay after sending

License
=======

[Extracts from certain podcasts are included here, license is held by their
original owners and they will soon be replaced by CC-licensed resources]

The MIT License (MIT)

Copyright (c) from 2014, Michael Mahemoff

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
