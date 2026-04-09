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
            'img'=>'required|string|starts_with:assets/images/cards/',
        ]);

        $img = Image::make(public_path($request->img));  

         $img->text($request->name, ($img->width() / 2), $img->height() - 40, function($font) use($img){  
            $font->file(public_path('assets/fonts/Roboto-Bold.ttf'));  
            $font->size($img->height() * 5 / 100);  
            $font->color('#000000');  
            $font->align('center');  
            $font->valign('bottom');  
            $font->angle(0);
        });  

        $imagename = time().rand().'.jpg';
        $img->save(public_path('storage/FeastCard/'.$imagename));  

          //  generate model url for it $imagename!
        return response(['status'=>true,'message'=>__("Successfully generated!"),'imagesrc'=>asset('storage/FeastCard/'.$imagename),'imagename'=>$imagename]);
    }
}
