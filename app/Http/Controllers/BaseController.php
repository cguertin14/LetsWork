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
     * @param $perPage
     * @param null $total
     * @param null $page
     * @param string $pageName
     * @return LengthAwarePaginator
     */
    public function paginate( $perPage, $total = null, $page = null, $pageName = 'page' )
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage( $pageName );

        return new LengthAwarePaginator( $this->forPage( $page, $perPage ), $total ?: $this->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }
}