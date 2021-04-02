<?php

use Alimranahmed\LaraOCR\Facades\OCR;
use Alimranahmed\LaraOCR\Services\OcrAbstract;
use App\Http\Controllers\IdCardControllerr;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
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