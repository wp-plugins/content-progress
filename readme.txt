=== Content Progress ===
Contributors: joedolson
Donate link: http://www.joedolson.com/donate.php
Tags: page, post, admin, developer, tools, progress, content
Requires at least: 3.2.1
Tested up to: 3.3 beta
Stable tag: trunk

Adds a column to each post/page or custom post type indicating whether content has been added to the page.

== Description ==

Content Progress adds a set of icons into your content listings (Posts, Pages, and custom post types) indicating whether the document is complete. While the plug-in has no way to know whether the page has been completely laid out, etc., it can identify whether there is actually content on the page. If there isn't, that document will be flagged as empty. If there's only a small quantity of content on the page, that document will be flagged as partial. 

You also have the option to flag any document as incomplete, regardless of the content in that page, in which case it will have a separate 'incomplete' flag. 

This simply provides a quick and efficient way to scan over which documents in your web site are finished, since it is frequently the case in my own development that I add all new pages (for the purpose of building menus and navigation) before actually filling those pages with content.

There are also three shortcodes available for generating front-facing lists of pages: [empty], [partial], and [incomplete] which will produce appropriate unordered lists of documents. Each shortcode accepts an argument for the post type: e.g. [empty type='post']

Translations are always welcome! The translation file is in the download. Granted, there isn't a lot of text in this plug-in.

== Changelog ==

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

* No notes yet!