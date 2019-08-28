<?php 

namespace App\Http\Controllers;

use App\contact;
use App\text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use Hash;
class ProfileController extends Controller
{
	
	
	public function edit(Request $request){
		
		$user_id=Auth::user()->id;
		$user=User::find($user_id)->first();
		
		if(isset($_POST['save'])){
			$this->validate($request,[
				'password' => 'required|confirmed|min:6',
				
			 ]);
			 
			 $new_password = Hash::make($_POST['password']);
			 $user->password=$new_password;			 
			 $user->save();
			 
			return redirect('profile/edit')->with('success','Password Reset Successfully');
	
		}	
		
		return view('profile.edit')->with([
			'email'=>$user->email,
		]);		
		
	}
	
	
	public function first_time_reset(Request $request){
		
		$user_id=Auth::user()->id;
		$user=User::find($user_id)->first();
		
		if(isset($_POST['save'])){
			$this->validate($request,[
				'password' => 'required|confirmed|min:6',
				
			 ]);
			 
			 $new_password = Hash::make($_POST['password']);
			 $user->password=$new_password;
			 $user->first_login_reset=1;			 
			 $user->save();
			 
			return redirect('/')->with('success','Password Reset Success. Enjoy!');
	
		}	
		
		return view('profile.edit')->with([
			'email'=>$user->email,
		]);		
	}
}


?>