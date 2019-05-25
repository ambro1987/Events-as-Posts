=== Events as Posts ===

Contributors: orbam7819, zanychew
Author URI: https://ambrogiopiredda.com
Donate link: https://paypal.me/ambrogiopiredda
Tags: event, events, event list, agenda
Requires at least: 4.8
Tested up to: 5.2
Stable tag: 0.5.4
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple plugin that allows you to post events on your site

== Description ==

**Events as Posts** is a simple plugin that allows you to post events as if they were normal posts, but with added fields like date, time and location.

It also allows you to display **lists of events** everywhere on your site using a shortcode. You can choose if you want to display future, past or all the events, and also the number of events and of which category.

== Installation ==

**Installation via WordPress**

1. Go to the menu 'Plugins' -> 'Install' and search for 'Events as Posts'
2. Click 'Install'

**Manual Installation**

1. Upload 'events-as-posts' directory to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Events' -> 'Add event' in the admin menu to publish your events
4. Go to 'Events' -> 'Settings' in the admin menu to create a shortcode for a list of events and add styles to it

== Frequently Asked Questions ==

= When I choose to display events by category they are not showing =

Double check that you have written the category name correctly and, if you have more than one category, that you have separated them with a comma.

= I chose to display the excerpt in a list of events and it's showing in all the lists, how can it be? =

The setting that allows you to show the excerpt on lists of events is not related to the shortcode and if selected it will show the excerpt on all the lists.

= Can I change the order of how events on the list are displayed? =

Yes, just add to the shortcode `order="ASC"` for ascendent order or `order="DESC"` for descendent order.

= Using events' metadata with other plugins =

Use the following meta keys:

* eap_from_day: starting date of the event ( Y-m-d format )
* eap_from_day_custom_format: starting date of the event ( settings' format )
* eap_from_time: starting time of the event ( H:i format )
* eap_from_time_custom_format: starting time of the event ( settings' format )
* eap_until_day: ending date of the event ( Y-m-d format )
* eap_until_day_custom_format: ending date of the event ( settings' format )
* eap_until_time: ending time of the event ( H:i format )
* eap_until_time_custom_format: ending time of the event ( settings' format )
* eap_location: location of the event
* eap_link_location: link to event's location
* eap_city: event's city
* eap_country: event's country
* eap_add_info: additional information about the event

If you're going to use 'M' or 'F' as a date format for the month, which display the month in letters (short and long form), the month name will be stored in the database in the language of the user who created or updated the event.

== Screenshots ==

1. Adding a new event

== Changelog ==

= 0.5.4 &mdash; 25 of May, 2019 =
* Removed some span elements and some classes to get rid of white spaces after location meta

= 0.5.3 &mdash; 23 of November, 2018 =
* Fixed an error appearing when installing the plugin for the first time

= 0.5.2 &mdash; 6 of November, 2018 =
* Added option to display calendar icon and clock icon before date and time

= 0.5.1 &mdash; 5 of November, 2018 =
* Added custom css option

= 0.5 &mdash; 4 of November, 2018 =
* Added date and time format options.
* Added date and time custom format meta keys to use with other plugins
* General improvements in the plugin and the code

= 0.4 &mdash; 5 of October, 2018 =
* Added 'Country' and 'Additional information' fields
* Added 'Display categories' option for list of events
* Improved settings page and removed options for colors ( apart from background color ) in style tab

= 0.3 &mdash; 3 of October, 2018 =
* Added 'Read more link' option for list of events
* Added admin stylesheet
* Improved location fields when adding or editing an event

= 0.2.1 &mdash; 2 of October, 2018 =
* Display all the future or all the past events independently of posts per page in 'Settings' -> 'Reading'

= 0.2 &mdash; 2 of October, 2018 =
* Added event's 'Until' date ( if present ) in 'Date' column in 'Events' -> 'All events'
* List of events responsive

= 0.1 &mdash; 15 of September, 2018 =
* First release.
