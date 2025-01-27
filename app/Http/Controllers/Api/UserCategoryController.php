<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserCategoryController extends Controller
{
    public function store(UserCategoryRequest $request){
        try {

            $categoryIds = $request->category_ids;

            // Assuming the user is authenticated
            $user = auth()->user();

            // Sync favorite categories
            $user->favoritecategories()->sync($categoryIds);

            return response()->json(['message' => 'Favourite categories updated successfully.'], 200);
        } catch (\Exception $exception) {
            Log::error("Error in saving favourite categories: " . $exception->getMessage());
            return response()->json(['message' => 'An error occurred while saving favorite categories.'], 500);
        }

    }
}
