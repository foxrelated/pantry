<?php
/* 
------------------
Language: English
------------------
*/

$variables['lang']=array();
$variables['lang']['PAGE_TITLE_HOME'] = 'Home';
$variables['lang']['HEADER_TITLE'] = 'PHPFOX CPR';
$variables['lang']['SITE_NAME'] = 'phpFox Cpr';
$variables['lang']['HEADING'] = 'Heading';
$variables['lang']['CURRENT_LANGUAGE'] = 'Current Language';

// Menu
$variables['lang']['CLEAR_CACHE'] = 'Clear cache';
$variables['lang']['MENU_HOME'] = 'Home';
$variables['lang']['MENU_PLUGINS'] = 'Sample';
$variables['lang']['MENU_PLUGIN_FILES'] = 'Plugin Files';
$variables['lang']['MENU_PRODUCTS'] = 'Products';
$variables['lang']['MENU_SETTINGS'] = 'Core';
$variables['lang']['MENU_GROUPS'] = 'Group';
$variables['lang']['MENU_LOGOUT'] = 'Logout';
$variables['lang']['MENU_LOGIN'] = 'Login';
$variables['lang']['MENU_EMAIL'] = 'Email';
$variables['lang']['MENU_PASSWORD'] = 'Password';


// Home Page
$variables['lang']['HOME_ID']='Home Page';
$variables['lang']['HOME_GREETING']='Welcome to your phpFox First Aid Kit.';
$variables['lang']['HOME_OPEN']='If you are using this then chances are you cannot open your phpfox site.  There may be many reasons for this, but this program can help with some of the more commons problems.';
$variables['lang']['HOME_OPEN1']='This program uses the php PDO extension, so it should work with most database types, but since I have no way of checking anything except mysql, I can\'t guarantee that it will.';
$variables['lang']['HOME_OPEN2']='It uses login authentication based upon your phpfox login information. Just use your normal phpfox website login information to acess this program.  The active session is limited to one hour of no activity before the session is removed.';
$variables['lang']['HOME_OPEN_LEADIN']='There are five pages in this program:';
$variables['lang']['HOME_LIST1_TITLE']='Disable Plugins';
$variables['lang']['HOME_LIST1_ITEM1']='This page will present all of the plugins that were loaded through the Admin control panel and give you the opertunity to deactivate them.';
$variables['lang']['HOME_LIST1_ITEM1_SUB1']='First you may wish to save the configuration, using the left button at the top of the listing. This will store the active/inactive status of the plugins so you can always return to your original configuration. This can be cleared, once set, by clicking the green "Saved" area.';
$variables['lang']['HOME_LIST1_ITEM1_SUB2']='You can disable individual plugins by clicking in the green ACTIVE area in the plugin box.  Once deactivated they can be reactivated from the admincp or by the Restore Inactive Plugins from the right button at the top of the listing.  If you have saved the configuration, it will restore the plugins to their original configuration, otherwise it will turn them all on.';
$variables['lang']['HOME_LIST1_ITEM1_SUB3']='The middle button at the top of the listing will deactivate all plugins.  This is handy if you think a plugin is at fault but do not know which one.  If you deactivate all plugins and your site returns, you can restore them and then disable them one at a time until you find the problem.';
$variables['lang']['HOME_LIST2_TITLE']='Locate Plugin Files';
$variables['lang']['HOME_LIST2_ITEM1']='This page will list all of the plugin files and their locations throughout the file system.  It can often be hard to find code issues when the offending code is located in some other unrelated module.  This will show you where they are.';
$variables['lang']['HOME_LIST2_ITEM1_SUB1']='The phpFox filesystem is scanned for files that are located in the plugin folders.  The filenames are compared against a list of valid plugin hooks and those that do not match are discarded. The filenames that pass this test are presented as hooks (without the .php).';
$variables['lang']['HOME_LIST2_ITEM1_SUB2']='Generally, plugins are located in the /module/module_name/include/plugin/ folder or the /include/plugin/product_name folder.';
$variables['lang']['HOME_LIST2_ITEM1_SUB3']='Although there is no provision to disable the file-type plugins within this program, you can do this by changing the plugin file name via ftp.  For example, if you have a plugin file called "feed.service_process_deletefeed.php" you could rename it to "disabled_feed.service_process_deletefeed.php" or "feed.disabled_service_process_deletefeed.php".';
$variables['lang']['HOME_LIST3_TITLE']='Disable Products';
$variables['lang']['HOME_LIST3_ITEM1']='This page allows you to disable products. It works similarly to the plugin page except it deals with products that you have imported to your site.';
$variables['lang']['HOME_LIST3_ITEM1_SUB1']='You can save the configuration, using the left button at the top of the listing.  This will store the active/inactive status of your products so you can always return to your original configuration.  This can be cleared, once set, by clicking the green "Saved" area.';
$variables['lang']['HOME_LIST3_ITEM1_SUB2']='You can disable individual products by clicking in the green ACTIVE area in the plugin box.  Once deactivated they can be reactivated from the admincp or by the Restore Inactive Products from the right button at the top of the listing.  If you have saved the configuration, it will restore the products to their original configuration, otherwise it will turn them all on.';
$variables['lang']['HOME_LIST3_ITEM1_SUB3']='The middle button at the top of the listing will deactivate all products.  This is handy if you think a product is at fault but do not know which one.  If you deactivate all products and your site returns, you can restore them and then disable them one at a time until you find the problem.';
$variables['lang']['HOME_LIST4_TITLE']='Core Settings';
$variables['lang']['HOME_LIST4_ITEM1']='This page allows you to toggle some key core settings that may cause problems with viewing the site.  These can be toggled on or off as required to restore your site.  If you change a core settings it will probably require clicking the "Clear Cache" button at the top of the left column before checking your site.';
$variables['lang']['HOME_LIST4_ITEM1_SUB1']='You can click the red "INACTIVE" area to enable the setting, or the green "ACTIVE" area to disable it.  Then click the "Clear Cache button and check your site"';
$variables['lang']['HOME_LIST4_ITEM1_SUB2']='The list of available core settings is defined in the /fox_cpr/resources/library/fox_settings.php file.  If you know of a core setting that can kill the site please let me know and I will include it in the file for future updates.  This program can only deal with binary settings at this time.';
$variables['lang']['HOME_LIST5_TITLE']='Group Settings';
$variables['lang']['HOME_LIST5_ITEM1']='Group settings are a little different.  They are primarily controlled from the phpfox_user_group_setting table, but if you change a setting it writes the change to a different table: phpfox_user_setting.  Phpfox will look at both tables to determine the setting to use.  If there is no record in the phpfox_user_setting table for that usergroup and setting number then it will use the value in the phpfox_user_group_setting.  So if a setting is causing problems, it just needs to be deleted from the phpfox_user_setting table.  For the purpose of this program I only present the changed settings for admins in the page display.';
$variables['lang']['HOME_LIST5_ITEM1_SUB1']='Find the user group setting that you think might be a problem and click the bottom portion of the box to make the setting revert to default.  This will result in the box disappearing from the page, so if you want to change it to some other setting you will have to do it from the admin control panel.  Hopefully, you will now be able to reach these settings.';
$variables['lang']['HOME_LIST5_ITEM1_SUB2']='After making changes to the User Group Settings, you should click the "Clear Cache" button at the top of the left column to assure that the default settings are applied before checking your site.';

$variables['lang']['PLUGIN_TITLE']='DEACTIVATE PLUGINS';
$variables['lang']['PLUGIN_MENU_SAVED']='Saved';
$variables['lang']['PLUGIN_MENU_SAVED_TOOLTIP']='Click to clear';
$variables['lang']['PLUGIN_MENU_REMEMBER']='Remember Config';
$variables['lang']['PLUGIN_MENU_ALL']='Set All To Inactive';
$variables['lang']['PLUGIN_MENU_RESTORE']='Restore Inactive Plugins';
$variables['lang']['PLUGIN_ITEM_PLUGIN']='PLUGIN ';
$variables['lang']['PLUGIN_ITEM_MODULE']='MODULE:&nbsp;';
$variables['lang']['PLUGIN_ITEM_HOOK']='HOOK:<br />';
$variables['lang']['PLUGIN_ITEM_TITLE']='TITLE:&nbsp;';
$variables['lang']['PLUGIN_ITEM_ACTIVE']='ACTIVE';
$variables['lang']['PLUGIN_ITEM_INACTIVE']='INACTIVE';
$variables['lang']['PLUGIN_ITEM_TOOLTIP']='Click to deactivate';


$variables['lang']['FILES_TITLE']='PLUGIN FILES';
$variables['lang']['FILES_INTRO']='This page provides a list of all active plugin files showing their paths. Although there is no provision to disable file type plugins, you can do it manually by renaming the file (add some text to the filename like "disabled_" or so).';
$variables['lang']['FILES_HOOK']='HOOK: ';
$variables['lang']['FILES_LOCATIONS']='LOCATIONS: ';

$variables['lang']['PRODUCTS_TITLE']='DEACTIVATE PRODUCTS';
$variables['lang']['PRODUCTS_MENU_SAVED']='Saved';
$variables['lang']['PRODUCTS_MENU_SAVED_TOOLTIP']='Click to clear';
$variables['lang']['PRODUCTS_MENU_REMEMBER']='Remember This Config';
$variables['lang']['PRODUCTS_MENU_ALL']='Set All To Inactive';
$variables['lang']['PRODUCTS_MENU_RESTORE']='Restore Inactive Products';
$variables['lang']['PRODUCTS_ITEM_PRODUCT']='PRODUCT<br /> ';
$variables['lang']['PRODUCTS_ITEM_TITLE']='TITLE:&nbsp';
$variables['lang']['PRODUCTS_ITEM_DESCRIPTION']='DESCRIPTION: <br />';
$variables['lang']['PRODUCTS_ITEM_ACTIVE']='ACTIVE';
$variables['lang']['PRODUCTS_ITEM_INACTIVE']='INACTIVE';
$variables['lang']['PRODUCTS_ITEM_TOOLTIP']='Click to deactivate';

$variables['lang']['SETTING_TITLE']='PHPFOX SETTINGS';
$variables['lang']['SETTING_ITEM_SETTING']='SETTING<br /> ';
$variables['lang']['SETTING_ITEM_DESCRIPTION']='Description:<br />';
$variables['lang']['SETTING_ITEM_ACTIVE']='ACTIVE';
$variables['lang']['SETTING_ITEM_INACTIVE']='INACTIVE';
$variables['lang']['SETTING_ITEM_TOOLTIP']='Click to Toggle on/off';

$variables['lang']['GROUP_TITLE']='GROUP SETTINGS';
$variables['lang']['GROUP_ITEM_VALUE']='Value:&nbsp;';
$variables['lang']['GROUP_ITEM_TOOLTIP']='Click to restore default value';
$variables['lang']['GROUP_ITEM_FALSE']='FALSE(0)';
$variables['lang']['GROUP_ITEM_TRUE']='TRUE(1)';

$variables['lang']['MESSAGES_CACHE_CLEARED']='Cache cleared';
$variables['lang']['MESSAGES_CACHE_NOT_CLEARED']='Cache NOT cleared (locked)';
$variables['lang']['MESSAGES_AUTHENTICATION_FAILED']='Authentication failed! Administrator not found in phpFox. Make sure you are using the email that you used in the phpFox site';
$variables['lang']['MESSAGES_LOGIN_INCORRECT']='Login password/email information incorrect';
$variables['lang']['MESSAGES_LOGOUT_COMPLETE']='Logout completed';
$variables['lang']['MESSAGES_LOGIN_BEGIN']='Login to begin';
$variables['lang']['MESSAGES_CHECK_SERVER_SETT']='Check your server.sett.php file for correct settings.';


?>