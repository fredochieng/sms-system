<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wgsms extends Model
{
    
	
	 public static function clean_phone_number($country_code,$phonenumber){
			 $DestinationPhoneNum=$phonenumber;
			 $DestinationPhoneNum=substr($DestinationPhoneNum, -9, 9);
			 return $DestinationPhoneNum = $country_code.$DestinationPhoneNum;
	 }
		
}
