Totoro
======

![Totoro](http://s.juliendesrosiers.ca/totoro-cement-wall.png)

Totoro is a featherweight blog engine for the Alpha-Geek.

Features
--------

* RSS feed
* all the posts are stored on the file system, in Markdown, Textile or HTML
* simple file-based caching of pages
* Disqus comments are supported in the default theme
* Themeable (includes a simple default theme)

Installation
------------

1. copy the content of this repository into your document root folder
2. modify the content of config.php to suit your needs (author_name, base_url, title,
   description, etc).
3. remove demo posts in posts/, and write your own first post. Don't forget to add a
   title in the first line of your post. 
   You'll also need to name your file using this format:
   "`<YYYY-MM-DD>-<post-slug>.<format>`"
4. make the cache directory writable: `chmod a+w cache/`
5. (optional) if you wish to have Disqus comments, first create an account
   on disqus.com. Then paste the 'disqus_shortname' in your config.php.

Notes for deployment
--------------------

If you're using TOTORO_ENV in your config.php to detect the current
environment, you might want to set the environment in your .htaccess file, like
this:

SetEnv TOTORO_ENV production

Thanks
------

Totoro is inspired by [Toto](http://cloudhead.io/toto). Give it a shot, it's
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

