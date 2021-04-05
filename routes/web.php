<?php

use Alimranahmed\LaraOCR\Facades\OCR;
use Alimranahmed\LaraOCR\Services\OcrAbstract;
use App\Http\Controllers\IdCardControllerr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    // for ($i = 1; $i <= 6; $i++) {
    // $mystring = (new TesseractOCR('./Pmew/card1.jpg'))->lang("tha")->run();
    // $mystring1 = (new TesseractOCR('./Pmew/card2.jpg'))->lang("tha")->run();
    // $mystring2 = (new TesseractOCR('./Pmew/card3.jpg'))->lang("tha")->run();
    // $mystring3 = (new TesseractOCR('./Pmew/card4.jpg'))->lang("tha")->run();
    // $mystring4 = (new TesseractOCR('./Pmew/card5.jpg'))->lang("tha")->run();
    // $mystring5 = (new TesseractOCR('./Pmew/card6.jpg'))->lang("tha")->run();
    // $mystring6 = (new TesseractOCR('./Pmew/card7.jpg'))->lang("tha")->run();

    
    // dd($mystring, $mystring1, $mystring2, $mystring3, $mystring4, $mystring5, $mystring6);



    // $ocr = app()->make(OcrAbstract::class);
    // // $parsedText = $ocr->scan(->getPathName());
    // // $imagePath = resource_path('1.jpg');
    // // echo OCR::scan($imagePath);
    // echo "card5=======" . (new TesseractOCR('./id/cardScan.png'))
    //     ->run() . "<br><br>";

    // return view('lara_ocr.upload_image');
});

Route::post('/', function () {
    $image = request('image');
    // echo $image;
    if (isset($image) && $image->getPathName()) {
        $ocr = app()->make(OcrAbstract::class);
        $parsedText = $ocr->scan($image->getPathName());
        // return view('lara_ocr.parsed_text', compact('parsedText'));


        // echo "card5=======" . $parsedText . "<br><br>";
    }
});

Route::get('/idcard',[IdCardControllerr::class,'index']);

Route::post('/parse2Text', function (Request $request) {

    $array = [];
    $person = [];
    $result = [];

    // for ($i = 1; $i <= 6; $i++) {
    $mystring = (new TesseractOCR($request->image))->executable("/usr/bin/tesseract")->run();
    $valid1 = false;
    $valid2 = false;
    $valid3 = false;

    if (preg_match("/Name [Miss]*[Mr.]* ([a-zA-Z]+)(\n+)Lastname (.*)(\n+)/", $mystring, $array)) {
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
    $path = $request->file("image")->storeAs("public/base64", "imageCard.jpg");

    // $request->file('image')->storeAs();
    // $base64 = base64_encode(file_get_contents($request->file('image')));

    // $myImage = fopen("base64/base64.txt", "w");
    // fwrite($myImage, $base64);
    // fclose($myImage);

    $output = shell_exec('python3 ./FaceDetect-master/face_detect.py');

    // unlink("base64/base64.txt");
    
    $image = "data:image/png;base64, " . substr($output, 2, strlen($output) - 4);

    $person["image"] = $image;
    
    return response()->json($person, 200);

    // return response()->json(["data"=>$request->image], 200);    
});