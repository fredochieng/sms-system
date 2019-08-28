<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\contact;
use App\wgsms;
use App\quee;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DateInterval;
use DatePeriod;
use DateTime;

use App\User;
use App\text;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\UpdateSummaryReportJob;

//use Excel;

class ReportsController extends Controller
{

	public function by_campaign()
	{
		$user = Auth::user();
		$user_role = $user->getRoleNames()->first();

		if ($user_role == "Standard" || $user_role == "NOC Standard") {
			$texts = DB::table('texts')
				->select(array('texts.*', 'users.name as created_by_name'))
				->join('users', 'texts.created_by', '=', 'users.id')
				->orderBy('text_id', 'desc')
				->where('created_by', '=', Auth::user()->id)
				->paginate(10);
			$texts->setPath('http://62.8.88.218:98/index.php/reports/by_campaign');
		} elseif ($user_role == "admin") {
			$texts = DB::table('texts')
				->select(array('texts.*', 'users.name as created_by_name'))
				->join('users', 'texts.created_by', '=', 'users.id')
				->orderBy('text_id', 'desc')
				->paginate(10);

			$texts->setPath('http://62.8.88.218:98/index.php/reports/by_campaign');
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

			$texts = DB::table('texts')
				->select(array('texts.*', 'users.name as created_by_name'))
				->join('users', 'texts.created_by', '=', 'users.id')
				->whereIn('created_by', $users_id_array)
				->orderBy('text_id', 'desc')
				->paginate(10);


			$texts->setPath('http://62.8.88.218:98/index.php/reports/by_campaign');
		}


		// $sent_items=quee::where(array('text_id'=>$texts->text_id,'status'=>2))->get();


		/*	 
		foreach($texts as $a_text){
			if($a_text->contacts_id > 0){
				$a_text->contact_details=contact::where("contacts_id",$a_text->contacts_id)->first();
			}else{
				$a_text->contact_details='';
			}
			
			$sent_texts=quee::where(array('text_id'=>$a_text->text_id,'status'=>2))->get();
			 $all_texts=quee::where(array('text_id'=>$a_text->text_id))->get();
			 $cancelled_texts=quee::where(array('text_id'=>$a_text->text_id,'status'=>3))->get();
			 

			 
			 if(count($all_texts) > 0){
					 $percentage_progress=(($sent_texts->count()+ $cancelled_texts->count())/ $all_texts->count())*100;
			 }else{
				  $percentage_progress=0;
			}
			 
			 $a_text->sent_texts=$sent_texts->count();
			 $a_text->all_texts=$all_texts->count();
			 $a_text->percentage_progress=($percentage_progress);
			 $a_text->cancelled_texts=$cancelled_texts->count();
			
		}
		*/


		return view('reports.by_campaign')->with(['texts' => $texts]);
	}

	private function generate_excel_query($text_id, $status)
	{
		$text = DB::table('texts')->where('text_id', $text_id)->first();
		$text_title = $text->text_title;
		$created_by = DB::table('users')->where('id', $text->created_by)->first()->name;
		$sms_query = '';

		if ($status == 'all') {
			$sms_query = DB::table('quees')->where('text_id', $text_id)->get();
		} else {
			if (is_array($status)) {
				$sms_query = DB::table('quees')->where(array('text_id' => $text_id))->whereIn('status', $status)->get();
			} else {
				$sms_query = DB::table('quees')->where(array('text_id' => $text_id, 'status' => $status))->get();
			}
		}

		$data_array[] = array('MOBILE', 'STATUS', 'TIME', 'AUTHOR', 'REASON', 'CAMPAIGN', 'MESSAGE', 'COUNTRY', 'DEPARTMENT');

		if ($sms_query) {

			foreach ($sms_query as $sms) {

				if ($sms->status == 1) {
					$status_put = 'QUEED';
				} elseif ($sms->status == 2) {
					$status_put = 'DELIVERED';
				} elseif ($sms->status == 3) {
					$status_put = 'UNDELIVERED';
				} elseif ($sms->status == 4) {
					$status_put = 'CANCELED';
				} else {
					$status_put = 'UNKNOWN';
				}

				$data_array[] = array(
					$sms->phone_no,
					$status_put,
					date("d-m-Y h:m:s A", strtotime($sms->time_sent)),
					$created_by,
					$sms->reason,
					$text_title,
					$sms->message

				);
			}
		}

		$GLOBALS['data_array'] = $data_array;
		\Excel::create(str_replace(' ', '_', $text_title . date("_d-m-Y__h:m:s_A")), function ($excel) {
			$excel->sheet('Sheetname', function ($sheet) {
				$sheet->fromArray($GLOBALS['data_array']);
			});
		})->export('csv');
	}


	public function generate_excel($text_id, $status)
	{
		$this->generate_excel_query($text_id, $status);
	}


	public function filtered_generate_excel()
	{

		if (isset($_POST['status'])) {
			$status = $_POST['status'];
		} else {
			$status = 'all';
		}

		$text_id = $_POST['text_id'];

		$this->generate_excel_query($text_id, $status);
	}

	public function all_sms(Request $request)
	{

		if (isset($_POST['export'])) {
			$this->validate($request, [
				'from_date' => 'required',
				'to_date' => 'required',
			]);

			$from_date = date("Y-m-d", strtotime($request->input('from_date')));
			$to_date = date("Y-m-d", strtotime($request->input('to_date')));

			$user = Auth::user();
			$user_role = $user->getRoleNames()->first();

			if ($user_role == "Standard" || $user_role == "NOC Standard") {
				$texts = DB::table('texts')
					->select(array('texts.*', 'users.name as created_by_name'))
					->join('users', 'texts.created_by', '=', 'users.id')
					->orderBy('text_id', 'desc')
					->where('created_by', '=', Auth::user()->id)
					->whereBetween('texts.created_at', array($from_date, $to_date))
					->get();
			} elseif ($user_role == "admin") {
				$texts = DB::table('texts')
					->select(array('texts.*', 'users.name as created_by_name'))
					->join('users', 'texts.created_by', '=', 'users.id')
					->orderBy('text_id', 'desc')
					->whereBetween('texts.created_at', array($from_date, $to_date))
					->get();
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

				$texts = DB::table('texts')
					->select(array('texts.*', 'users.name as created_by_name'))
					->join('users', 'texts.created_by', '=', 'users.id')
					->whereIn('created_by', $users_id_array)
					->orderBy('text_id', 'desc')
					->whereBetween('texts.created_at', array($from_date, $to_date))
					->get();
			}

			$sms_text_ids = array();

			foreach ($texts as $text) {
				$sms_text_ids[] = $text->text_id;
			}

			if (isset($_POST['status'])) {
				$sms_query = DB::table('quees')->whereIn('text_id', $sms_text_ids)->whereIn('status', $_POST['status'])->get();
			} else {
				$sms_query = DB::table('quees')->whereIn('text_id', $sms_text_ids)->get();
			}


			if ($sms_query) {

				$data_array[] = array('MOBILE', 'STATUS', 'TIME', 'AUTHOR', 'REASON', 'CAMPAIGN', 'MESSAGE');
				foreach ($sms_query as $sms) {
					if ($sms->status == 1) {
						$status_put = 'QUEED';
					} elseif ($sms->status == 2) {
						$status_put = 'DELIVERED';
					} elseif ($sms->status == 3) {
						$status_put = 'UNDELIVERED';
					} elseif ($sms->status == 4) {
						$status_put = 'CANCELED';
					} else {
						$status_put = 'UNKNOWN';
					}


					$text = DB::table('texts')->where('text_id', $sms->text_id)->first();
					$created_by = DB::table('users')->where('id', $text->created_by)->first()->name;

					$text_title = $text->text_title;

					$data_array[] = array(
						$sms->phone_no,
						$status_put,
						date("d-m-Y h:m:s A", strtotime($sms->time_sent)),
						$created_by,
						$sms->reason,
						$text_title,
						$sms->message

					);
				}
				$text_title_disp = "SMS_Report_";

				$GLOBALS['data_array'] = $data_array;
				\Excel::create(str_replace(' ', '_', $text_title_disp . date("_d-m-Y__h:m:s_A")), function ($excel) {
					$excel->sheet('Sheetname', function ($sheet) {
						$sheet->fromArray($GLOBALS['data_array']);
					});
				})->export('csv');
			}
		}
		return view('reports.all_sms');
	}


	public function advanced_reports(Request $request)
	{
		$data['countries'] = DB::table('recipients_country')->orderBy('recipients_country_id', 'asc')->get();
		$data['departments'] = DB::table('departments')->orderBy('department_id', 'asc')->get();
		$data['status'] = DB::table('quee_status')->orderBy('quee_status_ID', 'asc')->get();

		if (isset($_POST['export'])) {
			$this->validate($request, [
				'from_date' => 'required',
				'to_date' => 'required',
			]);

			$country = $request->input('country');
			$department = $request->input('department');
			$status = $request->input('status');
			$from_date = date("Y-m-d", strtotime($request->input('from_date')));
			$to_date = date("Y-m-d", strtotime($request->input('to_date')));

			$countries = implode(",", $country);
			$departments = implode(",", $department);
			$statuses = implode(",", $status);

			$parameters = array("country", "department", "status", "start_date", "end_date");
			$value = array($countries, $departments, $statuses, $from_date, $to_date);
			$output = array_combine($parameters, $value);

			$output = json_encode($output);

			$user = Auth::user();

			$user_id = $user->id;

			$req_reports = array(
				'requested_by' => $user_id,
				'parameters' => $output
			);

			$save_scheduled_report = DB::table('report_jobs')->insertGetId($req_reports);

			$user_role = $user->getRoleNames()->first();


			if ($user_role == "Standard" || $user_role == "NOC Standard") {
				// $texts = DB::table('quees')
				// 	->select(
				// 		DB::raw('quees.*'),
				// 		DB::raw('texts.*'),
				// 		DB::raw('users.name as created_by_name'),
				// 		DB::raw('recipients_country.*'),
				// 		DB::raw('departments.*'),
				// 		DB::raw('user_departments_mapping.*')
				// 	)
				// 	->leftJoin('texts', 'quees.text_id', '=', 'texts.text_id')
				// 	->leftJoin('users', 'texts.created_by', '=', 'users.id')
				// 	->leftJoin('recipients_country', 'texts.recepient_country_id', '=', 'recipients_country.recipients_country_id')
				// 	->leftJoin('user_departments_mapping', 'users.id', 'user_departments_mapping.user_id')
				// 	->leftJoin('departments', 'user_departments_mapping.mapping_dept_id', 'departments.department_id')
				// 	->orderBy('que_id', 'desc')
				// 	->where('created_by', '=', Auth::user()->id)
				// 	->whereBetween('texts.created_at', array($from_date, $to_date))
				// 	->whereIn('recepient_country_id', $country)
				// 	//->whereIn('users.department_id', $department)
				// 	->whereIn('user_departments_mapping.mapping_dept_id', $department)
				// 	->get();
				$texts = DB::table('quees')
					->select(
						DB::raw('quees.*'),
						DB::raw('texts.text_title as batchname'),
						DB::raw('texts.message as msgtemplate'),
						DB::raw('texts.created_at as text_date'),
						DB::raw('texts.priority_id'),
						DB::raw('quees.que_id'),
						DB::raw('quees.phone_no'),
						DB::raw('quees.status'),
						DB::raw('quees.message'),
						DB::raw('users.name as created_by'),
						DB::raw('users.id as userid'),
						DB::raw('recipients_country.country_name as country'),
						DB::raw('departments.dept_name as department'),
						DB::raw('departments.department_id as departmentid'),
						DB::raw('user_departments_mapping.mapping_dept_id'),
						DB::raw('user_departments_mapping.user_id')
					)
					->Join('texts', 'quees.text_id', '=', 'texts.text_id')
					->Join('users', 'texts.created_by', '=', 'users.id')
					->Join('recipients_country', 'texts.recepient_country_id', '=', 'recipients_country.recipients_country_id')
					->Join('user_departments_mapping', 'users.id', 'user_departments_mapping.user_id')
					->Join('departments', 'user_departments_mapping.mapping_dept_id', 'departments.department_id')
					->orderBy('que_id', 'desc')
					->where('created_by', '=', Auth::user()->id)
					->whereRaw("CAST(texts.created_at as DATE) between '" . $from_date . "' and '" . $to_date . "'")
					->whereIn('recepient_country_id', $country)
					->whereIn('user_departments_mapping.mapping_dept_id', $department)
					->whereIn('quees.status', $status)
					->get();

				if ($texts) {

					$data_array[] = array('MOBILE', 'STATUS', 'TIME', 'AUTHOR', 'REASON', 'CAMPAIGN', 'MESSAGE', 'COUNTRY', 'DEPARTMENT');
					foreach ($texts as $sms) {
						if ($sms->status == 1) {
							$status_put = 'QUEED';
						} elseif ($sms->status == 2) {
							$status_put = 'DELIVERED';
						} elseif ($sms->status == 3) {
							$status_put = 'UNDELIVERED';
						} elseif ($sms->status == 4) {
							$status_put = 'CANCELED';
						} else {
							$status_put = 'UNKNOWN';
						}

						$text = DB::table('texts')->where('text_id', $sms->text_id)->first();
						$created_by = DB::table('users')->where('id', $text->created_by)->first()->name;
						$country = DB::table('recipients_country')->where('recipients_country_id', $text->recepient_country_id)->first()->country_name;

						$text_title = $text->text_title;

						$data_array[] = array(
							$sms->phone_no,
							$status_put,
							date("d-m-Y h:m:s A", strtotime($sms->time_sent)),
							$created_by,
							$sms->reason,
							$text_title,
							$sms->message,
							$country,
							$sms->department
						);
					}
					$text_title_disp = "SMS_Report_";

					$GLOBALS['data_array'] = $data_array;
					\Excel::create(str_replace(' ', '_', $text_title_disp . date("_d-m-Y__h:m:s_A")), function ($excel) {
						$excel->sheet('Sheetname', function ($sheet) {
							$sheet->fromArray($GLOBALS['data_array']);
						});
					})->export('csv');
				}
			} elseif ($user_role == "admin") {

				$texts = DB::table('quees')
					->select(
						DB::raw('quees.que_id'),
						DB::raw('quees.phone_no'),
						DB::raw('quees.message'),
						DB::raw('texts.created_at as text_date'),
						DB::raw('users.name as created_by'),
						DB::raw('users.id as userid'),
						DB::raw('recipients_country.country_name as country'),
						DB::raw('departments.dept_name as department'),
						DB::raw('departments.department_id as departmentid'),
						DB::raw('user_departments_mapping.mapping_dept_id'),
						DB::raw('user_departments_mapping.user_id')
					)
					->Join('texts', 'quees.text_id', '=', 'texts.text_id')
					->Join('users', 'texts.created_by', '=', 'users.id')
					->Join('recipients_country', 'texts.recepient_country_id', '=', 'recipients_country.recipients_country_id')
					->Join('user_departments_mapping', 'users.id', 'user_departments_mapping.user_id')
					->Join('departments', 'user_departments_mapping.mapping_dept_id', 'departments.department_id')
					->orderBy('que_id', 'desc')
					->whereRaw("CAST(texts.created_at as DATE) between '" . $from_date . "' and '" . $to_date . "'")
					->whereIn('recepient_country_id', $country)
					->whereIn('user_departments_mapping.mapping_dept_id', $department)
					->whereIn('quees.status', $status)
				->get();

				echo "<pre>";
				print_r($texts);
				exit;

				if ($texts) {

					$data_array[] = array('MOBILE', 'STATUS', 'TIME', 'AUTHOR', 'REASON', 'CAMPAIGN', 'MESSAGE', 'COUNTRY', 'DEPARTMENT');
					foreach ($texts as $sms) {
						if ($sms->status == 1) {
							$status_put = 'QUEED';
						} elseif ($sms->status == 2) {
							$status_put = 'DELIVERED';
						} elseif ($sms->status == 3) {
							$status_put = 'UNDELIVERED';
						} elseif ($sms->status == 4) {
							$status_put = 'CANCELED';
						} else {
							$status_put = 'UNKNOWN';
						}

						$text = DB::table('texts')->where('text_id', $sms->text_id)->first();
						$created_by = DB::table('users')->where('id', $text->created_by)->first()->name;
						//$country = DB::table('recipients_country')->where('recipients_country_id', $text->recepient_country_id)->first()->country_name;

						// if ($text->country == '') {
						// 	$country = 'KENYA';
						// }

						// if ($text->recepient_country_id == '') {

						// 	$country = 'KENYA';
						// } else {
						// 	$country = DB::table('recipients_country')->where('recipients_country_id', $text->recepient_country_id)->first()->country_name;
						// }

						$text_title = $text->text_title;

						$data_array[] = array(
							$sms->phone_no,
							$status_put,
							date("d-m-Y h:m:s A", strtotime($sms->time_sent)),
							$created_by,
							$sms->reason,
							$text_title,
							$sms->message,
							$sms->country,
							$sms->department
						);
					}
					$text_title_disp = "SMS_Report_";

					$GLOBALS['data_array'] = $data_array;
					\Excel::create(str_replace(' ', '_', $text_title_disp . date("_d-m-Y__h:m:s_A")), function ($excel) {
						$excel->sheet('Sheetname', function ($sheet) {
							$sheet->fromArray($GLOBALS['data_array']);
						});
					})->export('csv');
				}
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

				//$texts = DB::table('quees')
				// ->select(
				// 	DB::raw('quees.*'),
				// 	DB::raw('texts.*'),
				// 	DB::raw('users.name as created_by_name'),
				// 	DB::raw('recipients_country.*'),
				// 	DB::raw('departments.*'),
				// 	DB::raw('user_departments_mapping.*')
				// )
				// ->leftJoin('texts', 'quees.text_id', '=', 'texts.text_id')
				// ->leftJoin('users', 'texts.created_by', '=', 'users.id')
				// ->leftJoin('recipients_country', 'texts.recepient_country_id', '=', 'recipients_country.recipients_country_id')
				// ->leftJoin('user_departments_mapping', 'users.id', 'user_departments_mapping.user_id')
				// ->leftJoin('departments', 'user_departments_mapping.mapping_dept_id', 'departments.department_id')
				// ->orderBy('que_id', 'desc')
				// ->whereIn('created_by', $users_id_array)
				// ->whereBetween('texts.created_at', array($from_date, $to_date))
				// ->whereIn('recepient_country_id', $country)
				// //->whereIn('users.department_id', $department)
				// ->whereIn('user_departments_mapping.mapping_dept_id', $department)
				// ->get();

				$texts = DB::table('quees')
					->select(
						DB::raw('quees.*'),
						DB::raw('texts.text_title as batchname'),
						DB::raw('texts.message as msgtemplate'),
						DB::raw('texts.created_at as text_date'),
						DB::raw('texts.priority_id'),
						DB::raw('quees.que_id'),
						DB::raw('quees.phone_no'),
						DB::raw('quees.status'),
						DB::raw('quees.message'),
						DB::raw('users.name as created_by'),
						DB::raw('users.id as userid'),
						DB::raw('recipients_country.country_name as country'),
						DB::raw('departments.dept_name as department'),
						DB::raw('departments.department_id as departmentid'),
						DB::raw('user_departments_mapping.mapping_dept_id'),
						DB::raw('user_departments_mapping.user_id')
					)
					->Join('texts', 'quees.text_id', '=', 'texts.text_id')
					->Join('users', 'texts.created_by', '=', 'users.id')
					->Join('recipients_country', 'texts.recepient_country_id', '=', 'recipients_country.recipients_country_id')
					->Join('user_departments_mapping', 'users.id', 'user_departments_mapping.user_id')
					->Join('departments', 'user_departments_mapping.mapping_dept_id', 'departments.department_id')
					->orderBy('que_id', 'desc')
					->whereIn('created_by', $users_id_array)
					->whereRaw("CAST(texts.created_at as DATE) between '" . $from_date . "' and '" . $to_date . "'")
					->whereIn('recepient_country_id', $country)
					->whereIn('user_departments_mapping.mapping_dept_id', $department)
					->whereIn('quees.status', $status)
					->get();

				if ($texts) {

					$data_array[] = array('MOBILE', 'STATUS', 'TIME', 'AUTHOR', 'REASON', 'CAMPAIGN', 'MESSAGE', 'COUNTRY', 'DEPARTMENT');
					foreach ($texts as $sms) {
						if ($sms->status == 1) {
							$status_put = 'QUEED';
						} elseif ($sms->status == 2) {
							$status_put = 'DELIVERED';
						} elseif ($sms->status == 3) {
							$status_put = 'UNDELIVERED';
						} elseif ($sms->status == 4) {
							$status_put = 'CANCELED';
						} else {
							$status_put = 'UNKNOWN';
						}

						$text = DB::table('texts')->where('text_id', $sms->text_id)->first();
						$created_by = DB::table('users')->where('id', $text->created_by)->first()->name;
						$country = DB::table('recipients_country')->where('recipients_country_id', $text->recepient_country_id)->first()->country_name;

						$text_title = $text->text_title;

						$data_array[] = array(
							$sms->phone_no,
							$status_put,
							date("d-m-Y h:m:s A", strtotime($sms->time_sent)),
							$created_by,
							$sms->reason,
							$text_title,
							$sms->message,
							$country,
							$sms->department
						);
					}
					$text_title_disp = "SMS_Report_";

					$GLOBALS['data_array'] = $data_array;
					\Excel::create(str_replace(' ', '_', $text_title_disp . date("_d-m-Y__h:m:s_A")), function ($excel) {
						$excel->sheet('Sheetname', function ($sheet) {
							$sheet->fromArray($GLOBALS['data_array']);
						});
					})->export('csv');
				}
			}

			$sms_text_ids = array();

			foreach ($texts as $text) {
				$sms_text_ids[] = $text->text_id;
			}

			return back()->with('success', 'Your report is being generated and will be sent to your mail');
		}
		return view('reports.advanced_report')->with($data);
	}

	public function summary_reports(Request $request)
	{
		$data['countries'] = DB::table('recipients_country')->orderBy('recipients_country_id', 'asc')->get();
		$data['departments'] = DB::table('departments')->orderBy('department_id', 'asc')->get();

		return view('reports.summary_report')->with($data);
	}

	public function show_summary_report(Request $request)
	{
		if (isset($_POST['generate_daily'])) {
			$data['report_type'] = 'D';
			$country = $request->input('country_id');
			$department = $request->input('dept_id');
			$report_date = $request->input('report_date');

			$country_data = DB::table('recipients_country')->where('recipients_country_id', '=', $country)->first();
			$data['country_name'] = $country_data->country_name;
			$dept_data = DB::table('departments')->where('department_id', '=', $department)->first();
			$data['dept_name'] = $dept_data->dept_name;

			$texts = DB::table('summary_report')
				->select(
					DB::raw('summary_report.*')
				)
				->where('country_id', $country)
				->where('dept_id', $department)
				->where('date', $report_date)
				->get();

			$daily_report = (array) $texts;

			if (array_filter($daily_report) == []) {
				$data['sent'] = 0;
				$data['delivered'] = 0;
				$data['failed'] = 0;
				$data['pending'] = 0;
				$data['date'] = $report_date;
			} else {
				$data['sent'] = $texts[0]->sent;
				$data['delivered'] = $texts[0]->delivered;;
				$data['failed'] = $texts[0]->failed;
				$data['pending'] = $texts[0]->pending;
				$data['date'] = $report_date;
			}

			return view('reports.daily_summary_report')->with($data);
		} elseif (isset($_POST['generate_monthly'])) {

			$country = $request->input('country_id');
			$department = $request->input('dept_id');
			$report_date = $request->input('report_date');

			$country_data = DB::table('recipients_country')->where('recipients_country_id', '=', $country)->first();
			$country_name = $country_data->country_name;
			$dept_data = DB::table('departments')->where('department_id', '=', $department)->first();
			$dept_name = $dept_data->dept_name;

			$date = Carbon::parse($report_date);
			$month_name = $date->format('F');
			$year_name = $date->year;

			$first_day = new Carbon('first day of' . $month_name . $year_name);
			$first_day = $first_day->toDateString();

			$report_date = $report_date;

			$begin = new DateTime($first_day);
			$end   = new DateTime($report_date);


			$dates = array();
			for ($i = $begin; $i <= $end; $i->modify('+1 day')) {

				$dates[] = $i->format("Y-m-d");
			}

			$data['texts'] = DB::table('summary_report')
				->select(
					DB::raw('summary_report.*')
				)
				->where('country_id', $country)
				->where('dept_id', $department)
				->whereBetween('date', array($first_day, $report_date))
				->get();

			$total_sms = DB::table('monthly_summary_report')
				->select(
					DB::raw('monthly_summary_report.*')
				)
				->where('country_id', $country)
				->where('dept_id', $department)
				->where('date', $report_date)
				->get();

			// echo "<pre>";
			// print_r($data['texts']);
			// exit;
			$monthly_tot = (array) $total_sms;
			if (array_filter($monthly_tot) == []) {
				$data['total_sent'] = 0;
				$data['total_delivered'] = 0;
				$data['total_failed'] = 0;
				$data['total_pending'] = 0;
			} else {

				$data['total_sent'] = $total_sms[0]->sent;
				$data['total_delivered'] = $total_sms[0]->delivered;
				$data['total_failed'] = $total_sms[0]->failed;
				$data['total_pending'] = $total_sms[0]->pending;
			}


			$all_dates = array();
			$all_sent = array();
			$all_delivered = array();
			$all_failed = array();
			$all_pending = array();
			foreach ($data['texts'] as $key => $value) {
				$all_dates[] = $value->date;
				$all_sent[] = $value->sent;
				$all_delivered[] = $value->delivered;
				$all_failed[] = $value->failed;
				$all_pending[] = $value->pending;
			}

			$output = array_diff($dates, $all_dates);

			$total_sent = array();
			$total_delivered = array();
			$total_failed = array();
			$total_pending = array();

			foreach ($output as $key => $value) {

				$null_days_array = array(
					"summary_id" => 1, "date" => $value, "country_id" => $country, "dept_id" => $department,
					"sent" => 0, "delivered"  => 0, "failed"  => 0, "pending"  => 0, "created_at" => $report_date, "updated_at" => $report_date
				);
				// echo "<pre>";
				//	print_r($null_days_array);
			}


			$all_dates = json_encode($all_dates, true);
			$all_sent = json_encode($all_sent, true);
			$all_delivered = json_encode($all_delivered, true);
			$all_failed = json_encode($all_failed, true);
			$all_pending = json_encode($all_pending, true);

			$report_date = $report_date;
			$data['first_day'] = $first_day;
			$data['all_dates'] = $all_dates;
			$data['all_sent'] = $all_sent;
			$data['all_delivered'] = $all_delivered;
			$data['all_failed'] = $all_failed;
			$data['all_pending'] = $all_pending;
			$data['report_date'] = $report_date;
			$data['country_name'] = $country_name;
			$data['dept_name'] = $dept_name;
			$data['month_name'] = $month_name;
			$data['year_name'] = $year_name;
			$data['country_id'] = $country;
			$data['dept_id'] = $department;

			return view('reports.monthly_summary_report')->with($data);
		}
	}
	public function summary_report_test()
	{

		$start_date = Carbon::now()->startOfYear();

		$end_date = Carbon::now()->endOfDay();

		try {
			$period = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);
			foreach ($period as $key => $value) {
				$job = new UpdateSummaryReportJob($value);
				dispatch($job);
			}
		} catch (\Exception $e) {
			dd($e);
			$labels = [];
		}


		$year = Carbon::now()->year;
		$month = Carbon::now()->month;
		// $date = '2019-07-13';
		$today = Carbon::now()->toDateString();
		$today = '2019-07-01';
		$start_date = Carbon::now()->startOfMonth()->toDateString();
		$report_data = DB::table('quees')
			->select(
				DB::raw('quees.created_at as que_date'),
				DB::raw('quees.status'),
				DB::raw('texts.recepient_country_id as country_id'),
				DB::raw('texts.user_department_id as sender_dept_id'),
				DB::raw('COUNT(quees.text_id) AS all_texts'),
				DB::raw('COUNT(CASE WHEN quees.status = 2 THEN 1 END) AS sent_texts'),
				DB::raw('COUNT(CASE WHEN quees.status = 1 THEN 1 END) AS queed_texts'),
				DB::raw('COUNT(CASE WHEN quees.status = 2 THEN 1 END) AS delivered_texts'),
				DB::raw('COUNT(CASE WHEN quees.status = 3 THEN 1 END) AS failed_texts')
			)
			->Join('texts', 'quees.text_id', '=', 'texts.text_id')
			->Join('users', 'texts.created_by', '=', 'users.id')
			->Join('recipients_country', 'texts.recepient_country_id', '=', 'recipients_country.recipients_country_id')
			->whereRaw("CAST(texts.created_at as DATE) = '" . $today . "'")
			->groupBy('texts.recepient_country_id')
			->groupBy('texts.user_department_id')
			->get();

		foreach ($report_data as $key => $value) {

			$daily_report = DB::table('summary_report')
				->select(
					DB::raw('date'),
					DB::raw('country_id'),
					DB::raw('dept_id'),
					DB::raw('sum(sent) as sent'),
					DB::raw('sum(delivered) as delivered'),
					DB::raw('sum(failed) as failed'),
					DB::raw('sum(pending) as pending')
				)
				->whereBetween('date', array($start_date, $today))
				->groupBy('country_id', 'dept_id')
				->get();

			DB::table('summary_report')->upsert(
				[
					'date' => $today, 'country_id' => $value->country_id, 'dept_id' => $value->sender_dept_id, 'sent' => $value->sent_texts,
					'delivered' => $value->delivered_texts, 'failed' => $value->failed_texts, 'pending' => $value->queed_texts
				],
				['date', 'country_id', 'dept_id'],
				['sent', 'delivered', 'failed', 'pending', 'updated_at']
			);
		}

		$monthly_report = DB::table('summary_report')
			->select(
				DB::raw('sum(sent) as sent'),
				DB::raw('sum(delivered) as delivered'),
				DB::raw('sum(failed) as failed'),
				DB::raw('sum(pending) as pending'),
				DB::raw('country_id'),
				DB::raw('dept_id')
			)
			->whereBetween('date', array($start_date, $today))
			->groupBy('country_id', 'dept_id')
			->get();

		foreach ($monthly_report as $key => $monthly) {

			// $monthly_summary_array = array(
			// 	'date' => $today, 'year' => $year, 'month' => $month, 'country_id' => $monthly->country_id, 'dept_id' => $monthly->dept_id, 'sent' => $monthly->sent,
			// 	'delivered' => $monthly->delivered, 'failed' => $monthly->failed, 'pending' => $monthly->pending
			// );
			// $save_monthly_summary_report = DB::table('monthly_summary_report')->insertGetId($monthly_summary_array);

			DB::table('monthly_summary_report')->upsert(
				[
					'date' => $today, 'year' => $year, 'month' => $month, 'country_id' => $monthly->country_id, 'dept_id' => $monthly->dept_id, 'sent' => $monthly->sent,
					'delivered' => $monthly->delivered, 'failed' => $monthly->failed, 'pending' => $monthly->pending
				],
				['date', 'country_id', 'dept_id'],
				['sent', 'delivered', 'failed', 'pending', 'updated_at']
			);
		}
	}
	public function generate_summary_reports(Request $request)
	{

		$country = $request->get('country');
		$department = $request->get('department');
		$report_date = $request->get('report_date');

		$country_data = DB::table('recipients_country')->where('recipients_country_id', '=', $country)->first();
		$data['country_name'] = $country_data->country_name;
		$dept_data = DB::table('departments')->where('department_id', '=', $department)->first();
		$data['dept_name'] = $dept_data->dept_name;

		$date = Carbon::parse($report_date);
		$month_name = $date->format('F');
		$year_name = $date->year;

		$first_day = new Carbon('first day of' . $month_name . $year_name);
		$first_day = $first_day->toDateString();

		$report_date = $report_date;

		$begin = new DateTime($first_day);
		$end   = new DateTime($report_date);

		$dates = array();
		for ($i = $begin; $i <= $end; $i->modify('+1 day')) {

			$dates[] = $i->format("Y-m-d");
		}

		$monthly_texts = DB::table('summary_report')
			->select(
				DB::raw('summary_report.*')
			)
			->where('country_id', $country)
			->where('dept_id', $department)
			->whereBetween('date', array($first_day, $report_date))
			->get();

		if ($monthly_texts) {
			$data_array[] = array('DATE', 'COUNTRY', 'DEPARTMENT', 'SENT SMS', 'DELIVERED SMS', 'FAILED SMS');

			foreach ($monthly_texts as $value) {

				if ($value->sent == 0) {
					$sent = '0';
				} else {
					$sent = $value->sent;
				}

				if ($value->delivered == 0) {
					$delivered = '0';
				} else {
					$delivered = $value->delivered;
				}

				if ($value->failed == 0) {
					$failed = '0';
				} else {
					$failed = $value->failed;
				}

				if ($value->pending == 0) {
					$pending = '0';
				} else {
					$pending = $value->pending;
				}

				$data_array[] = array(
					$value->date,
					$value->country_id,
					$value->dept_id,
					$sent,
					$delivered,
					$failed,
					$pending
				);
			}

			$text_title_disp = "Monthly_SMS_Summary_Report_" . $first_day . " to " . $report_date;

			$GLOBALS['data_array'] = $data_array;
			\Excel::create(str_replace(' ', '_', $text_title_disp), function ($excel) {
				$excel->sheet('Sheetname', function ($sheet) {
					$sheet->fromArray($GLOBALS['data_array']);
				});
			})->export('csv');
		}
	}
}