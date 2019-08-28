<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use DB;
use App\AfricaTalkings;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['countries'] = DB::table('recipients_country')->pluck('country_name', 'recipients_country_id')->all();

        $data['ug_bal'] = AfricaTalkings::getBalance(env('UG_Username', ''), env('UG_APIKEY', ''));
        $data['tz_bal'] = AfricaTalkings::getBalance(env('TZ_Username', ''), env('TZ_APIKEY', ''));
        $data['ml_bal'] = AfricaTalkings::getBalance(env('ML_Username', ''), env('ML_APIKEY', ''));
        $data['za_bal'] = AfricaTalkings::getBalance(env('ZA_Username', ''), env('ZA_APIKEY', ''));

        $url = 'https://smsapiv1bal.onfonmedia.co.ke/';
        $ch = curl_init($url);
        $jsonData = array(array('username' => 'wananchi', 'password' => 'wananchi@2018',),);
        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        // $result = substr($result, 0, strpos($result, "}"));
        $result = json_decode($result, TRUE);


        $data['ke_bal'] = $result['UnitsBalance'];

        return view('home')->with($data);
    }

    public function fetchOnFornBal(Request $request)
    { }
}