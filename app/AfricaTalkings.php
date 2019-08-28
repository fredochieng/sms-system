<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AfricasTalking\SDK\AfricasTalking;

class AfricaTalkings extends Model
{
    public static function getBalance($username, $apiKey)
    {
        $AT       = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $bal = $AT->application()->fetchApplicationData();

        if ($bal['status'] == 'success') {
            return array('status' => 1, 'balance' => explode(" ", $bal['data']->UserData->balance));
        } else {
            return array('status' => 0, 'balance' => 0);
        }
    }
}