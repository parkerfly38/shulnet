<?php

class transaction extends db
{


    public function get_total($id)
    {
        return $this->get_array("
            SELECT *
            FROM ppSD_cart_session_totals
            WHERE `id`='" . $this->mysql_clean($id) . "'
            LIMIT 1
        ");
    }

    public function get_order_items($id)
    {
        $items = array();
        $q = $this->run_query("
            SELECT
              ppSD_cart_items_complete.*,
              ppSD_products.name as productName
            FROM ppSD_cart_items_complete
            JOIN ppSD_products ON ppSD_products.id = ppSD_cart_items_complete.product_id
            WHERE ppSD_cart_items_complete.cart_session = '" . $this->mysql_clean($id) . "'
        ");
        while ($row = $q->fetch()) {
            $items[] = $row;
        }
        return $items;
    }

    public function get_transaction_by_user($id)
    {
        $sales = array();
        $total = 0;
        $subtotal = 0;
        $savings = 0;
        $refunds = 0;
        $transactions = 0;

        $STH = $this->run_query("
            SELECT
              ppSD_cart_sessions.id,
              ppSD_cart_sessions.date,
              ppSD_cart_sessions.date_completed,
              ppSD_cart_sessions.payment_gateway,
              ppSD_cart_sessions.gateway_order_id,
              ppSD_cart_sessions.state,
              ppSD_cart_sessions.country,
              ppSD_cart_sessions.member_id,
              ppSD_cart_sessions.member_type,
              ppSD_cart_session_totals.total,
              ppSD_cart_session_totals.subtotal,
              ppSD_cart_session_totals.savings,
              ppSD_cart_session_totals.refunds
            FROM `ppSD_cart_sessions`
            JOIN `ppSD_cart_session_totals`
              ON ppSD_cart_sessions.id = ppSD_cart_session_totals.id
            WHERE
              ppSD_cart_sessions.member_id = '" . $this->mysql_clean($id) . "' AND
              ppSD_cart_sessions.status = '1'
        ");

        while ($row =  $STH->fetch()) {
            $sales[] = $row;

            $transactions++;
            $total += $row['total'];
            $subtotal += $row['subtotal'];
            $savings += $row['savings'];
            $refunds += $row['refunds'];
        }

        return array(
            'data' => $sales,
            'transactions' => $transactions,
            'total' => $total,
            'subtotal' => $subtotal,
            'savings' => $savings,
            'refunds' => $refunds,
        );
    }


}

