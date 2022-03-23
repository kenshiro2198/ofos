<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use Storage;

// use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Paginate query builder
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */

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

    /**
     * Apply search query using specified columns and search term
     *
     * @return void
     */
    public function applySearch($builder, $request, $columns = null)
    {
        $search = $request->search;
        if (empty($search)) {
            return;
        }

        if ($columns) {

            if (!$search || empty($search) || empty($columns)) {
                return;
            }

            $columns = array_reverse($columns);

            $builder->where(function ($q) use ($columns, $search) {
                foreach ($columns as $col) {
                    foreach (explode(' ', $search) as $token) {
                        $q->orWhereRaw(trim($col) . " like '%$token%'");
                    }
                }
            });
        }
    }

    public static function isBase64($value)
    {
        return preg_match("/data:image\/(gif|jpg|jpeg|tiff|png);base64/", $value);
    }
    public static function uploadImage($content, $path, $name = null)
    {
        $image = Image::make(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $content)));
        // $ext = explode("/", $image->mime)[1];
        $name = $name . '_' . time();
        // $name = empty($name) ? time() . ".$ext" : $name;

        Storage::put("public/$path/$name", $image->stream());

        return "/storage/$path/$name";
    }

    public function download(Request $request)
    {
        return Storage::download($request->path, $request->name);
    }

    public function logActivity($event, $status = null, $data, $feedable_type, $borrower_id, $loan_id)
    {
        $fields = [
            'branch_id' => Auth::user()->active_branch_id,
            'event' => $event,
            'feedable_type' => $feedable_type,
            'data' => $data,
            'full_name' => Auth::user() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : "",
            'user_id' => Auth::user() ? Auth::id() : '',

            'borrower_id' => $borrower_id,
            'loan_id' => $loan_id,

            'event_status' => $status,
        ];

        DB::table('activity_logs')->insert($fields);
    }

    public function getServerDate()
    {
        return Carbon::today()->toDateString();
    }

    public function getServerYear()
    {
        return Carbon::now()->year;
    }

    public function getServerMonth()
    {
        return Carbon::now()->month;
    }
}
