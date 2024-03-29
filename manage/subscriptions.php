<?php

/**
 *    ShulNET
 *    http://www.ShulNET.com/
 *    (c) 2012, Castlamp.
 *
 *    Purpose: User management page:
 *    -> Update Account
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
    // Member
    $user   = new user;
    $member = $user->get_user($ses['member_id']);
    /**
     * Pagination
     */
    $add_get = array();
    $filters = array(
        'ppSD_subscriptions.member_id' => array('scope' => 'AND', 'value' => $ses['member_id'], 'eq' => 'eq'),
    );
    $join    = array();
    if (!empty($_GET['organize'])) {
        if ($_GET['organize'] == 'date_rl') {
            $_GET['order'] = 'ppSD_subscriptions.next_renew';
            $_GET['dir']   = 'DESC';
        } else if ($_GET['organize'] == 'price_low') {
            $_GET['order'] = 'ppSD_subscriptions.price';
            $_GET['dir']   = 'ASC';
        } else if ($_GET['organize'] == 'price_high') {
            $_GET['order'] = 'ppSD_subscriptions.price';
            $_GET['dir']   = 'DESC';
        } else if ($_GET['organize'] == 'active') {
            $filters['ppSD_subscriptions.status'] = array('scope' => 'AND', 'value' => '1', 'eq' => 'eq');
        } else if ($_GET['organize'] == 'inactive') {
            $filters['ppSD_subscriptions.status'] = array('scope' => 'AND', 'value' => '1', 'eq' => 'neq');
        } else {
            $_GET['order'] = 'ppSD_subscriptions.next_renew';
            $_GET['dir']   = 'ASC';
        }
        $add_get['organize'] = $_GET['organize'];
    }
    if (empty($_GET['organize'])) {
        $_GET['organize'] = '';
    }
    if (empty($_GET['order'])) {
        $_GET['order'] = 'ppSD_subscriptions.next_renew';
    }
    if (empty($_GET['dir'])) {
        $_GET['dir'] = 'ASC';
    }
    if (empty($_GET['display'])) {
        $_GET['display'] = '24';
    }
    $paginate     = new pagination('ppSD_subscriptions', 'manage/subscriptions.php', $add_get, $_GET, $filters, $join);
    $subscription = new subscription;
    $formatted    = '';
    $STH          = $db->run_query($paginate->{'query'});
    while ($row = $STH->fetch()) {
        $order   = $subscription->get_subscription($row['id']);
        $changes = array(
            'data'    => $order['data'],
            'product' => $order['product'],
        );
        $formatted .= new template('manage_subscriptions_entry', $changes, '0');
        //pa($order);
    }
    // Billing History
    //pa($pagination);
    // Template
    $changes = array(
        'subscriptions' => $formatted,
        'pagination'    => $paginate->{'rendered_pages'}
    );
    $wrapper = new template('manage_subscriptions', $changes, '1');
    echo $wrapper;
    exit;
}

