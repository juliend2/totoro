Bato
====

Bato is a featherweight blog engine for the Alpha-Geek.

Features
--------

* RSS feed
* all the posts are stored in the file system, in Markdown, Textile or HTML

Installation
------------

1. copy the content of this repository into your document root folder
2. modify the content of config.php to suit your needs
3. remove demo posts in posts/, and write your own first post. Don't forget to add a
   title in the first line of your post. Otherwise, bad things can happen.
   You'll also need to name your file using this format:
   "`<YYYY-MM-DD>-<post-slug>.<format>`"
4. make the cache directory writable: `chmod a+w cache/`
5. (facultative) if you wish to host your bato blog in a subdirectory, you'll need to
   uncomment and customize the `RewriteBase /yoursubdirectory/` line in .htaccess, to match
   your subdirectory

Thanks
------

Bato is inspired from [Toto](http://cloudhead.io/toto). Give it a shot, it's
pretty cool.

MIT License
-----------

Copyright (C) 2011 Julien Desrosiers

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

