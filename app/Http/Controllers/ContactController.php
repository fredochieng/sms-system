<?php

namespace App\Http\Controllers;

use App\contact;
use App\text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
	
	
		$user=Auth::user();
		$user_role=$user->getRoleNames()->first();
		
		if($user_role=="NOC Supervisor" || $user_role=="NOC Standard"){
			
			
			$users_id_array=array();
			$users_id_array[]=Auth::user()->id;
			
			$users_by_role_noc_standard = User::role('NOC Standard')->get()->toArray();
			
			if(count($users_by_role_noc_standard) > 0){
				foreach($users_by_role_noc_standard as $user_by_role){
					if($user_by_role['organization_id']==$user->organization_id){
							$users_id_array[]=$user_by_role['id'];
					}
				}
			}	
			
			
			$users_by_role_noc_supervisor = User::role('NOC Supervisor')->get()->toArray();
			
			if(count($users_by_role_noc_supervisor) > 0){
				foreach($users_by_role_noc_supervisor as $user_by_role){
					if($user_by_role['organization_id']==$user->organization_id){
							$users_id_array[]=$user_by_role['id'];
					}
				}
			}	
			
			
			$contacts=contact::whereIn('created_by',$users_id_array)->orderBy('contacts_id','desc')->get();
		
		}elseif($user_role=="admin"){
				$contacts=contact::orderBy('contacts_id','desc')->get();
		
		}else{
	
			$contacts=contact::where(array('created_by'=>Auth::user()->id,'temp'=>'yes'))->orderBy('contacts_id','desc')->get();
		}
		
		
		
			return view('contacts.list')->with([
			'contacts'=>$contacts,
		
		]);
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
		$suggested_csv_contact_column_names=config('wgsms.suggested_csv_contact_column_names');
			return view('contacts.create')->with(['suggested_csv_contact_column_names'=>$suggested_csv_contact_column_names]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }
	
	
	
	
	
	 public function create_ajax(Request $request)
    {
       
	   
	 	
	  
	   
	   $contacts_source=$request->input('contact_source');
	   	
	   $continue=true;
	   $contact_id=$request->input('contact_id');
	  if($contacts_source=='csv'){
		  	if($request->hasFile('csv_file') && $request->file('csv_file')->isValid()){
			
			$path = $_FILES['csv_file']['name'];
			
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			
			
			
			if($ext!='csv'){
				echo "upload_error_extension";exit;	
			}else{
				
				$file = $request->file('csv_file');
				$file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
				$file->move('uploads/csv', $file_name);
				$file='uploads/csv/'.$file_name;
				
				
	
				$columns_array=array();
				
					 $count_through_columns=0;
					 $phone_column_found=1;
					
				$suggested_csv_contact_column_names=config('wgsms.suggested_csv_contact_column_names');
				
			 $contact_column='';
				
				$row = 1;
				if (($handle = fopen($file, "r")) !== FALSE) {
				  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					for ($c=0; $c < $num; $c++) {
						$columns_array[]=$data[$c];
					
					if(in_array(strtolower($data[$c]),$suggested_csv_contact_column_names)){
						$phone_column_found=2;
						 $contact_column=$c;
					
					}
				
				
					
						
					}
					if($row==1){ break; }
					
					$row++;
				  }
				  fclose($handle);
				}
				
				
					if($phone_column_found==2){
				
				
			}else{
				echo "no_telephone_column"; exit;
			}
			
				
				
				
				
				
			/*
			 $db_columns=$columns_array;
			 
			
			 $count_through_columns=0;
			 
			 foreach($db_columns as $column){
				if(in_array(strtolower($column),$suggested_csv_contact_column_names)){
					$phone_column_found=2;
					
					break;	
				}
				
				 $count_through_columns=$count_through_columns+1;
			}
			
			if($phone_column_found==2){
				
				
				
			}else{
				echo "no_telephone_column"; exit;
			}*/
			
				
				
				
				
				
				
					
				
				 $data = array(
					'contacts_title'=>$request->input('contacts_title'),
					'contacts_from'=>'csv',
					'temp'=>"yes",
					'csv_file'=>$file,
					'csv_file_columns'=>json_encode($columns_array),
					'csv_file_name'=>$path,
					'csv_contacts_column'=>$contact_column,
					'created_by'=>Auth::user()->id,
					'modified_by'=>Auth::user()->id,
					'csv_file_columns'=>json_encode($columns_array),
					'created_at'=>date("Y-m-d"),
					'updated_at'=>date("Y-m-d"),
			 );
			 
			
			
			
				
				if($contact_id > 0){
					
						 $data = array(
							'contacts_title'=>$request->input('contacts_title'),
							'contacts_from'=>'csv',
							'temp'=>"yes",
							'csv_file'=>$file,
							'csv_file_columns'=>json_encode($columns_array),
							'csv_file_name'=>$path,
							'csv_contacts_column'=>$contact_column,
							'modified_by'=>Auth::user()->id,
							'csv_file_columns'=>json_encode($columns_array),
							'updated_at'=>date("Y-m-d"),
			 			);
						
						$insert_id=DB::table('contacts') ->where('contacts_id', $contact_id) ->update($data);
					if($insert_id){
						echo "success"; exit;
					}
					
				}else{	
					 $data = array(
					'contacts_title'=>$request->input('contacts_title'),
					'contacts_from'=>'csv',
					'temp'=>"yes",
					'csv_file'=>$file,
					'csv_file_columns'=>json_encode($columns_array),
					'csv_file_name'=>$path,
					'created_by'=>Auth::user()->id,
					'modified_by'=>Auth::user()->id,
					'csv_contacts_column'=>$contact_column,
					'csv_file_columns'=>json_encode($columns_array),
					'created_at'=>date("Y-m-d"),
					'updated_at'=>date("Y-m-d"),
			 );
				
						$insert_id=DB::table('contacts')->insertGetId($data);
				
				}
				if($insert_id){
					echo "success"; exit;
				}
			}
			
		}
		
		
		  
		}
	   
	   
	  if($contacts_source=='phone_book'){
		  	$contact_list=$request->input('contact_list');
			if($contact_id >0){
				
		
			
			$data = array(
			 	'contacts_title'=>$request->input('contacts_title'),
				'contacts_from'=>'phone_book',
				'temp'=>"yes",
				'phone_book_columns'=>json_encode(array('first_name', 'last_name', 'phone','email')),
				'phone_book_contacts'=>json_encode($contact_list),
				//'created_by'=>Auth::user()->id,
				'modified_by'=>Auth::user()->id,
				//'created_at'=>date("Y-m-d"),
				'updated_at'=>date("Y-m-d"),
			 );
			 
			 
			 
			$insert_id=DB::table('contacts') ->where('contacts_id', $contact_id) ->update($data);
			
			if($insert_id){
				echo "success"; exit;
			}
				
			}else{
			
			$data = array(
			 	'contacts_title'=>$request->input('contacts_title'),
				'contacts_from'=>'phone_book',
				'temp'=>"yes",
				'phone_book_columns'=>json_encode(array('first_name', 'last_name', 'phone','email')),
				'phone_book_contacts'=>json_encode($contact_list),
				'created_by'=>Auth::user()->id,
				'modified_by'=>Auth::user()->id,
				'created_at'=>date("Y-m-d"),
				'updated_at'=>date("Y-m-d"),
			 );
			 
			$insert_id=DB::table('contacts')->insertGetId($data);	
			
			if($insert_id){
				echo "success"; exit;
			}
			
			}
		 } 
	   
    }
	
	
	
	
	
	

    /**
     * Display the specified resource.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(contact $contact)
    {
		
		//var_dump($contact);exit;

       return view('contacts.show')->with([
			'contact'=>$contact,
		
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(contact $contact)
    {
       
	   
	   
	   
	    return view('contacts.edit')->with([
			'contact'=>$contact,
		
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(contact $contact)
    {
         
		 
		$texts=text::where(array('contacts_id'=>$contact->contacts_id))->get(); 
		
		
		foreach($texts as $text){
			 DB::table('quees')->where(array('text_id'=> $text->text_id))->delete();
		}
	   
	  
		
		DB::table('texts')->where(array('contacts_id'=> $contact->contacts_id))->delete();
		$contact->delete();
		 
		return redirect('contact')->with('success', 'Contact Successfully Deleted');
    }
	
	
	
	
	
	
}
