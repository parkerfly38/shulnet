<?php

/**
 * Establish the plugin's data.
 * id: Plugin ID.
 * name: Plugin's name.
 * description: Plugin description.
 */
$plugin = array(
    'id'                => 'mailgun',
    'name'              => 'Mailgun',
    'description'       => 'Integrates Mailgun with the Zenbership E-Mailing.',
    'author'            => 'Castlamp',
    'author_url'        => 'https://www.castlamp.com/',
    'author_twitter'    => 'castlamp',
    'version'           => '1.0',
    'app_creator'       => 'Mailgun',
    'app_creator_url'   => 'http://www.mailgun.com/',
);

/**
 * Options array. Create an array within the $options
 * array for each widget option.
 *
 * display: Display name
 * value: Value
 * description: Description
 * type: 'text','select','radio','checkbox','timeframe','special','file_size','textarea'
 * width: Width of field
 * maxlength:
 * options: array of options for select or radio, separated by vertical bar "|", or for special, "list:[list_type]"
 */
$options = array();

// New Option
$options[] = array(
    'id'            => 'apikey',
    'name'          => 'API Key',
    'value'         => '',
    'description'   => '',
    'type'          => 'text',
    'width'         => '300',
    'maxlength'     => '',
    'options'       => '',
);
$options[] = array(
    'id'            => 'domain',
    'name'          => 'Mail Domain',
    'value'         => '',
    'description'   => 'This is the domain you set up within Mailgun from which you want to send emails.',
    'type'          => 'text',
    'width'         => '300',
    'maxlength'     => '',
    'options'       => '',
);
$options[] = array(
    'id'            => 'tag',
    'name'          => 'Tag Emails?',
    'value'         => '',
    'description'   => 'Optional, if you would like to tag emails.',
    'type'          => 'text',
    'width'         => '300',
    'maxlength'     => '',
    'options'       => '',
);
$options[] = array(
    'id'            => 'campaign',
    'name'          => 'Mailgun Campaign?',
    'value'         => '',
    'description'   => 'Optional, if you would like emails to be under a Mailgun campaign, input the campaign ID here.',
    'type'          => 'text',
    'width'         => '300',
    'maxlength'     => '',
    'options'       => '',
);

/**
 * Hooks array.
 * trigger:
 * specific_trigger:
 * type: 1 = PHP Include, 2 = email, 3 = MySQL Query, 4 = Function name
 * data:    PHP: path to file.
 *          Email: E-mail array.
 *          MySQL Query: Array of commands to run.
 *          Function: Array of function names to run.
 * when: 1 = before action, 2 = after action
 *
 * Use %path% in the "data" field to let Zenbership
 * determine the correct path.
 */

$hooks = array();

// New Hook
/*
$hooks[] = array(
    'trigger'           => 'login',
    'specific_trigger'  => '',
    'type'              => '1',
    'data'              => '%path%/login.php',
    'when'              => '2',
);
*/

/**
 * Activity Feed
 * Creates a notice in the activity
 * feed when an action takes place
 * in the plugin.
 */

$feed = array();


/**
 * Secure Content
 * Secures content in a specific folder.
 */

$folders = array();

// New Folder
/*
$options[] = array(
    'name'          => 'Member Forums',
    'path'          => '/path/to/forums',
    'url'           => '/forums',
);
*/


/**
 * -------------------------------------------------------------------------
 * Routes
 *
 * Controls potential routing requirements.
 * For example, if you are creating a directory
 * application, you would want to have a "profile"
 * page. You would create a route below as follows:
 *    'path' => '/directory/{username}',
 *    'resolve' => 'myPluginFile.php',
 * This would redirect all requests typed in as
 * http://www.yoursite.com/zenbership_folder/directory/johndoe
 * to the "myPluginFile.php" file, which needs to be inside the
 * plugin's folder. The {username} component would be part of the
 * request as a GET element.
 */

$routes = array();

/*
$routes[] = array(
    'path'          => '/directory/(username)',
    'resolve'       => 'listing.php',
);
$routes[] = array(
    'path'          => '/directory',
    'resolve'       => 'list.php',
);
*/


/**
 * -------------------------------------------------------------------------
 * Anything Else
 */

$db->update_option('email_plugin', 'mailgun');
