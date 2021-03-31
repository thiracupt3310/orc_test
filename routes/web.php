<?php

use Alimranahmed\LaraOCR\Facades\OCR;
use Alimranahmed\LaraOCR\Services\OcrAbstract;
use Illuminate\Support\Facades\Route;


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
    // $imagePath = resource_path('1.jpg');
    // echo OCR::scan($imagePath);
    
    return view('lara_ocr.upload_image');
});

Route::post('/', function () {
    $image = request('image');
    if (isset($image) && $image->getPathName()) {
        $ocr = app()->make(OcrAbstract::class);
        $parsedText = $ocr->scan($image->getPathName());
        return view('lara_ocr.parsed_text', compact('parsedText'));
    }
});
