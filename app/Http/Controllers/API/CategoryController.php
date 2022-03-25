<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends APIBaseController
{
    public function index()
    {
        try {
            $query = Category::with('items')->get();
            return $this->sendResponse($query, 'Success.');
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        } catch (\Error $e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        } catch (\Throwable $e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        }
    }
}
