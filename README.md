Porn Terminal
=============

> Show random porn in your terminal.

[![Build Status](https://img.shields.io/travis/redaxmedia/porn-terminal.svg)](https://travis-ci.org/redaxmedia/porn-terminal)
[![PHP 7 Ready](https://php7ready.timesplinter.ch/redaxmedia/porn-terminal/badge.svg)](https://travis-ci.org/redaxmedia/porn-terminal)
[![Dependency Status](https://gemnasium.com/badges/github.com/redaxmedia/porn-terminal.svg)](https://gemnasium.com/github.com/redaxmedia/porn-terminal)
[![License](https://img.shields.io/packagist/l/redaxmedia/porn-terminal.svg)](https://packagist.org/packages/redaxmedia/porn-terminal)
[![GitHub Stats](https://img.shields.io/badge/github-stats-ff5500.svg)](http://githubstats.com/redaxmedia/porn-terminal)

![Porn Terminal](https://i.imgur.com/tLgfkDQ.png)


Usage
-----

Run `php bin/porn-terminal` in your terminal.


Examples
--------

Run `php bin/porn-terminal -p ?tags={tag}` to search for {tag} in videos.

Run `php bin/porn-terminal -e /actors/find.json -p ?order=views&limit=1000` for the top 1000 actors.

Run `php bin/porn-terminal -e /actors/find.json -p ?name={name}` to search for {name} in actors.


Options
-------

Run `php bin/porn-terminal --help` for help:

```
-e/--api-endpoint <argument>
     Required. API endpoint (see: https://api.porn.com)


-p/--api-parameter <argument>
     API parameter (see: https://api.porn.com)


-d/--image-dither
     Dither of the image


-g/--image-grayscale
     Grayscale of the image


--help
     Show the help page for this command.


-i/--image-invert
     Invert the image


-r/--image-resize <argument>
     Resize the image


-w/--image-weight <argument>
     Weight of the image


-m/--video-metadata
     Metadata of the video
```