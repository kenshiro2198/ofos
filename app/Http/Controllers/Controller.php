<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function applyPagination($builder, $request, $sortMap = [])
    {
        $perPage = $request->itemsPerPage;

        if (!empty($request->sortBy)) {
            for ($i = 0; $i < count($request->sortBy); $i++) {
                $sortBy = $request->sortBy[$i];
                if (array_key_exists($sortBy, $sortMap)) {
                    $sortBy = $sortMap[$sortBy];
                }
                $builder->orderByRaw("$sortBy {$request->sortDesc[$i]}");
            }
        }

        if ($perPage == -1 || empty($perPage)) {
            return $builder->get();
        }
        return $builder->paginate($perPage);
    }

    public function applySearch($builder, $request, $columns, $filterMap = [])
    {
        if ($request->withTrashed) {
            $builder = $builder->withTrashed();
        }
        if ($request->filter) {
            // return $request->filter;
            $filter = (array) json_decode($request->filter);
            foreach (array_keys($filter) as $key) {
                if (empty($filter[$key])) {
                    continue;
                }

                if (is_array($filter[$key])) {
                    if (strpos($key, 'date_') !== false) {
                        $dateKey = explode("date_", $key)[1];
                        if (array_key_exists(explode("date_", $key)[1], $filterMap)) {
                            $dateKey = $filterMap[explode("date_", $key)[1]];
                        }
                        if (count($filter[$key]) > 1) {
                            $builder = $builder->whereDate($dateKey, '>=', $filter[$key][0])->whereDate($dateKey, '<=', $filter[$key][1]);
                        } else {
                            $builder = $builder->whereDate($dateKey, '=', $filter[$key][0]);
                        }
                    } else {
                        if (array_key_exists($key, $filterMap)) {
                            $builder = $builder->whereIn("$filterMap[$key]", $filter[$key]);
                        } else {
                            $builder = $builder->whereIn($key, $filter[$key]);
                        }
                    }
                } else {
                    if (array_key_exists($key, $filterMap)) {
                        $builder = $builder->where("$filterMap[$key]", $filter[$key]);
                    } else {
                        $builder = $builder->where($key, $filter[$key]);
                    }
                }
            }
        }
        if (empty($request->search)) {
            return;
        }

        // $search = json_decode($request->search);
        $search = $request->search;
        if ($columns) {
            // $columns = $search->columns;

            $columns = array_reverse($columns);
            // if (!$search || empty($columns)) {
            //     return;
            // }
            $builder->where(function ($q) use ($columns, $search) {
                foreach ($columns as $col) {
                    $q->orWhere($col, 'like', "%" . $search . "%");
                }
            });
        }
    }
}
