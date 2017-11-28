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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class BaseController extends Controller
{
    /**
     * Base controller using Helper trait to offer multiple methods.
     */
    use Helper;

    /**
     * Sort method to allow Controllers to sort their data.
     * @param Request $request
     */
    public function sort(Request $request) {}
}