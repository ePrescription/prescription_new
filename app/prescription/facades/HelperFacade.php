<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 20/04/2018
 * Time: 8:04 PM
 */

namespace App\prescription\facades;


use Illuminate\Support\Facades\Facade;

class HelperFacade extends Facade
{
    protected static function getFacadeAccessor() {
        //dd('Inside facade');
        return 'HelperService';
    }
}