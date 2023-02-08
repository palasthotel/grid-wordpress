=== Grid ===
Contributors: edwardbock, mkernel, palasthotel
Donate link: http://palasthotel.de/
Tags: landingpage, editor, admin, page, containerist, grid
Requires at least: 4.0
Tested up to: 5.9.3
Stable tag: 2.3.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl

Grid is a containerist landingpage editor.

== Description ==

This plugin is **no longer in active development**. Have a look at [BlockX](https://wordpress.org/plugin/blockx) for a similar editor and developer experience.

What is Grid?

* Grid allows Editors to easily create and maintain Landingpages
* Grid is build of a grid containing Containers and Boxes
* Grid is a CMS-neutral Library and this is the Wordpress plugin that implements it

Types of Boxes

- Static Boxes -

* Free-HTML-Box
* Medialibrary-Box
* Video-Box

- List-Boxes -

* Ordered and filtered Lists of Contents
* Number of Items as well as criteria for sorting and filtering are configurable

- Configuration Boxes -

* Container configuration
* Slot configuration

- Content-Boxes -

* Single Posts of any kind as Teasers

- Reuseable Boxes -

* All Boxes may be reused across several Landingpages

Easy extendable with new boxes. Have a look at doc.the-grid.ws (english is coming soon).

== Installation ==

1. Upload `grid-wordpress.zip` to the `/wp-content/plugins/` directory
1. Extract the Plugin to a `grid` Folder
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Build landing pages at `Landing Pages`, `Switch into the Grid` and on next screen `save changes`
1. Look for more plugins on wordpress.org that can provide grid boxes

== Frequently Asked Questions ==

= How do the async features like author control work? Does Grid talk to an external service? =

Generally speaking, yes! But you can easily turn it off in grid settings. And there will be no talking to any external server anymore. Alternatively you can host your own grid async service on your own server. Note that our service will not use or save any personal data at any time. It only uses data to keep the function going.

= Table already exists error when I want to activate Grid. Why? = 

This happens if grid was installed previously and could not be uninstalled correctly. You have to delete in the wp_options the option_name „grid“. Then try again to active Grid plugin.

= How do I use Grid landingpages? =

Goto Settings->Grid and choose which post types should be able to use Grid. Than goto one of the activated post types and click on `Switch into the Grid` and on next screen `save changes`. Now you can drag and drop your landingpage.

= How do I get new box types? =

Have a look at wordpress.org for plugins that provide new grid boxes or you can create your own plugin and use the `grid_load_classes` action to add new box classes. You can find a documentation at doc.the-grid.ws

= What about Grid an caching? =

Grid works fine with a varnish configuration and the comet cache plugin. If you use another caching that does not work with grid please contact us on github.com or wordpress.org.



== Screenshots ==

1. Grid editor with Container list

2. Grid editor with Box list

== Changelog ==

= 2.3.0 =

* Feature: Resue title for boxes
* Feature: Open in new tab for epilog and prolog links
* Bugfix: HTML parse problems in html box

= 2.2.3 =
* Optimization: lazy load grid templates only if they are needed

= 2.2.2 =
* Dependency: Ckeditor 4.16.1

= 2.2.1 =
* Bugfix: Fixed the textdomain fix

= 2.2.0 =
* Dependency: Uses some parts of palasthotel/wp-components now
* Dependency: Grid lib packages update
* Bugfix: Textdomain translation problems

= 2.1.7 =
* Bugfix: Media box cannot use pdf files
* Library updates

= 2.1.6 =
* Bugfix: Undefined constant GRID_CSS_VARIANT_TABLE on grid update fix

= 2.1.5 =
* Bugfix: Installation broken because of refactoring typos
* Added Search Form Box

= 2.1.4 =
* Added template object to grid component classes and use them to find template paths

= 2.1.3 =
* Undefined variable fix on settings page

= 2.1.2 =
* Post and Posts boxes template fix

= 2.1.1 =
* media widget fix
* ckeditor local installation

= 2.1.0 =
* Refactoring: Updates and code optimizations

= 2.0.3 =
* Bugfix: WordPress 5.5 and jQuery related problems with multi-autocomplete box widgets

= 2.0.2 =
* Feature: Added new hooks for reusable containers and boxes

= 2.0.1 =
* Bugfix: Plugin installation error

= 2.0.0 =
* IMPORTANT: we removed support for sidebar.

= 1.9.2 =
* Optimization: Added flexbox version for default grid css. Can be chosen in grid settings.

= 1.9.1 =
* Update: CKEditor 4.13.1
* Bugfix: Question mark in containers epilog or prolog source code view crashed the grid

= 1.9.0 =
* Refactoring: Reorganized namespaces. BIG CHANGE, please double check!
* Feature: Copy grid

= 1.8.6 =
* Feature: Posts box with multiselect for post types.

= 1.8.5 =
* Bugfix: some databases didn't know utf8mb4_unicode_500_ci so we use now utf8mb4_unicode_ci

= 1.8.4 =
* Style slugs extended to 190 chars
* Style editor input limited to max chars
* Bugfix: Emojies broke grid

= 1.8.3 =
* Bugfix: Visual fix in container and box editor
* Library Bugfix: Problems with slots in reusable containers
* Library update: simplepie from 1.3.1 to 1.5.2

= 1.8.2 =
* Feature: Duplicate boxes
* Optimizations: Cached some db requests

= 1.8.1 =
* Feature: New configuration boxes
* Hook: position of grid is hookable
* Fix: Soundcloud box color support
* Feature: added filter for grid_post_box metaSearch results

= 1.8.0 =
* WordPress 5.0 support
* Optimization: Reorganized admin menu items
* Optimization: Meta Box appearance
* Optimization: Reusable Containers list appearance
* Feature: Find posts by id in content boxes
* Fix: Database error with body_class filter on page without post context like 404 page


= 1.7.15 =
* Optimization: Clean hook distinction between notify and alter
* Optimization: jQuery File Upload update because of security fix in library

= 1.7.14 =
* Feature: Added new filter grid_box_alter_content_structure to modify content structure in box editor.
* Optimization: Add body class if grid should be rendered.
* Bugfix: Using <script> in html box was crashing the grid editor.

= 1.7.13 =
* Optimization: Saving post with updated modification date on grid publish action so cache plugins can do their job.

= 1.7.12 =
* Bugfix: Missing excerpt text.

= 1.7.11 =
* Bugfix: avoid doublets backwards compatibility broke with admin only function. it's not backwards compatible now. See upgrade notice!

= 1.7.10 =
* Feature: Extendable posts box with two new filter grid_posts_box_content_structure and grid_posts_box_query_args
* Bugfix: Recursion fix with posts placed on posts that are placed on these posts
* Bugfix: Prevent rendering grid in case of empty get_the_excerpt call

= 1.7.9 =
* Bugfix: sidebars not editable or assignable
* Bugfix: autocomplate with links
* Optimization: Debug box with autocomplete with links placeholder

= 1.7.8 =
* Feature: new grid box: debug! Only available if WP_DEBUG is true. Has all input types.
* Optimization: mysql connection error handling

= 1.7.7 =
* Bugfix: autocomplete fields in reusable boxes or boxes in reusable containers not working
* Optimization: additional information in db_query error_log

= 1.7.6 =
* Refactoring: deprecated icon function fix on settings page
* Optimization: do not expose queries on mysql error
* Bugfix: close mysql connection on uninstall

= 1.7.5 =
* Bugfix: posts box in child theme fix

= 1.7.4 =

* Feature: new actions grid_publishGrid, grid_destroyGrid, grid_save_container, grid_delete_container, grid_save_slot, grid_save_box, grid_delete_box
* Bugfix: epilog and prolog script safe

= 1.7.3 =
 * date query configuration for posts box. before and after date restriction possibility added.
 * new box widget type input that allows to use all kings of HTML input types
 * async bug fix: empty user display_name were not locking multiple edited grids

= 1.7.2 =
 * critical bug fix: when deleting grid styles all styled elements (container, slot, box) are deleted from grids

= 1.7.1 =
 * templates in child theme support
 * grid/default-frontend.css support in child theme
 * reusable boxes are rendered in sidebar like in grid
 * grid async features fix

= 1.7.0 =
 * added new actions grid_createGrid, grid_publishGrid, grid_destroyGrid, grid_cloneGrid, grid_createContainer

= 1.6.16 =
 * grid styles table index update fix

= 1.6.15 =
 * Sometimes boxes cannot be moved on grid load fix
 * Use of apostroph in box editor text and html fields bugfix
 * getRaw() method grid_rss_box_item
 * Fixed warnings with PHP 7.*
 * grid style tables slug key added

= 1.6.14 =
 * Posts Box and Post Box with fallback to first viewmode if none set or found
 * Post content box future posts in frontend fix

= 1.6.13 =
 * Shortcode box

= 1.6.12 =
 * List box can filter by post format
 * Container will render hook added
 * Container did render hook added
 * Slot will render hook added
 * Slot will render hook added

= 1.6.11 =
 * filter 'grid_the_content_wrapper_class' for optional grid wrapper classes

= 1.6.10 =
 * Box will render hook added
 * Box did render hook added


= 1.6.9.2 =
 * 4.7.1 Fixes
 * Use Wordpress default jQuery fix

= 1.6.9.1 =
 * Posts Box Bugfix

= 1.6.9 =
 * Posts Box taxonomy relation "AND" working now
 * Autocomplete widget fix

= 1.6.8 =
 * Incompatible syntax fix

= 1.6.7 =
 * Multiautocomplete widget fixes
 * Posts box with multiautocomplete for taxonomies

= 1.6.6 =
 * Avoid Doublets plugin implementation

= 1.6.5 =
 * Revisions not working fix

= 1.6.4 =
 * media box fix

= 1.6.3 =
 * PHP function default value calculation fix

= 1.6.2 =
 * Selectable Grid position to Post content
 * Disable Grid in single Post
 * Localization

= 1.6.1 =
 * RSS box in core
 * Plaintext box in core
 * Async timeout setting

= 1.6 =
 * Async features are working
 * Problems with double question marks in box fields fixed

= 1.5.11 =
 * Async locking problems fix
 * grid_the_content filter for grid position on the_content filter

= 1.5.9 =
 * Posts box fix
 * Media type select for media-box in grid settings

= 1.5.8 =
 * Include paths problems fix

= 1.5.7 =
 * Security fix

= 1.5.6 =
 * Variable collision in template files while rendering bugfix

= 1.5.5 =
 * Icon font in list widget fix

= 1.5.4 =
 * Post Box render Bugfix

= 1.5.3 =
 * Posts WP_Query moved to template
 * Async features disabled by default

= 1.5.2 =
 * CKEditor plugins support
 * CSS fix

= 1.5.2 =
 * CKEditor plugins support
 * CSS fix

= 1.5 =
 * Multiple authors handling
 * Visual optimizations

= 1.4.8 =
 * Installation bug fix

= 1.4.7 =
 * Default list of contents box can use all taxonomies
 * Bugfix wp_mediaselect in lists

= 1.4.6 =
 * Fixed reuse area problems

= 1.4.5 =
 * Render to content fix

= 1.4.4 =
 * Imagepreview in grid box editor
 * Posts box shows empty categories
 * Settings for post search on grid
 * refactoring to object orientation

= 1.4.3 =
 * Added lost template files 
 * default editmode template for content objects 

= 1.4.2 =
 * Empty reuse container title bug
 * Default templates update
 * Grid box inheritance
 * Latest contents on empty contents search
 * Grid jumping on dragging new box fix

= 1.4.1 =
 * js and css enqueue fixes

= 1.4 =
 * custom editor JS and CSS files in reuse mode fix

= 1.3.8 =
 * Polylang support

= 1.3.7 =
 * container and box loading fix

= 1.3.5 =
 * more revisions loader on scroll
 * loading opration overlay

= 1.3.5 =
 * missing wordpress media in reuse box editor

= 1.3.4 =
 * initial loading indicator
 * mysqli warning on connection

= 1.3.3 =
 * Post Types Landing Page and Sidebar can be disabled in Grid settings
 * Autocomplete false locking fix
 * New editor CSS filter
 * unpublished posts fix in post grid box

= 1.3.2 =
 * Shortcodes are working with Static HTML Box
 * Soundcloud box has new parameter for height
 * Error on saving boxes fixed

= 1.3.1 =
* .gitignore problem with lib folder fixed

= 1.3 = 
* SQL injection security fix
* UI language fix
* install fix
* facebook and twitter box separated to "grid social boxes" [Grid Social Boxes](http://wordpress.org/plugins/grid-social-boxes/ "Facebook and Twitter for Grid") plugin
* multisite support
* autocomplete fieldtype performance optimization
* plugin hook for templates added
* plugin hook for editorwidgets
* template rendering optimized
* "Switch to Grid" Button moved to editor sidebar
* implemented uninstall hook

= 1.2 =
* added version info to the facebook and twitter subplugins

= 1.1 =
* Installation issues
* Post type registration fixes on activate

= 1.0 =
* First release

== Upgrade Notice ==

= 2.0.0 =
We removed support for sidebars. If you use grid sidebars they cannot be used anymore.

= 1.9.0 =
There was a bigger refactoring. If you use global variables or classes in your theme or third party plugins please check if they are still working.

= 1.7.11 =
If you use our avoid doublets plugin make sure you update it to version 1.1.2 at least

= 1.7.2 =
Database constraint bug fix.

= 1.3.4 =
Grid works with custom ports on php strict level now

= 1.3.1 =
Some boxes could not be saved. Now they can.

= 1.3.1 =
If you are using git in your project the lib folder was ignore previously.

= 1.3.2 =
Fixes an sql error which occurs when editing reusable boxes or containers.

== Arbitrary section ==

There’s a documentation at doc.the-grid.ws (english is coming soon)


