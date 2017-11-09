<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\PO;
use DateTime;
class OutboundDeliveryController extends Controller
{
    public function getOutboundDeliveryList(){
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d"));
        $date->modify('+7 day');
        $nextDate = new DateTime($date->format('Y-m-d'));

        $date = date('Y-m-d');
    	$outboundDelivery = PO::with('customer')->whereBetween('promised_delivery_date', array($today, $nextDate))->get();
        
        foreach($outboundDelivery as $index => $row){
            $outboundDelivery[$index]['customer_id'] = $row['customer']['id'];
            $outboundDelivery[$index]['customer_name'] = $row['customer']['name'];
        }
    	echo json_encode($outboundDelivery);
    }
}
