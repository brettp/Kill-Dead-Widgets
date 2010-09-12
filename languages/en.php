<?php
/**
 * English strings
 */

$en = array(
	'kdw:intro' => "Kill Dead Widgets finds all widgets displaying the 'This widget is"
		. " either broken or has been disabled by the site administrator.' error and removes them.",

	'kdw:widget_count' => 'Your site has %s dead widgets.',
	'kdw:many_widgets' => 'This is a lot.  To prevent server timeouts and other errors, '
		. 'only 500 widgets will be removed at a time.  You will need to run this multiple times to remove all dead widgets.',

	'kdw:link' => "Kill 'em now!",

	'kdw:success' => 'Successfully removed %s dead widgets!',
	'kdw:failure' => 'Removed %s of %s widgets. Try again.',
	'kdw:all_alive' => 'No dead widgets found!',
);

add_translation('en', $en);