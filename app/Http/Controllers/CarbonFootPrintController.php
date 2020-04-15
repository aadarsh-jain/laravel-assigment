<?php

namespace App\Http\Controllers;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ixudra\Curl\Facades\Curl;
use App\CarbonFootPrintRecord;

class CarbonFootPrintController extends Controller
{
    public function index(Request $request){

        //check result in cookie
        $req_para                   = array();
        $req_para['activity']       = $request->activity;
        $req_para['activityType']   = $request->activityType;
        $req_para['country']        = $request->country;
        $req_para['fuelType']       = $request->fuelType;
        $req_para['mode']           = $request->mode;

        $cookie_key = 'carbon_foot_print';
        $res        = '';
        foreach($req_para as $k => $v){
            $cookie_key .= '-'.strtolower($k).'_'.$v;
        }

        // get cookie using cookie_key and assgined in $res
        $res = $request->cookie($cookie_key);
        
        if(empty($res)){
            // fetching data from API by passing parameters
            $res = $this->getCarbonFootPrint($req_para);
            
            // set result in cookie here
            $minutes = 1440; // minutes in one day
            $response = new Response('Set Cookie');
            $response->withCookie(cookie($cookie_key, $res, $minutes));
            
            $req_para['carbonFootprint'] = $res;

            // saving data to database
            $this->saveResult($req_para);
        }
        echo "Carbon Foot print : ".$res;
    }

    function getCarbonFootPrint($url_para = array()){
        $url = 'https://api.triptocarbon.xyz/v1/footprint';

        if(!empty($url_para)){
            $url .= '?';
            foreach($url_para as $k => $v){
                $url .= "$k=$v&";
            }
            $url = rtrim($url,'&');
        }

        $response = Curl::to($url)->get();
        return json_decode($response)->carbonFootprint;
    }

    function saveResult($record_para = array()){
        $record = new CarbonFootPrintRecord();
        foreach($record_para as $k => $v){
            $record->$k = $v;
        }
        return $record->save();
    }
}
