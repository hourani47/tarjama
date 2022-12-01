<?php
namespace App\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class MailHelper
{
     function sendToMerchant($email ,$ingredients)
    {
        try {
            $counter = 0;
            foreach ($ingredients as $ingredient){
                if($counter > 0){
                    $data  =$data . ', ' .$ingredient ;
                }else{
                    $data = $ingredient;
                }
                $counter++;
            }
            Mail::to($email)->send(new \App\Mail\Merchant ($email , $data));
        }catch ( \Exception $e){
            echo response($e->getMessage(), 422); die() ;
        }
        return 1;

    }
}
