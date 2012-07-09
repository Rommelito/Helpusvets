=== ThreeWP Ajax Search ===
Tags: ajax, search, searching, text, jquery, relevanssi
Requires at least: 3.0
Tested up to: 3.0
Stable tag: trunk

Enables ajax searches for content. The default settings work automatically with Twentyten and derivatives.

== Description ==

Enables ajax searches for content. The default settings work automatically with Twentyten and derivatives.

It uses Wordpress' built-in search. Works well with Relevanssi because ajax search doesn't actually do any parsing itself. 

Ajax search works right out of the box be can be customized using options, CSS and jQuery customizations. See the screenshots.

== Installation ==

1. Unzip and copy the zip contents (including directory) into the `/wp-content/plugins/` directory
1. Activate the plugin sitewide through the 'Plugins' menu in WordPress.

== Screenshots ==

1. Ajax search in progress
1. Ajax search results, with the second result highlighted by the keyboard navigation
1. Settings overview
1. All the settings

== Changelog ==
= 1.2 =
* Javascript in head is escaped
* Updated framework
* Settings can actually be deleted
* Setting names cleaned up
* Default settings are not clobbered when reactivating
* 500ms is now default reaction time for searches, instead of 200.
= 1.1 =
* jquery is automatically enqueued
* Text cache goes for content, not length
* PHP Warnings removed
= 1.0 =
* Initial public release
