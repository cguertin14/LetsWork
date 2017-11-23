<?php
/**
 * Created by PhpStorm.
 * User: guertz
 * Date: 20/11/17
 * Time: 10:45 PM
 */

namespace App\Http\Controllers;


use App\Tools\Helper;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Base controller using Helper trait to offer multiple methods.
     */
    use Helper;

    /**
     * @param Request $request
     */
    public function sort(Request $request) {}
}