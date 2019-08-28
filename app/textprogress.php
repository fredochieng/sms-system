<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class textprogress extends Model
{
   
	protected $table = 'texts_progress';
	protected $primaryKey = 'progress_id';
	
	
	/**Parameters for $status
	
	total_contacts : for updating the Total Contacts
	delivered : For Updating the Delevered SMS
	queed : For Updating the queed SMS
	undelivered : For Updating the undelivered SMS
	cancelled: updating cancelled SMS
	**/
	
	public static function update_progress($text_id,$status,$new_value){
		$find_text=textprogress::where('txt_id',$text_id)->first();
		if($find_text){
			$current_status_value=$find_text->$status;	
			$new_value=$current_status_value+$new_value;
			$find_text->$status=$new_value;
			$find_text->save();
		}
	}
}
