=== Content Progress ===
Contributors: joedolson
Donate link: http://www.joedolson.com/donate.php
Tags: page, post, admin, developer, tools, progress, content, editorial, review, overview
Requires at least: 3.2.1
Tested up to: 3.4.1
Stable tag: trunk

Mark your WordPress posts and Pages as completed, partial, needing review. Add notes documenting what needs to be done.

== Description ==

Content Progress adds icons to your content listings (Posts, Pages, and custom post types) showing whether the document is complete. While the plug-in has no way to know whether the page has been completely laid out, etc., it can tell whether there is actually content on the page. If there isn't, that document will be flagged as empty. If there's only a small quantity of content on the page, that document will be flagged as partial. 

The plug-in auto-detects empty posts or documents with very small amounts of content; but also allows you to flag documents specifically.

You can flag any document as incomplete or needing review, regardless of the content in that page. 

To help communication between groups (or remembering where you are for large sites!), you can also add notes to each post.

This simply provides a quick and efficient way to scan over which documents in your web site are finished, since it is frequently the case in my own development that I add all new pages (for the purpose of building menus and navigation) before actually filling those pages with content.

There are also four shortcodes available for generating front-facing lists of pages: [empty], [partial], [incomplete], and [needs_review] which will produce appropriate unordered lists of documents. Each shortcode accepts an argument for the post type: e.g. [empty type='post']

Translating my plug-ins is always appreciated. Visit <a href="http://translate.joedolson.com">my translations site</a> to start getting your language into shape!

== Changelog ==

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

* 1.2.3: Minor bug fix to quick edit script; bug fix.