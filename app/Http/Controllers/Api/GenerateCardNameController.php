<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class GenerateCardNameController extends Controller
{
    public function generate(Request $request){
        $request->validate([
            'name'=>'required|string|min:2|max:20',
            'id'=>'required|integer|min:1|max:12',
        ]);

        #Image::make
        $img = Image::make(public_path("assets/images/cards/card".$request->id.".jpg"));  

        #text
        $img->text($request->name, ($img->width() / 2), $img->height() - 40, function($font) use($img){  
            $font->file(public_path('assets/fonts/Roboto-Bold.ttf'));  
            $font->size($img->height() * 5 / 100);  
            $font->color('#000000');  
            $font->align('center');  
            $font->valign('bottom');  
            $font->angle(0);
        });  

        #save
        $imagename = uniqid().'.jpg';
        $img->save(public_path('storage/'.$imagename));  

        #url
        return response(['status'=>true,'message'=>__("Successfully generated!"),'imagesrc'=>asset('storage/FeastCard/'.$imagename),'imagename'=>$imagename]);
    }
}
