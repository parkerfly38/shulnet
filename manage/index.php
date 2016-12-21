<?php

/**
 *    Zenbership
 *    http://www.zenbership.com/
 *    (c) 2012, Castlamp.
 *
 *    Purpose: User management page.
 *
 *    WARNING!
 *    DO NOT EDIT THIS FILE!
 *    To change the calendar's
 *    apperance, please edit the
 *    program templates from the
 *    "Integration" section of the
 *    admin control panel.
 *
 */
// Load the basics
require "../admin/sd-system/config.php";
// Check a user's session
$session = new session;
$ses     = $session->check_session();
if ($ses['error'] == '1') {
    $session->reject('login', $ses['ecode']);
    exit;
} else {
    $user = new user;
    $udata = $user->get_user($ses['member_id']);
    /**
     * Pagination
     */
    $add_get = array();
    $filters = array(
        'ppSD_content_access.member_id' => array('scope' => 'AND', 'value' => $ses['member_id'], 'eq' => 'eq'),
        'ppSD_content_access.expires'   => array('scope' => 'AND', 'value' => current_date(), 'eq' => 'gt'),
        'ppSD_content.display_on_usercp'   => array('scope' => 'AND', 'value' => '0', 'eq' => 'eq'),
    );
    $join    = array(
        'table'    => 'ppSD_content',
        'on'       => 'id',
        'table_id' => 'content_id'
    );
    if (!empty($_GET['organize'])) {
        if ($_GET['organize'] == 'expires') {
            $_GET['order'] = 'ppSD_content_access.expires';
            $_GET['dir']   = 'DESC';
        } else if ($_GET['organize'] == 'started') {
            $_GET['order'] = 'ppSD_content_access.started';
            $_GET['dir']   = 'DESC';
        } else {
            $_GET['order'] = 'ppSD_content.name';
            $_GET['dir']   = 'ASC';
        }
        $add_get['organize'] = $_GET['organize'];
    }
    if (empty($_GET['organize'])) {
        $_GET['organize'] = '';
    }
    if (empty($_GET['order'])) {
        $_GET['order'] = 'ppSD_content.section DESC, ppSD_content.name';
    }
    if (empty($_GET['dir'])) {
        $_GET['dir'] = 'ASC';
    }
    if (empty($_GET['display'])) {
        $_GET['display'] = '24';
    }
    /**
     * Loop content access
     * and organize everything
     * based on the section it
     * is found in.
     */
    $paginate  = new pagination('ppSD_content_access', 'manage/index.php', $add_get, $_GET, $filters, $join, '*');
    $content   = new content;
    $formatted = '';
    $STH       = $db->run_query($paginate->query);
    $last_section = '';
    $misc_content = array();
    $all_content = array();
    while ($row = $STH->fetch()) {
        $access  = $content->get_content_access($row['id']);
        $data    = $content->get_content($access['content_id'], '1');

        // New Section
        if ($last_section != $data['section']) {
            $secd    = $content->get_content($data['section'], '1');
            if (empty($secd['name'])) {
                $misc_content[] = $secd;
                $skip = '1';
                $secd['name'] = $db->get_error('L032');
                $saccess['format_expires'] = '';
                $saccess['format_added'] = '';
            } else {
                $saccess  = $content->get_content_access($data['section']);
            }
            $schanges = array(
                'data'   => $secd,
                'access' => $saccess,
            );
            $schanges['ctype'] = 'section';
            $schanges['clink'] = $secd['name'];
            $formatted .= new template('manage_home_content_entry', $schanges, '0');
        }

        // Misc Content
        $changes = array(
            'data'   => $data,
            'access' => $access,
        );
        if ($data['type'] == 'page') {
            $data['full_link']  = $content->build_permalink($data['permalink'], $data['section']);
            $changes['ctype'] = 'page';
            $changes['clink'] = '<a href="' . $data['full_link'] . '">' . $data['name'] . '</a>';
            $formatted .= new template('manage_home_content_entry', $changes, '0');
        }
        else if ($data['type'] == 'folder') {
            $changes['ctype'] = 'folder';
            $changes['clink'] = '<a href="' . $data['url'] . '">' . $data['name'] . '</a>';
            $formatted .= new template('manage_home_content_entry', $changes, '0');
        }
        // Set last section
        $last_section = $data['section'];
        $all_content[] = $changes;
    }


    $changes = array(
        'content'    => $formatted,
        'raw_content' => $all_content,
        'pagination' => $paginate->{'rendered_pages'}
    );

    $theme = $db->get_theme();
    $page_check = 'manage_home-' . $udata['data']['member_type'];
    $path = PP_PATH . '/pp-templates/html/' . $theme['name'] . '/' . $db->determine_language() . '/' . $page_check . '.php';

    if (file_exists($path)) {
        $template = $page_check;
    } else {
        $template = 'manage_home';
    }

    $wrapper = new template($template, $changes, '1');
    
    echo $wrapper;
    exit;
}

