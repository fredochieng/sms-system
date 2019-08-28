<?php

namespace App\Http\Controllers;

use App\text;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\contact;
use App\wgsms;
use App\quee;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;
use App\textprogress;

class TextController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	use HasRoles;
	protected $guard_name = 'web';


	public function index()
	{

		$user = Auth::user();
		$user_role = $user->getRoleNames()->first();



		if ($user_role == "Standard" || $user_role == "NOC Standard") {
			$texts = DB::table('texts')
				->select(
					DB::raw('texts.*'),
					DB::raw('contacts.*'),
					DB::raw('users.name AS created_by_name'),
					DB::raw('texts.created_at AS created_date'),
					DB::raw('texts.recepient_contacts AS recepient_contacts')


					//DB::raw('COUNT(quees.text_id) AS all_texts'),
					//DB::raw('COUNT(CASE WHEN quees.status = 2 THEN 1 END) AS sent_texts'),
					//DB::raw('COUNT(CASE WHEN quees.status = 1 THEN 1 END) AS queed_texts'),
					//DB::raw('COUNT(CASE WHEN quees.status = 3 THEN 1 END) AS cancelled_texts')
				)
				//->leftJoin('quees','texts.text_id','=','quees.text_id')
				->join('users', 'texts.created_by', '=', 'users.id')
				->leftJoin('contacts', 'texts.contacts_id', '=', 'contacts.contacts_id')
				//->groupBy(DB::raw('texts.text_id') )
				->orderBy('text_id', 'desc')
				->where('texts.created_by', '=', Auth::user()->id)
				->paginate(8);
		} elseif ($user_role == "admin") {

			$texts = DB::table('texts')
				->select(
					DB::raw('texts.*'),
					DB::raw('contacts.*'),
					DB::raw('users.name AS created_by_name'),
					DB::raw('texts.created_at AS created_date'),
					DB::raw('texts.recepient_contacts AS recepient_contacts')

					// DB::raw('COUNT(quees.text_id) AS all_texts'),
					//DB::raw('COUNT(CASE WHEN quees.status = 2 THEN 1 END) AS sent_texts'),
					//DB::raw('COUNT(CASE WHEN quees.status = 1 THEN 1 END) AS queed_texts'),
					//DB::raw('COUNT(CASE WHEN quees.status = 3 THEN 1 END) AS cancelled_texts')
				)
				//->leftJoin('quees','texts.text_id','=','quees.text_id')
				->join('users', 'texts.created_by', '=', 'users.id')
				->leftJoin('contacts', 'texts.contacts_id', '=', 'contacts.contacts_id')
				//->groupBy(DB::raw('texts.text_id') )
				->orderBy('text_id', 'desc')
				->paginate(8);
		} elseif ($user_role == "Supervisor" || $user_role == "NOC Supervisor") {

			if ($user_role == "Supervisor") {
				$users_by_role = User::role('Standard')->get()->toArray();
			} elseif ($user_role == "NOC Supervisor") {
				$users_by_role = User::role('NOC Standard')->get()->toArray();
			}

			$users_id_array = array();
			$users_id_array[] = Auth::user()->id;

			if (count($users_by_role) > 0) {
				foreach ($users_by_role as $user_by_role) {
					if ($user_by_role['organization_id'] == $user->organization_id) {
						$users_id_array[] = $user_by_role['id'];
					}
				}
			}

			/*		$texts=DB::table('texts')
  			  ->select(
			         DB::raw('texts.*'),
					 DB::raw('contacts.*'),
					 DB::raw('users.name AS created_by_name'),
			  		 DB::raw('COUNT(quees.text_id) AS all_texts'),
					 DB::raw('COUNT(CASE WHEN quees.status = 2 THEN 1 END) AS sent_texts'),
					 DB::raw('COUNT(CASE WHEN quees.status = 1 THEN 1 END) AS queed_texts'),
					 DB::raw('COUNT(CASE WHEN quees.status = 3 THEN 1 END) AS cancelled_texts')
				)
   			  ->leftJoin('quees','texts.text_id','=','quees.text_id')
			  ->join('users','texts.created_by','=','users.id')
			  ->leftJoin('contacts','texts.contacts_id','=','contacts.contacts_id')
			  ->groupBy(DB::raw('texts.text_id') )
			  ->whereIn('texts.created_by',$users_id_array)
			  ->orderBy('text_id','desc')
			  ->paginate(8);	  
			  */


			$texts = DB::table('texts')
				->select(
					DB::raw('texts.*'),
					DB::raw('contacts.*'),
					DB::raw('users.name AS created_by_name'),
					DB::raw('texts.created_at AS created_date'),
					DB::raw('texts.recepient_contacts AS recepient_contacts')

				)
				->join('users', 'texts.created_by', '=', 'users.id')
				->leftJoin('contacts', 'texts.contacts_id', '=', 'contacts.contacts_id')
				->whereIn('texts.created_by', $users_id_array)
				->orderBy('text_id', 'desc')
				->paginate(8);
		}

		$texts->setPath('http://62.8.88.218:98/index.php/text');

		return view('texts.list')->with(['texts' => $texts]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$user = Auth::user();

		$user_id = Auth::user()->id;


		$depts = DB::table('departments')
			->select(
				DB::raw('departments.*'),
				DB::raw('user_departments_mapping.*')
			)
			->leftJoin('user_departments_mapping', 'departments.department_id', '=', 'user_departments_mapping.mapping_dept_id')
			->where('user_departments_mapping.user_id', $user->id)->pluck('dept_name', 'department_id')->all();

		$number_of_depts = count($depts);


		if ($number_of_depts > 1) {
			$count = 'M';
			$departments = DB::table('departments')
				->select(
					DB::raw('departments.*'),
					DB::raw('user_departments_mapping.*')
				)
				->leftJoin('user_departments_mapping', 'departments.department_id', '=', 'user_departments_mapping.mapping_dept_id')
				->where('user_departments_mapping.user_id', $user->id)
				->orderBy('departments.department_id', 'asc')->get();
			$dept_id = '';
		} elseif ($number_of_depts == 1) {
			$count = 'O';
			$departments = DB::table('departments')
				->select(
					DB::raw('departments.*'),
					DB::raw('user_departments_mapping.*')
				)
				->leftJoin('user_departments_mapping', 'departments.department_id', '=', 'user_departments_mapping.mapping_dept_id')
				->where('user_departments_mapping.user_id', $user->id)
				->orderBy('departments.department_id', 'asc')->first();

			$dept_id = $departments->department_id;
		} elseif ($number_of_depts == 0) {
			$count = 'Z';
			$departments = DB::table('departments')
				->select(
					DB::raw('departments.*')
				)
				->where('departments.department_id', 5)
				->orderBy('departments.department_id', 'asc')->first();

			$dept_id = $departments->department_id;
		}

		$user_role = $user->getRoleNames()->first();

		if ($user_role == "NOC Supervisor" || $user_role == "NOC Standard") {


			$users_id_array = array();
			$users_id_array[] = Auth::user()->id;

			$users_by_role_noc_standard = User::role('NOC Standard')->get()->toArray();

			if (count($users_by_role_noc_standard) > 0) {
				foreach ($users_by_role_noc_standard as $user_by_role) {
					if ($user_by_role['organization_id'] == $user->organization_id) {
						$users_id_array[] = $user_by_role['id'];
					}
				}
			}


			$users_by_role_noc_supervisor = User::role('NOC Supervisor')->get()->toArray();

			if (count($users_by_role_noc_supervisor) > 0) {
				foreach ($users_by_role_noc_supervisor as $user_by_role) {
					if ($user_by_role['organization_id'] == $user->organization_id) {
						$users_id_array[] = $user_by_role['id'];
					}
				}
			}


			$contacts = contact::whereIn('created_by', $users_id_array)->orderBy('contacts_id', 'desc')->get();
		} elseif ($user_role == "admin") {
			$contacts = contact::orderBy('contacts_id', 'desc')->get();
		} else {

			$contacts = contact::where(array('created_by' => Auth::user()->id, 'temp' => 'yes'))->orderBy('contacts_id', 'desc')->get();
		}


		$suggested_csv_contact_column_names = config('wgsms.suggested_csv_contact_column_names');
		$countries = DB::table('recipients_country')->where(array('active' => 1))->get();

		$countries_array = array();
		foreach ($countries as $a_country) {
			$countries_array[$a_country->recipients_country_id] = $a_country->country_name;
		}

		return view('texts.create')->with([
			'contacts' => $contacts, 'suggested_csv_contact_column_names' => $suggested_csv_contact_column_names,
			'countries' => $countries_array, 'departments' => $departments, 'count' => $count, 'dept_id' => $dept_id
		]);
	}

	public function upload_csv(Request $request)
	{

		$continue = true;
		if ($request->hasFile('csv_file') && $request->file('csv_file')->isValid()) {
			$path = $_FILES['csv_file']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);

			if ($ext != 'csv') {
				echo "upload_error_extension";
				exit;
				$continue = false;
			}
		} else {
			echo "upload_error_extension";
			exit;
			$continue = false;
		}

		$save_for_future_switch = $request->input('save_for_future_switch');
		$store_csv_title = $path;
		$save_for_future_use = "no";

		if (isset($save_for_future_switch)) {


			$csv_title = $csv_upload_title = $request->input('csv_upload_title');


			if (!($csv_title)) {
				echo "upload_error_csv_title";
				exit;

				$continue = false;
			} else {

				$store_csv_title = $csv_title;
				$save_for_future_use = "yes";
			}
		}




		if ($continue) {


			$file = $request->file('csv_file');
			$file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
			$file->move('uploads/csv', $file_name);
			$file = 'uploads/csv/' . $file_name;



			$columns_array = array();
			$contacts_colums = 0;

			$row = 1;
			if (($handle = fopen($file, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					for ($c = 0; $c < $num; $c++) {
						$columns_array[] = $data[$c];
					}
					if ($row == 1) {
						break;
					}

					$row++;
				}
				fclose($handle);
			}




			$suggested_csv_contact_column_names = config('wgsms.suggested_csv_contact_column_names');
			$db_columns = $columns_array;

			// $phone_column_found=1;
			$count_through_columns = 0;

			$phone_column_found = 0;

			foreach ($db_columns as $column) {
				if (in_array(strtolower($column), $suggested_csv_contact_column_names)) {
					$phone_column_found = 2;

					break;
				}

				$count_through_columns = $count_through_columns + 1;
			}



			if ($phone_column_found == 2) { } else {
				echo "no_telephone_column";
				exit;
			}



			$data = array(
				'contacts_title' => $store_csv_title,
				'contacts_from' => 'csv',
				'temp' => $save_for_future_use,
				'csv_file' => $file,
				'csv_file_columns' => json_encode($columns_array),
				'csv_file_name' => $path,
				'created_by' => Auth::user()->id,
				'modified_by' => Auth::user()->id,
				'csv_file_columns' => json_encode($columns_array),
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d"),
				'csv_contacts_column' => $count_through_columns,

			);



			$insert_id = DB::table('contacts')->insertGetId($data);

			$return_array = array();
			$return_array['insert_id'] = $insert_id;
			$return_array['columns'] = $columns_array;
			$return_array['file_name'] = $path;
			$return_array['path'] = $file;
			$return_array['csv_title'] = $store_csv_title;

			echo json_encode($return_array);
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

		$dept_id = $request->input('user_department');

		$user = Auth::user();
		$role_id = $user->roles->first()->id;

		$user_priority = DB::table('roles_priorities')->where('role_id', $role_id)->first()->priority;


		$user_role = $user->getRoleNames()->toArray();

		$organization_id = DB::table('users')->where('id', Auth::user()->id)->first()->organization_id;

		#if($organization_id==2 && ( in_array('Standard',$user_role) || in_array('Supervisor',$user_role) ) ){
		if ($organization_id == 2) {
			if ($request->input('recepients_country') == 2) {
				$user_priority = 5;
			} else {
				$user_priority = 4;
			}
		}

		$this->validate($request, [
			'title' => 'required',
			'contact_source' => 'required',
			'messageBody' => 'required',

		]);

		$contact_source = $request->input('contact_source');

		$contact_id = 0;


		if ($contact_source == 'contact_list') {
			$contact_id = $request->input('contact_list');
		}

		if ($contact_source == 'csv_upload') {
			$contact_id = $request->input('send_contact_id');
		}

		$recipient_contacts = '';

		if ($contact_source == 'recepient_contacts') {
			$recipient_contacts = $request->input('recepients_phone_nos');
		}


		if (isset($_POST['save_draft'])) {

			$status = "draft";
			$redirect_mesage = "Text Saved as Draft";
		} else {
			$status = "published";
			$redirect_mesage = "Message successfully Submitted";
		}


		$text_id = $request->input('text_id');

		$status_update = $request->input('status');

		if (in_array('Standard', $user_role)) {

			if ($status_update == "published" || $status == "published") {
				if ($contact_source == "recepient_contacts") {
					$status = "published";
				} else {
					$status = "pending_approval";
				}
			} else {
				$status = $status;
			}
		}

		if ($text_id > 0) {
			$data = array(
				'text_title' => $request->input('title'),
				'status' => $status,
				'message' => $request->input('messageBody'),
				'from_source' => $contact_source,
				'recepient_contacts' => $recipient_contacts,
				'modified_by' => Auth::user()->id,
				'updated_at' => date("Y-m-d"),
				'recepient_country_id' => $request->input('recepients_country'),
				'user_department_id' => $request->input('user_department')
			);

			$insert_id = DB::table('texts')->where('text_id', $text_id)->update($data);

			$redirect_mesage = "Message successfully Updated";
		} else {


			if ($contact_source == 'contact_list') {
				foreach ($contact_id as $a_contact) {
					$data = array(
						'text_title' => $request->input('title'),
						'contacts_id' => $a_contact,
						'message' => $request->input('messageBody'),
						'status' => $status,
						'from_source' => $contact_source,
						'recepient_contacts' => $recipient_contacts,
						'created_by' => Auth::user()->id,
						'modified_by' => Auth::user()->id,
						'created_at' => date("Y-m-d H:i:s"),
						'updated_at' => date("Y-m-d"),
						'priority_id' => $user_priority,
						'recepient_country_id' => $request->input('recepients_country'),
						'user_department_id' => $request->input('user_department')
					);
					/*echo "<pre>";	 
						 print_r($data); exit;*/


					$insert_id = DB::table('texts')->insertGetId($data);

					$text_progress = new textprogress;
					$text_progress->txt_id = $insert_id;
					$text_progress->total_contacts = 0;
					$text_progress->delivered = 0;
					$text_progress->queed = 0;
					$text_progress->undelivered = 0;
					$text_progress->created_by = Auth::user()->id;
					$text_progress->updated_by = Auth::user()->id;
					$text_progress->save();
				}
			} else {

				$data = array(
					'text_title' => $request->input('title'),
					'contacts_id' => $contact_id,
					'message' => $request->input('messageBody'),
					'status' => $status,
					'from_source' => $contact_source,
					'recepient_contacts' => $recipient_contacts,
					'created_by' => Auth::user()->id,
					'modified_by' => Auth::user()->id,
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d"),
					'priority_id' => $user_priority,
					'recepient_country_id' => $request->input('recepients_country'),
					'user_department_id' => $request->input('user_department')
				);
				/*echo "<pre>";	 
			 print_r($data); exit;*/


				$insert_id = DB::table('texts')->insertGetId($data);

				$text_progress = new textprogress;
				$text_progress->txt_id = $insert_id;
				$text_progress->total_contacts = 0;
				$text_progress->delivered = 0;
				$text_progress->queed = 0;
				$text_progress->undelivered = 0;
				$text_progress->created_by = Auth::user()->id;
				$text_progress->updated_by = Auth::user()->id;
				$text_progress->save();
			}
		}

		return redirect('text')->with('success', $redirect_mesage);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\text  $text
	 * @return \Illuminate\Http\Response
	 */
	public function show(text $text)
	{
		$sent_texts = quee::where(array('text_id' => $text->text_id, 'status' => 2))->get();
		$all_texts = quee::where(array('text_id' => $text->text_id))->get();
		$cancelled_texts = quee::where(array('text_id' => $text->text_id, 'status' => 3))->get();
		$queed_texts = quee::where(array('text_id' => $text->text_id, 'status' => 1))->get();

		if (count($all_texts) > 0) {
			$percentage_progress = (($sent_texts->count() + $cancelled_texts->count()) / $all_texts->count()) * 100;
		} else {
			$percentage_progress = 0;
		}

		$text->sent_texts = $sent_texts;
		$text->all_texts = $all_texts;
		$text->percentage_progress = $percentage_progress;
		$text->cancelled_texts = $cancelled_texts;

		return view('texts.show')->with([
			'text_details' => $text,
			'sent_texts' => $sent_texts,
			'all_texts' => $all_texts,
			'cancelled_texts' => $cancelled_texts,
			'queed_texts' => $queed_texts,
			'percentage_progress' => round($percentage_progress),

		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\text  $text
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{

		$user = Auth::user();
		$user_role = $user->getRoleNames()->first();



		if ($user_role == "NOC Supervisor" || $user_role == "NOC Standard") {


			$users_id_array = array();
			$users_id_array[] = Auth::user()->id;

			$users_by_role_noc_standard = User::role('NOC Standard')->get()->toArray();

			if (count($users_by_role_noc_standard) > 0) {
				foreach ($users_by_role_noc_standard as $user_by_role) {
					if ($user_by_role['organization_id'] == $user->organization_id) {
						$users_id_array[] = $user_by_role['id'];
					}
				}
			}


			$users_by_role_noc_supervisor = User::role('NOC Supervisor')->get()->toArray();

			if (count($users_by_role_noc_supervisor) > 0) {
				foreach ($users_by_role_noc_supervisor as $user_by_role) {
					if ($user_by_role['organization_id'] == $user->organization_id) {
						$users_id_array[] = $user_by_role['id'];
					}
				}
			}


			$contacts = contact::whereIn('created_by', $users_id_array)->orderBy('contacts_id', 'desc')->get();
		} elseif ($user_role == "admin") {
			$contacts = contact::orderBy('contacts_id', 'desc')->get();
		} else {

			$contacts = contact::where(array('created_by' => Auth::user()->id, 'temp' => 'yes'))->orderBy('contacts_id', 'desc')->get();
		}


		$suggested_csv_contact_column_names = config('wgsms.suggested_csv_contact_column_names');

		$text = text::where(array('text_id' => $id))->first();
		$text->contact_details = contact::where("contacts_id", $text->contacts_id)->first();
		return view('texts.edit')->with([
			'contacts' => $contacts,
			'text' => $text,
			'suggested_csv_contact_column_names' => $suggested_csv_contact_column_names

		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\text  $text
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, text $text)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\text  $text
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(text $text)
	{
		//
	}



	public function create_text()
	{
		return view('texts.create_text');
	}


	public function check_selected_contact_type()
	{
		$contacts_id = $_GET['contacts_id'];
		$contacts = contact::where(array('contacts_id' => $contacts_id))->first();

		$data = array("status" => 'no');

		if ($contacts->contacts_from == 'phone_book') {
			$data = array("status" => 'yes', "columns" => json_decode($contacts->phone_book_columns));
		}

		if ($contacts->contacts_from == 'csv') {
			$data = array("status" => 'yes', "columns" => json_decode($contacts->csv_file_columns));
		}


		echo json_encode($data);
		exit;
	}




	public function action_text($id, $status)
	{
		if ($status == "cancel") {
			$text_cancel = DB::table('texts')->where(array('text_id' => $id))->update(array('status' => 'canceled', 'modified_by' => Auth::user()->id, 'updated_at' => date("Y-m-d")));
			$quees_cancel = DB::table('quees')->where(array('text_id' => $id, 'status' => 1))->update(array('status' => '4'));

			$redirect_text = "Text Message Sending successfully cancelled";
		}

		if ($status == "delete") {
			DB::table('texts')->where(array('text_id' => $id))->delete();
			DB::table('quees')->where(array('text_id' => $id))->delete();

			$redirect_text = "Text Message Successfully Deleted";
		}


		return redirect('text')->with('success', $redirect_text);
	}

	public function approvetext($passed_status, $id)
	{

		if ($passed_status == "approve") {
			$status = "published";
			$redirect_text = "Text Succesfully Approved";
		}

		if ($passed_status == "unapprove") {
			$status = "pending_approval";
			$redirect_text = "Text Succesfully Unapproved";
		}


		if ($status == "published" || $status == "pending_approval") {
			DB::table('texts')->where('text_id', $id)->update(array('status' => $status));
		}

		return redirect('text')->with('success', $redirect_text);
	}



	public function status($text_id, $status)
	{


		$text = text::where(array('text_id' => $text_id))->first();




		$sent_texts = quee::where(array('text_id' => $text->text_id, 'status' => 2))->get();
		$all_texts = quee::where(array('text_id' => $text->text_id))->get();
		$cancelled_texts = quee::where(array('text_id' => $text->text_id, 'status' => 3))->get();
		$queed_texts = quee::where(array('text_id' => $text->text_id, 'status' => 1))->get();

		if (count($all_texts) > 0) {
			$percentage_progress = (($sent_texts->count() + $cancelled_texts->count()) / $all_texts->count()) * 100;
		} else {
			$percentage_progress = 0;
		}

		$text->sent_texts = $sent_texts;
		$text->all_texts = $all_texts;
		$text->percentage_progress = $percentage_progress;
		$text->cancelled_texts = $cancelled_texts;


		if ($status == "delivered") {
			$sms_data = $sent_texts;
		} elseif ($status == "queed") {
			$sms_data = $queed_texts;
		} elseif ($status == "undelivered") {
			$sms_data = $cancelled_texts;
		}

		return view('texts.status')->with([
			'text_details' => $text,
			'sent_texts' => $sent_texts,
			'all_texts' => $all_texts,
			'cancelled_texts' => $cancelled_texts,
			'queed_texts' => $queed_texts,
			'percentage_progress' => round($percentage_progress),
			'sms_data' => $sms_data,
			'status' => $status,

		]);
	}

	private function validate_phone_no($phone_no)
	{

		$required_phone_lengths = array(9, 10, 12);
		$phone_length = (string) strlen($phone_no);

		if (in_array($phone_length, $required_phone_lengths) && ctype_digit($phone_no)) {
			return true;
		} else {
			return false;
		}
	}

	public function sms_preview()
	{

		//echo "text";exit;
		$contacts = $_GET['contacts'];
		$from_source = $_GET['contact_source'];
		$previewmessage = $_GET['message'];
		$recipient_country = $_GET['recipient_country'];

		$final_preview_message = '';
		$valid_contacts = 0;
		$invalid_contacts = 0;
		$duplicate_contacts = 0;

		$duplicate_contacts_array = array();

		if ($from_source == 'contact_list' || $from_source == 'csv_upload') {

			if ($from_source == 'contact_list') {
				$contact_id = $contacts[0];
			}


			if ($from_source == 'csv_upload') {
				$contact_id = $contacts;
			}


			$contacts = contact::find($contact_id);



			if ($contacts->contacts_from == "csv") {
				$shortcodes = json_decode($contacts->csv_file_columns);

				$csv_file = $contacts->csv_file;
				$row = 1;

				$send_list = array();
				$msg_list = array();

				if (($handle = fopen($csv_file, "r")) !== FALSE) {
					while (($data = fgetcsv($handle, '', ",")) !== FALSE) {
						$telephone_column = '';
						$num = count($data);
						//echo "<p> $num fields in line $row: <br /></p>\n";

						$phone_no = '';
						$columns_in_csv = array();

						for ($c = 0; $c < $num; $c++) {
							$columns_in_csv[$c] = $data[$c];
							if ($c == $contacts->csv_contacts_column) {
								$phone_no = $data[$c];
							}
						}

						$data = array();
						if ($row > 1) {

							//echo "<pre>";

							$no_of_columns_in_csv = count($shortcodes);
							$message = $previewmessage;

							for ($x = 0; $x <= $no_of_columns_in_csv - 1; $x++) {
								#$data[trim($shortcodes[$x])] = $columns_in_csv[$x];

								$field_tag = "{" . $shortcodes[$x] . "}";
								$message = str_replace($field_tag, $columns_in_csv[$x], $message);
							}

							if ($row == 2) {
								$final_preview_message = $message;
							}

							/*if(in_array($phone_no,$duplicate_contacts_array)){
							$duplicate_contacts++;	
						}
						
						$duplicate_contacts_array[]=$phone_no;*/

							if ($this->validate_phone_no($phone_no)) {
								$valid_contacts++;
							} else {
								$invalid_contacts++;
							}
						}
						$total_contacts = $row - 1;
						$row++;
					}
					fclose($handle);
				}
			}

			if ($contacts->contacts_from == "phone_book") {


				$contacts_details = (array) json_decode($contacts->phone_book_contacts);


				$phone_book_colums = (array) json_decode($contacts->phone_book_columns);
				$no_of_columns_count = count($phone_book_colums);


				foreach ($contacts_details as $key => $contact) {

					$phone_no = $contact->phone;
					$message = $previewmessage;
					$contacts_array =  (array) $contact;

					foreach ($phone_book_colums as $phone_book_colum) {

						$field_tag = "{" . $phone_book_colum . "}";
						$contact_field = $contacts_array[$phone_book_colum];
						$message = str_replace($field_tag, $contact_field, $message);
					}

					if ($key == 1) {
						$final_preview_message = $message;
					}

					/*if(in_array($phone_no,$duplicate_contacts_array)){
							$duplicate_contacts++;	
						}
						
						$duplicate_contacts_array[]=$phone_no;*/

					if ($this->validate_phone_no($phone_no)) {
						$valid_contacts++;
					} else {
						$invalid_contacts++;
					}
				}


				$total_contacts = count($contacts_details);
			}
		}


		if ($from_source == "recepient_contacts") {
			$contacts = explode(',', $contacts);
			$trimmed_contacts = array_map('trim', $contacts);
			foreach ($trimmed_contacts as $phone_no) {


				if ($this->validate_phone_no($phone_no)) {
					$valid_contacts++;
				} else {
					$invalid_contacts++;
				}
			}

			$total_contacts = count($contacts);
			$final_preview_message = $previewmessage;
		}

		//$recipient_country=$_GET['recipient_country'];

		$recepient_country = DB::table('recipients_country')->where(array('recipients_country_id' => $recipient_country))->first()->country_name;
		//$recipient_country='NAME';

		$message_length = strlen($final_preview_message);


		$return_array = array();
		$return_array['message_length'] = $message_length;
		$return_array['recepient_country'] = $recepient_country;
		$return_array['invalid_contacts'] = $invalid_contacts;
		$return_array['valid_contacts'] = $valid_contacts;
		$return_array['final_preview_message'] = $final_preview_message;
		$return_array['total_contacts'] = $total_contacts;

		echo json_encode($return_array);
	}
}