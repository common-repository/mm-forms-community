=== MM Forms Community ===
Contributors: tbelmans, ZetaTwo
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6044941
Tags: forms, email, ajax, captcha, akismet
Requires at least: 2.5
Tested up to: 3.3
Stable tag: trunk

MM Forms is not just another contact form plugin!

== Description ==

<strong>MM Forms is the easy form builder for Wordpress.<br />
Easy, yet not simple.</strong>

MM Forms  comes with the power of a tank, but drives like a bike.<br />
Anyone who has the knowledge to connect to the internet will be able to create web forms with MM Forms.
Sounds easy, right?

But it ain't simple!

MM Forms has some basic features like :<br />
<ul>
<li>field creator</li>
<li>customize form and mail contents with simple markup</li>
<li>html layout possible</li>
<li>Spam filtering with Akismet</li>
<li>captcha prevention</li>
<li>multiple, not to say unlimited contact forms</li>
</ul>

But offcourse it also kicks some ass with the following cunning features : <br />
<ul>
<li>automatic thank you e-mail after a submission</li>
<li>Save form submissions to database</li>
<li>Export to CSV of submissions</li>
<li>RSS feed of form submissions</li>
<li>Send HTML formatted emails</li>
<li>Easy insert forms in posts/pages via TinyMCE button</li>
<li>Add your own customized HTML form code instead of using the build-in field creator, giving you more flexibility and control on form behaviour</li>
</ul>

Derivative work from Contact Form 7, written by Takayuki Miyoshi

== Installation ==

1. Upload whole "mm-forms-community" folder to the "/wp-content/plugins/" directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure that /exports, /captcha/tmp and /exports are writeable

See also: [plugin homepage](http://plugins.motionmill.com/mm-forms/)

== Frequently Asked Questions ==

How Contact Form can be added in my Theme files (sidebar.php etc)?
You can add your created Contact Form in your Theme files just by calling a very simple function as shown below 
<?php insert_mm_form('Form Name'); ?>

Now for Example you have created a form with the name 'Email Form' then you would have to call the function like as below
<?php insert_mm_form('Email Form'); ?>

If you have questions about MM Forms,
please submit them on our plugins page : http://plugins.motionmill.com/mm-forms/

== Changelog ==

Version 2.0.0

- Shortcode added to display the total number of submissions
	Use : [mmf_total_submissions form_id="1"] in a post or page to display the total submissions

Version 2.1.0

- Added support for Wordpress 3.  Thanks to Bram Esposito for his excellent knowledge of Javascript and JSON.

Version 2.2.0 

- Added support for WordPress 3.2.x

Version 2.2.1

- Image uploader fixed for IE 8 and IE 9

Version 2.2.2

- Added jquery updated files.  Note that these files should be placed in your WordPress wp-includes/js/jquery folder

Version 2.2.3

- Bugfix : direct file access to ajaxfileupload forbidden : http://packetstormsecurity.org/files/view/104009/wpmmforms-shell.txt

Version 2.2.4

- Bugfix: Changed paths to use wordpress URL& path variables.
- Performance: Changed export to CSV to reduce load on database server.

Version 2.2.5

- Bugfix: Changed paths to use wordpress URL & path variables.

Version 2.2.6

- Bugfix: Fixed file uploads. Still looks strange for non-images.
- Cleanup: Removed the jQuery updates as they are no longer required.
- Other: Added empty directories for exports and uploads
- Other: Changed named to MM Forms Community

Version 2.2.7

- Security: Fixed a major security flaw

== Licence ==

This plugin is free for everyone! Since it's released under the GPL, you can use it free of charge on your personal or commercial blog.

== Your comments ==

Tell us what you think of this plugin on http://plugins.motionmill.com/mm-forms
