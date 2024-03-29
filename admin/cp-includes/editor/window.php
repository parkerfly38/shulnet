<?php 



/**
 * Template and content editor.
 *
 * Zenbership Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Castlamp
 * @link        http://www.castlamp.com/
 * @link        http://www.zenbership.com/
 * @copyright   (c) 2013-2016 Castlamp
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     Zenbership Membership Software
 */
// Load the basics
require "../../sd-system/config.php";
$task = 'activate';
// Check permissions and employee
$admin    = new admin;
$employee = $admin->check_employee($task);
// Content or template
$changes          = array();
$template_content = new template($_GET['id'], $changes, '1', '', '', '1', '1');
/*

// Header

if (! empty($template_content['custom_header'])) {

    //$header_in = $db->template_data($template_content['custom_header']);

    //$header = $template_content['content'];

    $header = new template($template_content['custom_header'],$changes,'0');

} else {

    $header = new template('header',$changes,'0');

}



// Footer

if (! empty($template_content['custom_footer'])) {

    //$footer_in = $db->template_data($template_content['custom_header']);

    //$footer = $template_content['content'];

    $footer = new template($template_content['custom_footer'],$changes,'0');

} else {

    $footer = new template('footer',$changes,'0');

}

*/
$jscss = '<script type="text/javascript" src="' . PP_URL . '/admin/js/editor/modernizr-2.0.6.min.js"></script>';
$jscss .= '<script src="' . PP_URL . '/admin/js/editor/raptor.0deps.js"></script>';
$jscss .= '<script type="text/javascript">var content_id_editing = "' . $_GET['id'] . '";</script>';
$jscss .= '<script src="' . PP_URL . '/admin/js/editor/loader.js"></script>';
$template_content = str_replace('</head>', $jscss . '</head>', $template_content);
echo $template_content;
exit;