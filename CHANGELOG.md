# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [3.6.3] - 2022-10-08

### Changed
- This is the last release to support PHP 7.4. All future release will require PHP 8+
- Improved Display of Tabs on Edit Listing Template Field Dialog.
- Fixed display of * on required fields on listing, agent, and lead field editor screens.
- Fixed incorrect isplay of required status as no, even if it was yes on lead and listing field editor dialogs. [#139](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/139)
- Fix php error in user__create api
- Fix Admin Site Config Forms now displaying template tags.
- Fix ability to collapse listing media widget image pane after initial load.
- Fix ability to collapse user media widget image pane after initial load.
  - Media widget now loads thumbnail images instead of main images and acceptance test added for this.. [#144] (https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/144)
- Google Auth was not calling set_session_vars() so login was failing to authorize user.
- Improve permission checks in listing__delete api
- Fix error handling in listing__delete api that caused api call to die() instead of returning an error.
- Fix error in uploading images in media__create api.
- Improve user__delete api, to remove userdb entry last, to ensure we do not orphan objects if errors occur.
  
### Security
- Install yarn updates, pull is security fix for node-sass
- Set autocomplete and spellcheck attributes on all password and user_name fields.
  
### Misc
- Start Adding some more unit tests
- Start adding User API Integration Test
- Start adding Acceptance/Browser Test
- Start Adding Listing API Integration tests
- Get Acceptance Test w/ code coverage working in CI.
- Add Acceptance test for media widget behavior in [#143](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/143)
- Improve Setup/Teardown for Integration Test
- Add user media widget acceptance test and fix flaky test for media widget listing & user.
- Bundler should not package c3.php or tests for releases.
- Start adding unit test for Login, and standardize our test setups and documentation.
- Misc Code Documentation, Cleanup, adding unit tests.
- Start adding User API Integration tests.
- Improve Node Cache for Docker and CI

## [3.6.2] - 2022-09-14
### Changed
- Edit All Leads was missing in menu.
- Fix display of all leads table, which was empty.
- Fix Listing Template Editor duplicating fields when you edit an existing field.
- Fix Listing Template Editor not setting yes/no fields, like required correctly. [#125](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/125)
- Improved HTML Form Validation and fixes issues with validation of required checkboxes. [#122](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/122)
- Fix PHP errors when manual addon form is submitted with file upload errors.  
- Make userfile field required for form submit on manual addon upload.
- Admin,Agents, and Members can now login with Google OAuth.
- Remove stray '] chars from site config listing tab.
- If usering Google Auth and signup is enabled, user will be automatically signed up.
- Fix error in listing__search api, when no limit was passed.
- Fix error in user_manager, when deleting a user that prevent page from reloading.
- Fix error in listing_update API that allowed an agent to change the listing agent when they did not have edit_all_listing. They could only change this for their current listing, but this is not correct behavior.  [#136](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/136)
- Fix update_listing function allowing a POST without an or_owner field set.  [#137](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/137)
- Fix edit_listings.html template should set a hidden field for or_owner when an agent without edit_all_listing is editing.  [#135](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/135)

### Security
- Passwords are now hashed in database using modern password_hash() function instead of md5()
- User passwords will be updated to new hash automatically on next user login.
- Remember Me cookies update to use a more secure method, old cookies will not work forcing a new login.

### Misc
- Update PHP Dependencies (twitteroauth, qrcode, phpmailer, and others)

### Languages Updates
- Updates to Portuguese (br - brazilian) language. Thanks to ebmarques for contributing.
- Additional language text for 
  - checkbox_invalid
  - invalid_value
  - google_login
  - google_auth_invalid
  - site_config_google_authentication
  - google_client_secret
  - google_client_secret_desc
  - google_client_id
  - google_client_id_desc
  - listing_error_invalid_agent

## [3.6.1] - 2022-09-03

### Changed

- Fix .htaccess RewriteCond that broke seo friendly urls.
- Fix some HTML/JS validation warning in the admin template.
- Fix undefined variable is listing\__update api call [#119](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/119)
- Fix baseurl tags in the material template.

### Misc

- Update gitpod settings, to have name & descriptions for ports.

## [3.6.0] - 2022-08-13

### Security

- Fix CVE-2022-31129 Upgrade Moment JS, Inefficient Regular Expression Complexity
- Improve DAST Scanning
- Improve SAST Scanning (Disable some PHPCS rules)
- Added Anti-CSRF protection on edit_listings form.
- Added Anti-CSRF protection on media upload form.
- Added Anti-CSRF protection on media edit form.
- Security Patch Jquery UI 1.13.2 - CVE-2022-31160
- Added Anti-CSRF protection on edit page form.
- Added Anti-CSRF protection on edit_user form.
- Added Anti-CSRF protection on email a friend form.
- Added Anti-CSRF protection on add page form.
- Added Anti-CSRF protection on insert property class form.
- Added Anti-CSRF protection on site config forms.
- Added Anti-CSRF protection on add blog form.
- Added Anti-CSRF protection on the blog_wpinject form.
- Added Anti-CSRF protection on the add_blog_category_form form.
- Added Anti-CSRF protection on the add_blog_tag_form form.
- Added Anti-CSRF protection on the send_forgot form.
- Added Anti-CSRF protection on the edit_blog_tag_form form.
- Added Anti-CSRF protection on the edit_blog_category_form form.
- Added Anti-CSRF protection on the menu_selection_form form.
- Added Anti-CSRF protection on the add_menu_form form.
- Added Anti-CSRF protection on the add_item_form form.
- Fix Code Injection Warning in FileManager
- Added Anti-CSRF protection on the ajax_save_user_rank call.
- Added Anti-CSRF protection on the modify_pclass_form form.
- Added Anti-CSRF protection on the site_config_tracking form.
- Added Anti-CSRF protection on the addon_manager manual upload form.
- Added Anti-CSRF protection on the edit listing quick filter forms.
- Added Anti-CSRF protection on the user manager quick filter forms.

### Changed

- Make js look for class copyright_year instead of ID, when inserting current year.
- Upgrade abraham/twitteroauth to v4.
- Fix SameSite setting on php session cookie, that broke twitter auth.
- Fix pagination on edit_listings, so it returns 403 access denied if you exceed max cur_page
- Fix pagination on user_manager, so it returns 403 access denied if you exceed max cur_page
- Misc Yarn/Composer Updates
- Improve .htaccess and admin/.htaccess
- Fix pagination on edit_listings & user_manager to handle cur_page < 0
- Removed some dead code from ckeditor filemanager.
- Fixed duplicate JS calls on page editor, resulting in duplicate saves..
- Removed Jquery Cookie library, which we no longer use.
- Load JQuery on popup and printer friendly pages.
- Fixed handling of wpinjectform and removed use of ajaxForm plugin
- Fix switching menus in menu editor, selection didn't work after initial menu.
- Fixed pagination but on edit listing and user manager when using filters.
- Fixed wpinject php errors.
- Remove use of ajaxform in media_upload and ckeditor filemanager.
- Remove jquery form plugin

### Template

- admin/template/default/add_lead.html - Remove reference to {template_url}/images/ajax-loader.gif
- Add missing blog_edit_comments.html template

## [3.6.0-beta.1] - 2022-07-05

### Fixed

- Updated Composer Install
- Update Composer Installer to handle composer version upgrades without breaking CI
- Update Security Scanners for Gitlab 15.
- Update dependencies
- Enable load_js and load_js_last for admin, as we have addons that still use it.
- Remove uneeded js from blog_editor.
- The controlpanel_template field in site config, was readonly.
- Fix duplicate DOM Ids on controlpanel form.
- Improve autocomplete on login form.
- Remove deprecated call to jqueryUI accordion() in lead editor.
- Remove document.write call to clear Chrome warning.
- Add CSP Headers for admin area to help improve security.
- Removed console.dir() debug logs.
- Fixed Generic Object Injection Sink vulnerability in lead editor.
- Fix height of vertical navbar
- Fix highlight of active page on vertical navbar.
- Fix package command, that was not compiling CSS..
- Fix text on page editor revert changes prompt.

### Languages Updates

- Add descriptions for lat/long fields.

## [3.6.0-alpha.2] - 2022-04-07

### Fixed

- Login Reset Form showed a SQL error, and always reported that reset link was invalid.
- Login form now displays forgot password form. [#110](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/110)
- Add a check_allow_agent_signup tag for permissions checks.
- Address Blog/Page autosave issues. [#112](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/112)
- Update Addon Manager to use ZipArchive function instead of zip_open..
- Fix tabs on addon_manager
- Update OneClickUpgrade to use ZipArchive function instead of zip_open..
- Removed support of "RSXM" format remote API. This removes usages of mcrype in api. Added "RSXM2" which is same format as "RSXM" without the built in encryption. Remove API should only be used on sites that use HTTPS to prevent secrets from being passed in clear.
- Bump some dependencies with minor updates.
- Add missing popup.html template files. [#87](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/87)
- Fix handling of 'notfound' in magicuri parsing, to return admin index page.
- Fix Undefined Languages on site config social.
- Fix DAST Scanning
- Address Generic Object Injection Sink vulnerability in template editor
- Fix ESLint rule ID security/detect-non-literal-regexp in filemanager.js
- Update Dependencies
- Remove wysiwyg_execute_php setting, which was deprecated.
- Remove apikey setting, which is not longer used.
- Remove vtour_fovcontrolpanel_vtour_fov
- Fix issue saving controlpanel_search_list_separator
- Fix issue saving controlpanel fields that contained HTML

## [3.6.0-alpha.1] - 2022-03-12

This is our first developer release Open-Realty 3.6.0. This is NOT a production-ready release. This release is intended to let developers start working to update addons and help test our new admin template.

### Changed

- New Bootstrap5 Admin Template Based on [Material DashBoard by Creative Tim](https://github.com/creativetimofficial/material-dashboard)
- Removed usage of ORBetterSerialze JQuery Plugin
- Removed usage of Jquery UI in the admin area.
- Removed usage of Jquery Validation Plugin in the admin area.
- forms.inc.php now outputs Bootstrap styled forms
- Removed cms_admin_integration template.
- Added `{check_action_(.*?)}` and `{!check_action_(.*?)}` tags. This will let you display/hide content in a template based on the OR action being performed. Eg `{check_action_index}I am an index{/check_action_index}` will show `I am an index` if the index page is being loaded. Useful for controlling CSS, etc in menus.

### Languages Updates

- We are now managing language translations using Crowdin. Anyone interested in helping proofread translations can signup at https://translate.open-realty.org/
- There were many new language variables added as part of the template work. The goal is to have 100% language coverage of the admin area for the 3.6.0 release.
- Spanish, Brazilian Portuguese, and Portuguese languages now ship with 3.6.0-alpha.1

### Template Changes

- **All Admin Templates Files (Old Templates will not work)**

## [3.5.10] - 2022-02-20

- Fixed error in one-click upgrade.
- Improve directory detection in zip extraction

## [3.5.9] - 2022-02-19

- Fixed PHP Notice errors on send_notifications cron.
- Fix some ADODB errors
- Add additional error logging for one-click upgrade.
- Verify SSL certificates when loading API, get_url, and remote media.

## [3.5.8] - 2022-02-05

### Changed

- Enable ability to run cron jobs that require auth, via the CLI instead of running them via the web which requires CSRF Tokens.

  Instead of calling  
  `curl -d "user_name=ORADMINUSER&user_pass=ORADMINPASSWORD" http://www.yourdomain.com/admin/ajax.php?action=generate_sitemap`

  you can now call

  `php src/admin/index.php 'user_name=ORADMINUSER&user_pass=ORADMINPASSWORD' 'action=generate_sitemap'`

### Fixed

- Twitter Auth is working again.
- VTour Support is working again. Open-Realty now only supports using Equirectangular jpg for virtual tours. We no longer support the old .egg files. On Android, you can take "Photo Sphere" images to produce Equirectangular images. We use pannellum javascript to display images now.

## [3.5.7] - 2022-02-03

### Fixed

- Fixed SQL error in new listing creation.

### Other

- Update to Makefile to support creating devignoreinstall file

## [3.5.6] - 2022-02-02

### Fixed

- Missing `$misc` global variable in fields\_\_value API calls. [#104](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/104)
- Improved HTTPS protocol detection in installer when determining baseurl.
- Fixes Linking to files in Page Editor. [#105](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/105)

### Other

- Autodocumented Makefile and set .PHONY
- Added Default issue template for Gitlab

## [3.5.5] - 2022-01-29

### Fixed

- SECURITY: Fixes possible SQL injection from improper use of addslashes()
- Fix redirect to installer
- Update PHP Dependencies
- Fixed PHP errors during media upload for vtours.
- Fixed display of field values for user information on the edit_user screen.
- Fix some misc PHP errors caught during code cleanup.

# Developer Changes

- Update Makefile to fix RUN_CMD detection on windows.
- More cross-platform improvements for Makefile & docker-compose.
- Support for running a development environment on Gitpod.io
- Cleaned up grammar in the CHANGELOG.md and README.md files.
- Enable the intelephense extension in gitpod.
- Reenable xdebug support in docker-compose.
- Added PHPMyAdmin to docker-compose setup.

## [3.5.4] - 2022-01-15

### Fixed

- Fixed some E_NOTICE errors with Contact Form
- Fix some e_warning errors with the view lead pagination
- Fix an error in the login code for storing user data in sessions
- Try to ensure we are running E_ALL error reporting if devignoreinstall is present
- Update Build images to use latest PHP 8 docker image with development-ini enabled.
- Fix warning errors that were breaking the ability to edit media in the media widget.
- Fix PHP error if you try to display a field with get_listing_single_value() that the user does not have access to.
- Fix makefile errors on windows and update README.md with windows development directions.
- Simplify Local Dev to run make commands in a container by default, to reduce the need for installing PHP, Node, Yarn all on the local machine.

## [3.5.3] - 2021-12-30

More security improvements and bug fixes.

### Fixed

- SECURITY: Fix File Path Traversal in Filemanager jqueryFileTree.php
- DEPRECATED: Ability to enable execution of PHP Code in WYSIWYG editor. This feature is a BAD idea and is going away in 3.6.0. Use Addons instead of writing PHP in the WYSIWYG pages/blogs.
- Delete Item on the menu editor was not working.
- Minor JS cleanups.
- Add CSRF Tokens to agent & member signup forms
- Added Xdebug config to docker-compose to support local debugging.
- Add CSRF Tokens to login forms.
- Added CSRF Tokens to Template Switcher
- Template switcher no longer support GET vars you must use POST
- Mobile Template Changer `{mobile_full_template_link}` only shows if allow_template_change is enabled.
- Add CSRF Tokens to the contact agent form.
- Cleanup contact agent form code, remove pro & free templates and replace with a new default template.
- Fix SQL Errors in replace_search_field_tags()
- Fix JS for Flex, Lazuli, and Mobile Template
- Code review for PHP_CodeSniffer warnings, and setting ignores where safe.
- Add CSRF Tokens to save search form
- Fix handling of duplicate saved searches
- Fix broken links when duplicate saved searches occur.

### Template Changes

- admin/template/default/login.html
- admin/template/default/menu_editor_index.html
- template/default/agent_signup.html
- template/default/contact_agent_default.html (Added)
- template/default/contact_agent_free.html (Deleted)
- template/default/contact_agent_pro.html (Deleted)
- template/default/login.html
- template/default/member_signup.html
- template/default/saved_searches_add.html
- template/flex.main.html
- template/html5/featured_listing_horizontal.html
- template/html5/listing_detail_default.html
- template/lazuli/main.html
- template/mobile/main.html
- template/mobile/page_1.html
-

### Language Changes

- Removed `$lang["incorrect_password"]`
- Removed `$lang["nonexistent_username"]`
- Updated `$lang["wysiwyg_execute_php_desc"]`
- Updated `$lang["allow_template_change_desc"]`
- Added `$lang["invalid_csrf_token"]`
- Added `$lang["signup_already_logged_in"]`
- Added `$lang["incorrect_username_password"]`

## [3.5.2] - 2021-12-22

After hearing from some users that the upgrade to PHP 8 was not possible currently on their hosting providers, we have changed the minimum requirements back down to PHP >7.4.3. There are no other changes in this release.

### Changed

- Rebuild for PHP > 7.4.3
- Update installer to check for PHP 7.4.3 instead of 8.0 when checking requirements.

## [3.5.1] - 2021-12-19

Some important bug fixes.

### Fixed

- Blog & Page Editors Not Loading
- Improvement to pingback registration, including a fixed bug where registration failed if you were not using SEO URLs
- Fix MagicParser for SEO URLs
- Fix a bunch of code bugs found via IntelliSense.
- Update phpxmlrpc to v4.
- Upgrade browscap-php to v6
- Update Timezone list

## [3.5.0] - 2021-12-15

The focus on 3.5.0 is updating the open-realty jquery and other dependencies, improving security, and bug fixes. All users are strongly recommended to upgrade. Please note that third-party templates may need to be upgraded/adjusted as part of this due to the dependency upgrades.

### Added

- Improved CI Builds to start running unit test & code coverage.

### Changed

- PHP Libarary Changes
  - Replace aferrandini/phpqrcode library endroid/qr-code library and phpqrcode was no longer maintained.
  - Replaced dapphp/securimage with gregwar/captcha, as dapphp/securimage was no longer maintained.

### Fixed

- CKEditor Filemanager
  - Fix bug in root folder protection
  - Fix Generic Object Injection Sink warnings
- Log Viewer
  - Remove Dead Code
  - Fix Generic Object Injection Sink warnings

## [3.5.0-beta.1] - 2021-12-04

The focus on 3.5.0 is updating the open-realty jquery and other dependencies, improving security, and bug fixes. All users are strongly recommended to upgrade. Please note that third-party templates may need to be upgraded/adjusted as part of this due to the dependency upgrades.

### Fixed

- SECURITY PATCH: Fixed a file exposure bug in the CKEditor Filemanager plugin.
- There were several other security bugs fixed in the js library upgrades etc.
- Several possible undefined var errors
- Cookies are not HTTP only, improving security
- Enabled Security Scanning for CI
- Fixed menu editor dropdown for Blog / Page selection not working
- Fix colorbox that broke with the latest jquery version.
- Update php-cs-fixer to format the CKEditor filemanager plugin
- Removed Old Jquery Versions
  - Remove Jquery 1.7.1
  - Remove jquery-1.2.6 from CKEditor filemanager plugin
- Removed JQuery Tools - This Change the Slideshow, Featured Listings, and Listing Statistics templates.
- Moved CKEditor installation from composer to yarn.
- Moved Third Party JS Packages to YARN and updated versions
  - superfish.js
  - jquery.uniform
  - CKEditor-youtube-plugin
  - CKEditor-quicktable-plugin
  - ckeditor4
  - jquery.splitter
  - jqueryfiletree
  - jstree
  - tablesorter
  - jquery.impromptu
  - jquery-filedrop
  - lightSlider
- Removed js-tree package that was not being used.
- Update CKEditor Plugins
  - YouTube
  - TableResizer
  - QuickTable
  - Open-Realty Filemanager

### Template Changes

- admin/template/OR_small/main.html
- admin/template/default/addon_manager.html
- admin/template/default/blog_edit_index.html
- admin/template/default/listing_template_editor.css
- admin/template/default/menu_editor.css
- admin/template/default/menu_editor_index.html
- admin/template/default/site_config_general.html
- template/default/listing_detail_slideshow.html
- template/default/saved_searches.html
- template/default/style_default.css
- template/html5/admin_bar.css
- template/html5/featured_listing_horizontal.html
- template/html5/lib/MIT-LICENSE.txt (DELETED)
- template/html5/lib/jquery.uniform.min.js (DELETED)
- template/html5/lib/superfish.js (DELETED)
- template/html5/listing_detail_default.html
- template/html5/main.html
- template/html5/popup.html
- template/html5/style.css
- template/lazuli/main.html
- template/lazuli/popup.html
- template/mobile/main.html
- template/mobile/page1_main.html

## [3.4.3] - 2021-11-25

Security Fix for moment.js, vcard support, more PHP8 fixes

### Fixed

- Agent vcard download reenabled
- moment.js - SECURITY FIX
- Fix Blog Count
- PHP 8 / ADODB Fixes.

## Changed

- Javascript Library Update
  - Jquery 3.6
  - moment.js
  - fullcandar v3
- Updated php-cs-fixer
- Updated docker-compose.yml to support testing mysql8 and mariadb 10.7

## Changed

## [3.4.2] - 2021-11-21

Initial Support For PHP 8.

### Fixed

- Fixed numerous PHP 8 warnings
- Fixed Banned IP/Domain Detection on PHP 8
- Fixed Bug in Listing Field Create that required a Search Type Set
- Many other small bug fixes related to the PHP Warning Fixes.

### Template Changes

- admin/template/default/site_config_users.html Changed {lang_agent_default_canChangeExpirations_desc} to {lang_agent_default_canchangeexpirations_desc}
- admin/template/default/view_logs.html Changed {lang_log_viewer\_} to {lang_log_viewer}

## [3.4.1] - 2021-03-04

### Changed

- [#15](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/15) get_latest_releases now caches response from server.
- [#16](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/16) Improve Logging when get_url calls fail
- JQuery Form upgraded and now installed via yarn.

### Fixed

- [#14](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/14) Autoupgrade was not correctly running DB upgrades and bumping version number.
- [#17](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/17) Do not override .htaccess during upgrade.

### Template Changes

- admin/template/default/blog_edit_index.html Javascript for Blog Index is now part of the template.

## [3.4.0] - 2021-02-21

Our first stable release under the new MIT license. Only changes since beta 4 are included in this changelog, see beta changelogs for a full set of changes.

### Fixed

- Removed browser debug output on-page, if tracking is enabled.
- Fix broken div on pages with securimage captchas.
- No longer show "default" template folder for template selection in site config.
- No longer show property class-specific template for listing template selection in site config.

### Template Changes

## [3.4.0-beta.4] - 2021-02-19

Here we write upgrading notes for Open-Realty. It's a team effort to make them as
straightforward as possible.

### Added

- [#6](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/6) Docs updated to include directions for [updating browsercap_cache](https://docs.open-realty.org/nav.guide/04.automating_tasks/browsercap_cache.html)

### Fixed

- Site Statistics recording fixed.
- [#11](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/11) Removed calls to deprecated get_magic_quotes_gpc()
- [#12](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/12) Missing /files/browsercap_cache folder added to package.
- [#10](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/10) Installer was checking for an old version of PHP updated to PHP 7.4.0 > as per current requirements.
- [#13](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/13) Addon Manager now allows easy download of addons.

### Template Changes

- admin/template/default/popup.html - Fixed CSS call to use load_css to ensure we load from default it CSS does not exist in template.

## [3.4.0-beta.3] - 2021-02-13

### Added

- Add docs to the readme on how to run from source.

### Changed

- Improved CI performance.
- Removed Dockerfile, we now have a prebuilt docker image to save compile time on CI runs and local development.
- Added Test to CI to ensure version number is set correctly when we tag a new release.
- Updated README.md with correct PHP version requirements.
- Upgrade a notice now shows the version you will upgrade to.

### Fixed

- The installer had an error when inserting data into userdb, due to a missing field in an insert.
- Improved RSS Feed compatibility with Readers. We comply with Atom Spec now. For existing users check your RSS Descriptions in the Social tab in site config. Replace any use of `{image_thumb_1}` with `{image_thumb_fullurl_1}` to improve compatibility.
- Auto Upgrade Feature now works for open source releases, using Gitlab API.

### Template Changes

- templates/default/rss.html

## [3.4.0-beta.2] - 2021-02-11

### Fixed

- [#1](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/1) Addon and Files folders were missing from the install package
- [#2](https://gitlab.com/appsbytherealryanbonham/open-realty/-/issues/2) common.dist.php file was missing
- The vendor path was set incorrectly in common.php during installation.
- Fix API offset null error error
- Fix $display not set error in listing display.

## [3.4.0-beta.1] - 2021-02-08

### Added

- PHP 7.4 support
- We now use composer to install PHP dependencies.
- We now use yarn to install javascript dependencies. (80% Migrated)
- We use https://www.mortgagecalculator.org/ for our mortgage calculator
- Large code cleanup effort, much more still needed.

### Changed

- Project is now released under MIT license.
- Project is housed on Gitlab
- Update ADODB
- Update reCaptcha
- Updated Securimage
- Updated ckeditor
- Updated phpMailer
- Update DataTables
- Update Twitter Auth
- Update Jquery for Admin
- Update Jquery UI
- Updated twitteroauth
- Updated colorbox
- Updated jquery.cookie

### Fixed

- Fixed a bug in the user API update method that unnecessarily updated the Activity log when an unauthenticated user attempted to use it.
- Fixed a bug that prevented the listing ID from being passed to the Listing Detail page's printer-friendly link, email to a friend link, and the add favorites link
- When the user functions were refactored for v3.3 we inadvertently broke the ability of the admin to complete a lost password reset operation
- The jQuery form validation would not allow an empty field type: Date if the field was not set to be required.
- OR v3.3 upgrade functions would not upgrade the DB when upgrading from v3.2.7
- The slideshow template's block tags were not being properly cleaned-up if a listing had no photos.
- get_featured_raw template tag was inadvertently disabled due to recent refactoring
- Agent signup was not always sending signup notifications to the Admin and to the person signing up when account moderation was active this was a side-effect of recent PDO refactoring.
- Improved error_reporting for the Field API and PHPmail function.
- Improved the lost password reset email validation check
- Removed deprecated agent_login_link tag from agent_activation_email.html. replaced with baseurl/admin
- Fixed the listing hit counter. This was broken for unauthenticated site visitors due to code refactoring in OR v3.3
- Update Media handling to deal with Protocol-relative URLs \
- Fixed session handling for Securimage
- Fixed extra DB connection used by Adodb sessions
- Fixed Agent hit counter that was broken due to prior refactoring
- Fixed email validation that did not handle some email addresses correctly.
- Removed deprecated calculator and javascript library
