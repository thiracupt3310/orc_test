<?php

namespace App\Http\Controllers;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Http\Request;

class IdCardControllerr extends Controller
{
    //
    function index(){
        return view('idcard');
    }

    function chooseIdImage(Request $request){
        $array = [];
        $person = [];
        $result = [];
    
        // for ($i = 1; $i <= 6; $i++) {
        $mystring = (new TesseractOCR($request->image))->run();
        $valid1 = false;
        $valid2 = false;
        $valid3 = false;
    
        if (preg_match("/Name Mr. ([a-zA-Z]+)(\n+)Lastname (.*)(\n+)/", $mystring, $array)) {
            $person["name"] = $array[1];
            $person["lastname"] = $array[3];
            $valid1 = true;
            // dd($name);
        }
    
        if (preg_match("/([0-9] [0-9]+ [0-9]+ [0-9]+ [0-9])\n+/", $mystring, $array)) {
            $idNumber = str_replace(' ', '', $array[1]);
            $sum = 0;
            for ($i = 0; $i < strlen($idNumber) - 1; $i++) {
                $sum += intval($idNumber[$i]) * (strlen($idNumber) - $i);
            }
            $mod = $sum % 11;
            $sum = 11 - $mod;
            if ($idNumber[12] === strval($sum)) {
                // dd("yes");
                $person["id"] = $idNumber;
                $valid2 = true;
            }
        }
    
        if (preg_match("/Date of Birth ([0-9]+ [a-zA-Z]+. [0-9]+)\n+/", $mystring, $array)) {
            $person["birthday"] = $array[1];
            $valid3 = true;
        }
        // echo json_encode($person) . "<br>";
        $result[] = $person;
        // }
        return response()->json($result, 200)->withHeaders([
            'status' => 'yes',
        ]);;
    }
}
