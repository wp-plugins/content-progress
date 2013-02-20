=== Content Progress ===
Contributors: joedolson
Donate link: http://www.joedolson.com/donate.php
Tags: page, post, admin, developer, tools, progress, content, editorial, review, overview, workflow
Requires at least: 3.2.1
Tested up to: 3.5.0
Stable tag: trunk

Manage your work flow: mark WordPress posts and Pages as completed, partial, needing review. Add notes documenting editorial needs.

== Description ==

Content Progress is a plug-in to help manage your content editing work flow. It adds icons to your content listings (Posts, Pages, and custom post types) to indicate the current needs for that post. 

The plug-in auto-detects empty posts or documents with very small amounts of content; but also allows you to flag documents specifically.

You can flag any document as incomplete or needing review, or create custom content flags suitable to your needs, such as "Needs Research", "Add Media" or "Needs Scheduling".

To help communication between groups (or remembering where you are for large sites!), you can also add notes to each post.

This simple work flow plug-in provides a quick way to scan over which documents in your web site are finished, since it is frequently the case in my own development that I add all new pages (for the purpose of building menus and navigation) before actually filling those pages with content.

There are also four shortcodes available for generating front-facing lists of pages: [empty], [partial], [incomplete], and [needs_review] which will produce appropriate unordered lists of documents. Each shortcode accepts an argument for the post type: e.g. [empty type='post']

With the addition of custom statuses available in version 1.3.0, a fifth shortcode [list status=''] is available to produce a list of items with a custom status.

Translating my plug-ins is always appreciated. Visit <a href="http://translate.joedolson.com">my translations site</a> to start getting your language into shape!

Languages available (in order of completeness):
Irish

Translator Credits (in no particular order)*:
[Ale Gonzalez](http://60rpm.tv/i), [Outshine Solutions](http://outshinesolutions.com), [Jakob Smith](http://www.omkalfatring.dk/), [globus2008](http://wordpress.org/support/profile/globus2008), Frederic Escallier, Luud Heck, Wim Strijbos, [Daisuke Abe](http://www.alter-ego.jp/), [Alex](http://blog.sotvoril.ru/), Mehmet Ko&ccedil;ali, Uwe Jonas, Florian Edelmann, Efva Nyberg, [Sabir Musta](http://mustaphasabir.altervista.org), Massimo Sgobino, Leonardo Kfoury, Alexandre Carvalho, Amir Khalilnejad, [Aurelio De Rosa](http://www.audero.it/), Bayram Dede, Dani Locasati, Dario Nunez, Dirk Ginader, Evren Erten, Fl&aacute;vio Pereira, Francois-Xavier Benard, [Gianni Diurno](http://www.gidibao.net), Giksi, Heinz Ochsner,  Kazuyuki Kumai, Liam Boogar, Maks, Mano, Massimo Sgobino, Mohsen Aghaei, Oscar, [Rashid Niamat](http://niamatmediagroup.nl/), Stefan Wikstrom, Thomas Meyer, Vedar Ozdemir, [Vikas Arora](http://www.wiznicworld.com), [Miriam de Paula](http://wpmidia.com.br), [HostUCan](http://www.hostucan.com), [Alex Alexandrov](http://www.webhostingrating.com), [Alyona Lompar](http://www.webhostinggeeks.com), [David Gil P&eacute;rez](http://www.sohelet.com), [Burkov Boris](http://chernobog.ru), [Raivo Ratsep](http://raivoratsep.com), [Jibo](http://jibo.ro), [Rasmus Himmelstrup](http://seoanalyst.dk), [kndb](http://blog.layer8.sh/)

== Changelog ==

= 1.3.2 =

* Bug fix: Added fallback function for exif_imagetype when exif not installed. (Related to: custom status icons)

= 1.3.1 =

* Fixed broken labels when updating flags in Quick Edit.
* Fixed PHP notice errors from undefined variables in Quick Edit.

= 1.3.0 =

* Added ability to create custom status labels.
* Added icon library
* Bug fix: posts without set values did not display with default settings.
* Revised description.
* Added Irish translation.

= 1.2.3 =

* Missed one occurrence of the settings array bug.
* Revised plug-in description to improve clarity.
* Revised quick edit script so that Notes are exposed in quickedit on all post types.

= 1.2.2 =

* Oh, wow. I forgot to add the scripts directory to the subversion repository.

= 1.2.1 = 

* Settings bug

= 1.2.0 =

* Added 'notes' column to posts tables.
* Added selection options for progress label and notes fields to Quick Edit mode.
* Added option to limit use of plug-in to specific content types.
* Bug fix: default settings were not rendered in posts tables.

= 1.1.1 =

* Added new option: mark "Needs Review"
* Replaced all graphics with more intuitive icons.
* Fixed theme data bug 

= 1.1.0 =

* Added option to mark a document as complete, as well as mark as incomplete.
* Changed flags: Blue flag now means complete, Yellow means short content. 
* Updated some textdomain labels (had wrong plug-in textdomain on a few strings.

= 1.0.0 =

* Initial release

== Installation ==

1. Upload the `content-progress` folder to your `/wp-content/plugins/` directory
2. Activate the plugin using the `Plugins` menu in WordPress
3. Visit any listing of content: Posts, Pages, etc. to see notifications.

== Frequently Asked Questions ==

= This is a weird idea. Why'd you write it? =

While working on a web site with several hundred pages, it got difficult to keep track of which pages had their content loaded in. This was a quick way to see what needed to be done.

== Screenshots ==

1. Posts page indicator

== Upgrade Notice ==

* 1.3.0: Custom statuses, custom icons, Irish translation.