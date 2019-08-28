<?php

namespace App\Http\Controllers;

use App\quee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use App\contact;
use App\text;
use App\wgsms;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Log;
use App\textprogress;

class QueeController extends Controller
{
	CONST WAIT_BEFORE_RECONNECT_uS = 10000000;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
		
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
		
        	
	$texts = text::where(array('qued'=>1,'status'=>'published'))->orderBy('text_id','asc')->first();
	
	
	
	
	
	# Log::debug($texts);

	if($texts){
		
		
		//Get the gateway to use based on the country ID
		$check_gateway_mapping_id=DB::table('api_country_mapping')
			->where(array('country_id'=>$texts->recepient_country_id))
			->first()->api_id;
		$gateway_to_use=DB::table('sms_api_providers')
			->where(array('api_provider_id'=>$check_gateway_mapping_id))
			->first()->name;
		
		//Get the country code  based on Text Country
		$country_code=DB::table('recipients_country')
			->where(array('recipients_country_id'=>$texts->recepient_country_id))
			->first()->country_code;
		$priority = (int)$texts['priority_id'];
		Log::debug("This is the priority: ".$priority);
		
		## UPDATE TO PREPROCESSING STATE
		$texts->qued = 3;
		$texts->save();

		$from_source=$texts->from_source;
		if($from_source=='contact_list' || $from_source=='csv_upload'){	
			$contacts = contact::find($texts->contacts_id);
			
			if($contacts->contacts_from=="csv"){
				$shortcodes=json_decode($contacts->csv_file_columns);
				
				

				$csv_file=$contacts->csv_file;
				$row = 1;
				$row_count_csv=0; 
				
				$send_list = array();
				$msg_list = array();
				$batch_counter = 0;
				$batch_list = array();

				if (($handle = fopen($csv_file, "r")) !== FALSE) {				
				  while (($data = fgetcsv($handle, '', ",")) !== FALSE) {
					  $telephone_column='';
					  $num = count($data);
					  $phone_no='';
					  $columns_in_csv=array();
					
					for ($c=0; $c < $num; $c++){ 
						$columns_in_csv[$c]=$data[$c];
						if($c==$contacts->csv_contacts_column){	$phone_no=$data[$c];}
					}
					
					$data = array();
					if($row>1){
						 
						//echo "<pre>";
						
						$no_of_columns_in_csv=count($shortcodes);
						$message=$texts->message;
  							 
						for ($x = 0; $x <= $no_of_columns_in_csv-1; $x++) {

							 $field_tag = "{".$shortcodes[$x]."}";
							 $message = str_replace($field_tag,$columns_in_csv[$x],$message);
						} 

						$sms_info=array(
								'text_id'=>$texts->text_id,
								'uid'=>Str::orderedUuid(),
								'phone_no'=>wgsms::clean_phone_number($country_code,$phone_no),
								#'message'=>str_replace('/',"//",addslashes($message)),
								'message'=>addslashes($message),
								'created_at'=>date("Y-m-d H:i:s"),
						);
						
						$row_count_csv++;

						## BATCH LIST COMPILER
						if($batch_counter == 29){

							## ADD THE CURRENT ROW
							array_push($batch_list,$sms_info);
							## INSERT INTO DB
							DB::table('quees')->insert($batch_list);
							##PUBLISH TO QUEUE
							## REMOVE UNCESSARY FIELDS FOR THE QUEUE
							$qlist = $batch_list;
							unset($qlist['text_id']);
							unset($qlist['created_at']);
							Log::debug($qlist);
							$this->postToQueue($qlist,$priority,$country_code);
							$qlist = null;

							$batch_counter = 0;
							$batch_list = [];
						}
						else{
							array_push($batch_list,$sms_info);
							$batch_counter ++;
						}
						
					}
						
					$row++;
				  }

					if( ($batch_counter < 29) && ($batch_counter > 0) ){
							## INSERT INTO DB
							DB::table('quees')->insert($batch_list);

							##PUBLISH TO QUEUE
							$qlist = $batch_list;
							unset($qlist['text_id']);
							unset($qlist['created_at']);
							# Log::debug("This is the message: ".$qlist);
                                                        # Log::debug("This is the priority: ".$priority);

							$this->postToQueue($qlist,$priority,$country_code);
							$batch_counter = 0;
							$batch_list = [];
					}

				  fclose($handle);
				  echo $row." Rows processed.";
				}
				
				textprogress::update_progress($texts->text_id,'total_contacts',$row_count_csv);
			}

			if($contacts->contacts_from=="phone_book"){
				$contacts_details=json_decode($contacts->phone_book_contacts);
				
				$phone_book_colums=json_decode($contacts->phone_book_columns);
				$no_of_columns_count=count($phone_book_colums);

				## INITIALIZE SMS QUEUEING VARIABLES
				$batch_list = array(); 
				
				$row_counts=0;
				
				foreach($contacts_details as $contact){
					
						$phone_no=$contact->phone;
						$message=$texts->message;
						$contacts_array =  (array) $contact;
						
						foreach($phone_book_colums as $phone_book_colum){
							 
							 $field_tag = "{".$phone_book_colum."}";
							 $contact_field=$contacts_array[$phone_book_colum];
							 $message = str_replace($field_tag, $contact_field,$message);
						} 
						
						$sms_info=array(
								'text_id'=>$texts->text_id,
								'uid'=>Str::orderedUuid(),
								'phone_no'=>wgsms::clean_phone_number($country_code,$phone_no),
								#'message'=>str_replace('/',"//",addslashes($message)),
								'message'=>addslashes($message),
								'created_at'=>date("Y-m-d H:i:s"),
						);
						array_push($batch_list,$sms_info);
						
						$row_counts++;
				}
				## POST TO RABBITMQ AND MYSQL
				DB::table('quees')->insert($batch_list);
				##PUBLISH TO QUEUE
				## REMOVE UNCESSARY FIELDS FOR THE QUEUE
				$qlist = $batch_list;
				unset($qlist['text_id']);
				unset($qlist['created_at']);
				# Log::debug("This is the message: ".$qlist);
				$this->postToQueue($qlist,$priority,$country_code);
				$qlist = null;
				textprogress::update_progress($texts->text_id,'total_contacts',$row_counts);
			}

		}
		
		if($texts->from_source=="recepient_contacts"){
			## INITIALIZE SMS QUEUEING VARIABLES
			$batch_list = array();

			$contacts = explode(',', $texts->recepient_contacts	);
			$trimmed_contacts = array_map('trim',$contacts);
			$row_counts_rec=0;
			foreach($trimmed_contacts as $phone_no){
					$sms_info=array(
						'text_id'=>$texts->text_id,
						'uid'=>Str::orderedUuid(),
						'phone_no'=>wgsms::clean_phone_number($country_code,$phone_no),
						#'message'=>str_replace('/',"//",addslashes($texts->message)),
						'message'=>addslashes($texts->message),
						'created_at'=>date("Y-m-d H:i:s"),
					);
					array_push($batch_list,$sms_info);
					$row_counts_rec++;
			}

			## POST TO RABBITMQ AND MYSQL
			DB::table('quees')->insert($batch_list);
			##PUBLISH TO QUEUE
			## REMOVE UNCESSARY FIELDS FOR THE QUEUE
			$qlist = $batch_list;
			unset($qlist['text_id']);
			unset($qlist['created_at']);
			Log::debug($qlist);
			$this->postToQueue($qlist,$priority,$country_code);
			$qlist = null;
			textprogress::update_progress($texts->text_id,'total_contacts',$row_counts_rec);
		}
		$texts->qued=2; 
		$texts->save();
	}
		
		
		
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\quee  $quee
     * @return \Illuminate\Http\Response
     */
    public function show(quee $quee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\quee  $quee
     * @return \Illuminate\Http\Response
     */
    public function edit(quee $quee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\quee  $quee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, quee $quee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\quee  $quee
     * @return \Illuminate\Http\Response
     */
    public function destroy(quee $quee)
    {
        //
    }

	public function postToQueue($payload,$priority = 2,$country=null)
	{
		## ENCODE THE MSG IN JSON
		$serialized_msg = json_encode($payload);

		if ($country === 254) {
			switch ($priority) {
				case 2:
					$exchange = 'external';
					$que = 'smstest2';
					#$que = 'dev';
					break;
				case 1:
					$exchange = 'internal';
					$que = 'noc';
					#$que = 'dev';
					break;
				case 3:
					$exchange = 'snet_ke';
					$que = 'snet_ke';
					#$que = 'dev';
					break;
				case 4:
					$exchange = 'snet_ke';
					$que = 'snet_ke';
					#$que = 'dev';
					break;
				default:
					$exchange = 'external';
					$que = 'smstest2';
					#$que = 'dev';
					break;
			}
		} else { 
			## NON KENYAN ENTITIES (MW,TZ,KE,ZM)
			
			switch ($country) {
				case 255: # TANZANIA
					if($priority==5){
						$exchange = 'snet_tz';
						$que = 'snet_tz';
					}else{
						$exchange = 'tanzania';
						$que = 'tz';
					}
					break;
				case 256: # UGANDA
					$exchange = 'uganda';
					$que = 'ug';
					break;
				case 265: # MALAWI
					$exchange = 'malawi';
					$que = 'mw';
					break;
				case 260: # ZAMBIA
					$exchange = 'zambia';
					$que = 'zm';
					break;
				default:
					## NOTHING, THROW EXCEPTION.
					break;
			}
		}
		$routing_key = 'send_out';

		## Instantiate connection
		try {

			$qcon = new AMQPStreamConnection(
				config('rabbitmq.host'),
				config('rabbitmq.port'),
				config('rabbitmq.user'),
				config('rabbitmq.key')
			);
			$qchannel = $qcon->channel();
			## DEFINE AN EXCHANGE
			$qchannel->exchange_declare($exchange, config('rabbitmq.exchange_type'), false, true, false);
			## CREATE A QUEUE
			$qchannel->queue_declare($que, false, true, false, false);
			## BIND THE QUEUE TO THE EXCHANGE
			$qchannel->queue_bind($que, $exchange);

			$msg_xtics = array(
				'content_type' => 'application/json',
				'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
			);

			$msg = new AMQPMessage($serialized_msg, $msg_xtics);
			#$r = $qchannel->basic_publish($msg,$exchange,$routing_key);
			$r = $qchannel->basic_publish($msg, $exchange);

			$qchannel->close();
			$qcon->close();
		}catch(AMQPIOException $e){
			Log::debug($e);
		}
		return true; 
	}
}
