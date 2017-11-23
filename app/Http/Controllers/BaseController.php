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
     * @param Request $request
     */
    public function sort(Request $request) {}

    /**
     * @param array|Collection $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}