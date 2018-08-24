<?php
/*
 * shk_shk_sms_report
 * 
 * Плагин для CMS MODx Revolution + ShoopKeeper 
 * Отправляет SMS на телефон администратора при оформлении заказа
 * Работает через smsc.ru (нужен аккаунт)
 *
 * OnSHKsaveOrder
 */
$eventName = $modx->event->name;
if($eventName=='OnSHKsaveOrder'){
	$order = $modx->getObject('SHKorder',array('id'=>$order_id));
    $purchases = unserialize($order->get('content'));
    if(!empty($order_id)){
        $message = 'Num: #'.$order_id.' ';
        $total_price = 0;
        foreach($purchases as $k => $v){
            foreach($v as $k1 => $v1){
                if ($k1 == 'tv'){
                    foreach($v1 as $k2 => $v2){
                        $delivery1 = $v2;
                    }
                }
                if ($k1 == 'tv_add'){
                    foreach($v1 as $k3 => $v3){
                        $delivery2 = $v3;
                    }
                }
            }
            $total_price = $total_price + ($v['price'] * $v['count']);
        }
            $message .= 'Итого: '.$total_price.' руб. ';
            $message .= $delivery1.$delivery2;
    }
    
    $headers = "Content-type: text/html; charset=\"utf-8\"";
    
	mail('account@send.smsc.ru', 'Subject', $message, $headers);
}