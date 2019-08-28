<?php

namespace App\Models;
Use Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Mail\Emailer;
class ROE extends Model
{
    protected $table='roe';
    protected $guarded = ['id'];
    CONST DRAFT_STATUS = 1;
    
    public static function myRoes(){
        $def_status = config('mdu.default_roe_status');
        #$draft_status = 1;
        return  self::where('creator','=',Auth::user()->id)
                    ->where('status_check','=','draft')
                    ->get();
    }
    
    public static function ROECount($agent=0){
        if($agent>0){
            return self::where('creator','=',$agent)
                ->where('status','!=',1)
                ->count();
        }
        else{
             return self::where('status','!=',1)
                #::where('creator','=',$agent)
                ->count();
        }
    }
    
    /**
     * Get ROE history of the logged in user
     * 
     * @return type
     */
   
   
   
  //Am getting the agents ROE at level 1, pass in status e.g. published, rejected, complete
  
  
   public static function get_agents_roes($status){
		  $user_id= Auth::user()->id;
		
		
		
	
		 
		  $user_role_info=ROE::get_a_user_role_by_user_id($user_id);
		
		  
		
		  
		  if($status=="all"){
			   //$data= self::select(array('roe.*','users.name as action_agent'))
			   $data= self::select(array('roe.*','users.name as action_agent'))
							->from('roe')
							->join('model_has_roles','model_has_roles.model_id','=','roe.last_action_by')
							->join('roles','model_has_roles.role_id','=','roles.id')
							->join('users','roe.last_action_by','=','users.id')
							->where('roe.creator',$user_id)
							->get();
							
						
							
			}elseif($status=="pending"){
		
			$current_stage=$user_role_info['order']+1;
			 	$data= self::select(array('roe.*','users.name as action_agent'))
							->from('roe')
							->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
							->join('roles','model_has_roles.role_id','=','roles.id')
							->join('users','roe.last_action_by','=','users.id')
							->where('roe.status_check','published')
							->where('roe.creator',$user_id)
							->where('roe.current_stage',$current_stage)
							->get();
							
			}elseif($status=="rejected"){
		  		$current_stage=$user_role_info['order']+1;
				
				
			  $data= self::select(array('roe.*','users.name as action_agent'))
								->from('roe')
								->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
								->join('roles','model_has_roles.role_id','=','roles.id')
								->join('users','roe.last_action_by','=','users.id')
								->where('roe.status_check',$status)
								->where('roe.creator',$user_id)
								->where('roe.current_stage',$current_stage)
								->get();
								
			}elseif($status=="published" || $status="completed"){
				 $data= self::select(array('roe.*','users.name as action_agent'))
								->from('roe')
								->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
								->join('roles','model_has_roles.role_id','=','roles.id')
								->join('users','roe.last_action_by','=','users.id')
								->where('roe.status_check',$status)
								->where('roe.creator',$user_id)
								->get();
				
			}
			
			
			
			
		return $data;	
	   
	} 
	
	
	
	
	
	 public static function get_users_roes($status){
		  $user_id= Auth::user()->id;
		  
		 
		  $user_role_info=ROE::get_a_user_role_by_user_id($user_id);
		  
		  
		
		   //echo $user_role_info['order']; exit;
		  if($status=="all"){
			   $data= self::select(array('roe.*','users.name as action_agent'))
							->from('roe')
							->join('model_has_roles','model_has_roles.model_id','=','roe.last_action_by')
							->join('roles','model_has_roles.role_id','=','roles.id')
							->join('users','roe.last_action_by','=','users.id')
							->where('roe.current_stage',$user_role_info['order'])
							->get();
							
			}elseif($status=="pending"){
		
			$current_stage=$user_role_info['order']+1;
			 	$data= self::select(array('roe.*','users.name as action_agent'))
							->from('roe')
							->join('model_has_roles','model_has_roles.model_id','=','roe.last_action_by')
							->join('roles','model_has_roles.role_id','=','roles.id')
							->join('users','roe.last_action_by','=','users.id')
							->where('roe.status_check','published')
							->where('roe.current_stage',$current_stage)
							->get();
							
			}elseif($status=="rejected"){
		 	  $current_stage=$user_role_info['order']+1;
			  $data= self::select(array('roe.*','users.name as action_agent'))
								->from('roe')
								->join('model_has_roles','model_has_roles.model_id','=','roe.last_action_by')
								->join('roles','model_has_roles.role_id','=','roles.id')
								->join('users','roe.last_action_by','=','users.id')
								->where('roe.status_check',$status)
								->where('roe.current_stage',$current_stage)
								->get();
								
			}elseif($status=="published"){
				
				
				 $data= self::select(array('roe.*','users.name as action_agent'))
								->from('roe')
								->join('model_has_roles','model_has_roles.model_id','=','roe.last_action_by')
								->join('roles','model_has_roles.role_id','=','roles.id')
								->join('users','roe.last_action_by','=','users.id')
								->where('roe.status_check',$status)
								->where('roe.current_stage',$user_role_info['order'])
								//->where('roe.creator',$user_id)
								->get();
				
			}elseif($status="completed"){
				
				
				 $data= self::select(array('roe.*','users.name as action_agent'))
								->from('roe')
								->join('model_has_roles','model_has_roles.model_id','=','roe.last_action_by')
								->join('roles','model_has_roles.role_id','=','roles.id')
								->join('users','roe.last_action_by','=','users.id')
								->where('roe.status_check',$status)
								//->where('roe.current_stage',$user_role_info['order'])
								//->where('roe.creator',$user_id)
								->get();
				
			}
			
			
			
			
		return $data;	
	   
	} 
	
	
	
	
	
	
	
	
	
	public static function get_roles_for_declined_roe(){
			$user_id= Auth::user()->id;
		  	$user_role_info=ROE::get_a_user_role_by_user_id($user_id);
			$order=$user_role_info['order'];
			
			 $data= self::select('*')
			  ->from('roles')
			 		 ->where('order','<',$order)
					 ->get()->toArray();
					 return $data;
			
			
		
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
   
   
   
   
   
   public static function get_a_user_role_by_user_id($id){
			  $data= self::select('*')
			  ->from('model_has_roles')
			 		    ->join('roles','model_has_roles.role_id','=','roles.id')
						 ->where('model_has_roles.model_id',$id)
						->get()->first()->toArray();
						return $data;
		} 
   
   
   
   
   
   
   
   
   
   
   
   
  public static function get_user_role_by_user_id($id){
			  $data= self::select('*')
			  ->from('model_has_roles')
			 		    ->join('roles','model_has_roles.role_id','=','roles.id')
						->join('workflow_steps','model_has_roles.role_id','=','workflow_steps.action_agent')
						->join('workflow_sequence','workflow_steps.action_agent','=','workflow_sequence.action_agent')
						 ->where('model_has_roles.model_id',$id)
						->get()->first()->toArray();
						return $data;
		} 
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
    public static function myHistory(){
		
		
		/* $draft='draft';
        $def_status = config('mdu.default_roe_status');
        return self::join('incidents','roe.id','=','incidents.roe')
                    ->join('incident_status','incidents.status','=','incident_status.id')
                    ->join('roles','incidents.next_agent','=','roles.id')
                    ->where('roe.creator','=',Auth::user()->id)
                   // ->where('roe.status_check','!=', $draft)
                    ->get([
                        'roe.id',
                        'roe.property_name',
                        'roe.no_of_units',
                        'roe.project_completion',
                        'roe.occupancy',
                        'roe.address',
                        'incident_status.name as status',
                        'roles.name as next_agent',
						'roe.status_check as status_check'
                    ]);*/
					
					
					
					$history= self::select(array('roe.*','users.name as action_agent'))
					->from('roe')
					->join('users','roe.last_action_by','=','users.id')
					->where("status_check", "!=",'draft')
					->where('creator','=',Auth::user()->id)
					->orderBy("id", "Desc")
					->get();
					
					return $history;
					
					
    }
    
    public static function viewDetails($id=null){
        
        if(!is_null($id)){
            return self::join('economic_grouping','roe.economic_class','=','economic_grouping.id')
                ->join('users','roe.creator','=','users.id')
                ->join('priority','priority.id','=','roe.priority')
                ->where('roe.id','=',$id)
                ->get([
                    'economic_grouping.name as economic_class',
                    'roe.id',
                    'roe.property_name',
                    'roe.address',
                    'roe.phase',
                    'roe.no_of_units',
                    'roe.has_central_unit',
                    'roe.obstacles',
                    'roe.obstacles_expected',
                    'roe.obstacle_solutions',
                    'roe.contact_person',
                    'roe.contact_phone',
                    'roe.contact_email',
                    'roe.site_supervisor',
					'roe.lr_no',
					'roe.contact_phone2',
					'roe.supervisor_phone',
					'roe.signed_roe',
                    'roe.expected_sales',
                    'roe.project_completion',
                    'roe.occupancy',
                    'roe.design',
                    'roe.draft_bom',
					'roe.surveyor_name',
					'roe.surveyor_phone',
					'roe.surveyed_date',
					'roe.survey_file',
					'roe.internal_design',
					
                    'priority.name as priority',
                    'users.name as creator'
                ])
                ->first();
        }
        else{
            throw new Exception('Parameter [ROE ID] not provided');
        }
	
    }
	
	
	
		
		
		
		
		
		
		
		
	public static function get_declined_roes($id){
		
			$roles_data=ROE::get_user_role_by_user_id($id);
			
			$role_id=$roles_data['role_id'];
			$next_action=$roles_data['current_step'];

		
			  $data= self::select(array('roe.*','users.name as declining_agent'))
			  			->from('roe')
						->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						->join('users','roe.last_action_by','=','users.id')
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						->where('roe.creator',$id)
						->where('roe.status_check','rejected')
						->where('workflow_sequence.prev_step',$next_action)
						->get();
						
												return $data;
												
												
		}
		
		
		public static function get_other_declined_roes($id){
		
			$roles_data=ROE::get_user_role_by_user_id($id);
			
			$role_id=$roles_data['role_id'];
			$next_action=$roles_data['current_step'];

		
			  $data= self::select(array('roe.*','users.name as declining_agent'))
			  			->from('roe')
						->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						->join('users','roe.last_action_by','=','users.id')
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						//->where('roe.creator',$id)
						->where('roe.status_check','rejected')
						->where('workflow_sequence.prev_step',$next_action)
						->get();
						
												return $data;
												
												
		}
		
		
		
		public static function get_approved_roes($id){
		
			$roles_data=ROE::get_user_role_by_user_id($id);
			
			$role_id=$roles_data['role_id'];
			$current_action=$roles_data['current_step'];
			
			$data= self::select(array('roe.*'))
			  			->from('roe')
						->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						->join('users','roe.last_action_by','=','users.id')
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						//->where('roe.creator',$id)
						->where('roe.status_check','published')
						->where('workflow_sequence.current_step',$current_action)
						->get();
						
						return $data;
		}
		
		
		
		public static function count_roe($id,$status){
			
			
			
			if($status=='all'){
				
				$count= self::select("*")
						->where('creator','=',Auth::user()->id)
						->get();
			}else{
				
				$count= self::select("*")
						->where("status_check", "=",$status)
						->where('creator','=',Auth::user()->id)
						->get();
				
			}
			
			
						
					return $count;
		}
		
		
		//HERE
		// Gets all ROES by Agent that have been published or rejected
		//Param: status= published or rejected
		
		
		public static function get_agent_roes($status){
			
			
		
			$roles_data=ROE::get_user_role_by_user_id(Auth::user()->id);
			
			$role_id=$roles_data['role_id'];
			$next_step=$roles_data['next_step'];
			
		
			
			
			if($status=='completed'){
				$data= self::select(array('roe.*'))
			  			->from('roe')
						->where('roe.status_check',$status)
						->where('roe.creator',Auth::user()->id)
						->get();
						
			}elseif($status=='all'){
				$data= self::select(array('roe.*'))
			  			->from('roe')
						->where('roe.creator',Auth::user()->id)
						->get();
			
			}else{
			
				
					$data= self::select(array('roe.*'))
								->from('roe')
								->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
								->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
								->join('users','roe.last_action_by','=','users.id')
								//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
								//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
								->where('roe.status_check',$status)
								->where('roe.creator',Auth::user()->id)
								->where('workflow_sequence.next_step',$next_step)
								->get();
		}
						
						return $data;
						
			
	} 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public static function get_published_roes_beyond_agent($status){
			$roles_data=ROE::get_user_role_by_user_id(Auth::user()->id);
			
			$role_id=$roles_data['role_id'];
			$current_step=$roles_data['current_step'];
			
			//echo $next_step;exit;
			
			
			
			if($status=='completed'){
				$data= self::select(array('roe.*'))
			  			->from('roe')
						->where('roe.status_check',$status)
						->where('roe.creator',Auth::user()->id)
						->get();
						
			}elseif($status=='all'){
				$data= self::select(array('roe.*'))
			  			->from('roe')
						->where('roe.creator',Auth::user()->id)
						->get();
			
			}else{
				
				
					$data= self::select(array('roe.*'))
								->from('roe')
								->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
								->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
								->join('users','roe.last_action_by','=','users.id')
								//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
								//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
								//->where('roe.status_check',$status)
								//->where('roe.creator',Auth::user()->id)
								->where('workflow_sequence.next_step',$current_step)
								->get();
		}
						
						return $data;
						
			
	} 
	
	
	
	
	
	
	
	
	
	
	
	
		
		public static function get_agent_rejected_roes(){
			$roles_data=ROE::get_user_role_by_user_id(Auth::user()->id);
			
			$role_id=$roles_data['role_id'];
			$next_step=$roles_data['next_step'];
			
			$data= self::select(array('roe.*'))
			  			->from('roe')
						->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						->join('users','roe.last_action_by','=','users.id')
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						->where('roe.status_check','published')
						->where('roe.creator',Auth::user()->id)
						->where('workflow_sequence.current_step',$next_step)
						->get();
						
						return $data;
		} 
		
		
		
		
		
		
		
		
		
		
		
		
		public static  function get_published_roes($id){
			$roles_data=ROE::get_user_role_by_user_id($id);
			
			$role_id=$roles_data['role_id'];
			$current_action=$roles_data['current_step'];
			
			
			
			  $data= self::select(array('roe.*'))
			  			->from('roe')
						->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						->join('users','roe.last_action_by','=','users.id')
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						->where('roe.status_check','published')
						->where('workflow_sequence.next_step',$current_action)
						->get();
						
						
						
						return $data;
				
		}
		
		
		
		public static  function get_published_cto_roes(){
			
		
			
			  $data= self::select(array('roe.*'))
			  			->from('roe')
						//->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						//->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						//->join('users','roe.last_action_by','=',9)
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						->where('roe.status_check','published')
						->where('roe.last_action_by','9')
						//->where('workflow_sequence.next_step',$current_action)
						->get();
						
						
						
						return $data;
				
		}
		
		
		
		public static  function get_published_qc_roes(){
			
		
			
			  $data= self::select(array('roe.*'))
			  			->from('roe')
						//->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						//->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						//->join('users','roe.last_action_by','=',9)
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						->where('roe.status_check','published')
						->where('roe.last_action_by','14')
						//->where('workflow_sequence.next_step',$current_action)
						->get();
						
						
						
						return $data;
				
		}
		
		
		
		public static  function get_published_construction_roes(){
			
		
			
			  $data= self::select(array('roe.*'))
			  			->from('roe')
						//->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						//->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						//->join('users','roe.last_action_by','=',9)
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						->where('roe.status_check','published')
						->where('roe.last_action_by','8')
						//->where('workflow_sequence.next_step',$current_action)
						->get();
						
						
						
						return $data;
				
		}
		
		
		
		
		public static  function get_published_cto_awaiting_const(){
			
		
			
			  $data= self::select(array('roe.*'))
			  			->from('roe')
						//->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						//->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						//->join('users','roe.last_action_by','=',9)
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						->where('roe.status_check','published')
						->where('roe.last_action_by','8')
						//->where('workflow_sequence.next_step',$current_action)
						->get();
						
						
						
						return $data;
				
		}
		
		
		public static  function get_published_construction_awaiting_const(){
			
		
			
			  $data= self::select(array('roe.*'))
			  			->from('roe')
						//->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
						//->join('workflow_sequence','model_has_roles.role_id','=','workflow_sequence.action_agent')
						//->join('users','roe.last_action_by','=',9)
						//->join('rejection_matrix','roe.reject_reason','=','rejection_matrix.id')
						//->join('reject_reasons','rejection_matrix.reason','=','reject_reasons.id')
						->where('roe.status_check','published')
						->where('roe.last_action_by','14')
						//->where('workflow_sequence.next_step',$current_action)
						->get();
						
						
						
						return $data;
				
		}
		
		
		
		
		public static  function get_boms($roeid){
			
			
		
	 $data= self::select(array('bom_details.*','inventory.description as desc','bom_charge_type.name as bom_charge_type','inventory.eqp_price as equip_price','inventory.srv_price as service_price','inventory.id as inventory_id','bom_charge_type.id as bom_charge_type_id' ))
			  			->from('bom_details')
						->join('inventory','bom_details.bom','=','inventory.id')
						->join('bom_charge_type','bom_details.charge_type','=','bom_charge_type.id')
						->where('bom_details.item',$roeid)
						->get();
						return $data;
				
				
				
				
		}
		
		
		
			
		public static function get_next_users_by_order($order){
			 $order_data= self::select('*')->from('roles')->where('roles.order',$order)->get()->first()->toArray();
			 $next_role=$order_data['id'];
			 
			 $users_data= self::select('*')
			  			->from('model_has_roles')
						->join('users','model_has_roles.model_id','=','users.id')
						->where('model_has_roles.role_id',$next_role)
						->get()->toArray();
			return $users_data;
						
		}
		
		
		
		public static function send_notification_to_group($user_id,$subject,$message,$action){
					
					$roles_data=ROE::get_user_role_by_user_id($user_id);
					
					$role_id=$roles_data['role_id'];
					$order=$roles_data['order'];
					
					//echo $order;exit;
					
					if($action=='approved'){
						$next_order=$order+1;
					}else{
						$next_order=$order-1;
					}
					
					$objDemo = new \stdClass();
					$objDemo->message = $message;
					$objDemo->subject = $subject;
					
					if($next_order>0){
						
						$users=ROE::get_next_users_by_order($next_order);
						
						foreach($users as $user){
							
							$email=remove_numbers($user['email']);
						
						$email=Mail::to($email)->send(new Emailer($objDemo));	
					}
					}
					
		}
		
		
		
		
		
		
		
		public static function send_notification_to_role($user_id,$subject,$message,$action,$selected_order){
					$objDemo = new \stdClass();
					$objDemo->message = $message;
					$objDemo->subject = $subject;
					$users=ROE::get_next_users_by_order($selected_order);
					
					
					//$email=Mail::to('kvnochieng52@gmail.com')->send(new Emailer($objDemo));	
					//$email=Mail::to('kevin.ochieng@ke.wananchi.com')->send(new Emailer($objDemo));	
					
					
					foreach($users as $user){
						$email=Mail::to($user['email'])->send(new Emailer($objDemo));	
					}
							
		}
		
		
		
		
		
		public static function get_active_groups(){
				$data= self::select('*')
			  			->from('roles')
						->where('active','1')
						->get();
				return $data;
		}
		
		
		
		
		public static function roe_lock($roeid){
		 $data= self::select(array('users.name','users.id as user_id'))
			  			->from('roe')
						->join('users','roe.lock_check','=','users.id')
						->where('roe.id',$roeid)
						->get()->first();
						
						return $data;
			
		}
		
		
		
		
		
		
		
		public static function qc_send_notification($user_id,$subject,$message,$action){
					
					
					$camusat_role=28;
					
					
					$roles_data=ROE::get_user_role_by_user_id($user_id);
					
					$role_id=$roles_data['role_id'];
					$order=$roles_data['order'];
					
					//echo $order;exit;
					
					if($action=='approved'){
						$next_order=$order+1;
					}else{
						$next_order=$order-1;
					}
					
					$objDemo = new \stdClass();
					$objDemo->message = $message;
					$objDemo->subject = $subject;
					
					if($next_order>0){
						
						$users=ROE::get_next_users_by_order($next_order);
						
						foreach($users as $user){
						
						$email=Mail::to($user['email'])->send(new Emailer($objDemo));	
					}
					}
					
		}
		
		
		
		
		
		public static function get_role_info_by_order($order){
			
			 $data= self::select('*')
			  ->from('roles')
			 		 ->where('order',$order)
					 ->get()->first();
					 return $data;
			
			
		
		}
		
		
		
			public static function get_roe_for_status(){
		
		
				$data= self::select(array('roe.*','users.name as action_agent'))
									->from('roe')
									->join('model_has_roles','roe.last_action_by','=','model_has_roles.model_id')
									->join('roles','model_has_roles.role_id','=','roles.id')
									->join('users','roe.last_action_by','=','users.id')
									//->where('roe.status_check','published')
									//->where('roe.creator',$user_id)
									//->where('roe.current_stage',$current_stage)
									->get();
									
									
									
									
									foreach($data as $rec){
										
										if($rec->current_stage > 9){
											$rec->action_role_name="completed";
										}else{
											$rec->action_role_name=ROE::get_role_info_by_order($rec->current_stage)->name;
										}
									}
				
				
				return $data;
		}
		
		
		
		
		
		
		
		
							
}


function remove_numbers($string) {
   return preg_replace('/[0-9]+/', null, $string);
}