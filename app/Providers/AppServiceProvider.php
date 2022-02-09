<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('multi_date_format', function ($attribute, $value, $parameters,$validator) {

            $ok = true;
        
            $result = [];
        
              // iterate through all formats
              foreach ($parameters as $parameter){
        
                 //validate with laravels standard date format validation
                 $result[] = $validator->validateDateFormat($attribute,$value,[$parameter]);
              }
        
            //if none of result array is true. it sets ok to false
            if(!in_array(true,$result)){
                $ok = false;
                $validator->setCustomMessages(['multi_date_format' => 'The format must be one of Y-m-d ,Y-m or Y-m-']);
            }
        
            return $ok;
        });
    }
}
