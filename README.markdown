Totoro
======

![Totoro](http://s.juliendesrosiers.ca/totoro-cement-wall.png)

Totoro is a featherweight blog engine for the Alpha-Geek.

Features
--------

* RSS feed
* All the posts are stored on the file system, in Markdown, Textile or HTML
* Simple file-based caching of pages
* Disqus comments are supported in the default theme
* Themeable (includes a simple default theme)
* The markdown pages that are in `pages/<name-of-page>.md` are accessible from
  /name-of-page

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

Notes for development
---------------------

When you're developing your blog locally, you shouldn't need to set the TOTORO_ENV 
environment variable.

Also note that Totoro only serve the cached versions of pages/posts when
TOTORO_ENV is set to 'production'. With any other value, the cache will be
refreshed on each requests.

Thanks
------

Totoro is inspired by [Toto](http://cloudhead.io/toto). Give it a shot, it's
pretty cool.

License
-------

MIT

