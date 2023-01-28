=== SEO SIMPLE PACK ===
Contributors: looswebstudio
Donate link: https://loos-web-studio.com/
Tags: SEO, meta, analytics, wsebmaster, simple, japan, meta tag
Requires at least: 4.9
Tested up to: 6.1
Stable tag:  3.2.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This is a very simple SEO plugin. You can easily set and customize meta tags and OGP tags for each page.

== Description ==

"SEO SIMPLE PACK" is a very simple plugin for SEO.

- Outputs basic meta tags that are essential for SEO measures.
- It can be set for each page type.
- You can also set the OGP information required for SNS such as Facebook and Twitter.
- You can customize the meta tag information individually for each post, page, and term.
- The output content of each meta tag can also be rewritten with a hook.
- You can easily set the Google Analytics measurement code and Webmaster Tools verification code.

Please see the following page for a detailed explanation of this plugin.

URL: [https://loos.co.jp/en/documents/seo-simple-pack/](https://loos.co.jp/en/documents/seo-simple-pack/)


### Source code

The source code of this plugin is available on Github.

URL: [https://github.com/ddryo/SEO-SIMPLE-PACK](https://github.com/ddryo/SEO-SIMPLE-PACK)


### How to use

After installation, the minimum required meta tags will be output without doing anything. However, it is recommended that you set the following setting items yourself.

- Home page description
- Image of "og:image"
- "noindex" setting for each page type
- Stop author archive setting (if you don't want to access the author archive page)


#### Access to the settings screen

- An item written as "SEO PACK" has been added to the left menu of the WordPress administration screen.
- Click to go to the settings page.
- You can change the settings on the two types of management screens, "General settings" and "OGP settings".


#### Individual settings for each page

The following items can be set individually for Posts / Pages and Term pages such as Categories / Tags.

- "meta robots" tag
- "title" tag
- "meta description" tag
- "meta og:image" tag


### About initial settings

Here are some default settings when you haven't changed the settings.

| Tag                                      | Output contents                              |
| ---------------------------------------- | -------------------------------------------- |
| `<title>` tag on the posts page          | Site name &#124; Tagline                     |
| `<description>` tag on the Home page     | Tagline                                      |
| `<title>` tag on the Posts / Pages       | The title of the page &#124; Site name       |
| `<description>` tag on the Posts / Pages | Automatically generated from the content of that page |


| Status         | Which page it is applied to                     |
| -------------- | ----------------------------------------------- |
| `noindex`      | Each archive page, 404 page, Search result page |

For other information, please check the actual setting screen.


== Installation ==

1. Enter SEO SIMPLE PACK in the plugin search field.
2. Once you find this plugin, click "Install Now" to install and activate it.


== Frequently Asked Questions ==

= The title tag is output twice =

The `title` tag output in wp_head (`_wp_render_title_tag`) is deleted, but if it is written directly in `<head>`, it will be duplicated.

Remove the handwritten `title` tag.

= How to overwrite the output on a particular page? =

Most of the output tags use filter hooks, so you can overwrite them with `add_filter`.

The following hooks are available.

- 'ssp_output_title'
- 'ssp_output_robots'
- 'ssp_output_description'
- 'ssp_output_canonical'
- 'ssp_output_keyword'
-  and more...


== Screenshots ==

1. "Basic settings" screen
2. "Google Analytics Code setting" screen
3. "OGP settings" screen
4. Help page
5. Post page setting screen
6. Category page setting screen


== Changelog ==

= 3.2.0 =
- Added 'ssp_output_og_image' hook.

= 3.1.1 =
- Minor bug fixes.

= 3.1.0 =
- For Google Analytics, both GA4 and UA can now be set.
- Fixed a bug that prevented page numbers from being displayed in the title tag.
- Fixed a bug regarding canonical for the Page specified in the "Posts page".

= 3.0.0 =
- Added `'ssp_replace_snippet_{snippet_name}'` hook. (You can now define custom snippets)
- Changed some snippet names. (The previous snippet name also works.)
- Changed settings for Post Format archives to only show when Post Format support is enabled.
- Refactored the code.

= 2.5.1 =
- Replaced do_shortcode() with strip_shortcodes() when generating descriptions.

= 2.5.0 =
- Add get_front_data().

= 2.4.2 =
- Minor bug fixes.

= 2.4.1 =
- Support for WordPress 6.0.

= 2.4.0 =
- Add feed_noindex setting.
- Fixed meta tag in `is_home` page with negative `cat` value

= 2.3.1 =
- Add strip_tag before outputting title tag.

= 2.3.0 =
- Fixed readme.txt file.

= 2.2.9 =
- Support for WordPress 5.9.
- Minor bug fixes.

= 2.2.8 =
- Fixed og:type on front page.
- Fixed to not save empty custom fields.

= 2.2.7 =
- Changed the number of characters when automatically generating a description.
- Added 'ssp_description_word_count' hook.

= 2.2.6 =
Bug fixes

= 2.2.5 =
Fix the canonical tag on front page.

= 2.2.4 =
- Support for WordPress 5.8.
- Changed the default value of "tw_card" to `'summary_large_image'`.

= 2.2.3 =
Adjusted the design of the setting page a little

= 2.2.2 =
- Support for WordPress 5.7.
- Support for PHP 8.0.

= 2.2.1 =
Bug fixes

= 2.2.0 =
Added canonical tag settings for each page.

= 2.1.1 =
Bug fixes

= 2.1.0 =
Added get method: `\SSP_Output::get_meta_data( 'meta_name' )`

= 2.0.0 =

- You can now set "og:image" for each page.
- Added 'ssp_output_og_site_name' hook
- English is supported.
- Adjusted the design of the setting page a little


= Earlier versions =
See: https://github.com/ddryo/SEO-SIMPLE-PACK
