<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAuthorController extends Controller
{

    public function store(UserAuthorRequest $request)
    {
        try {

            $authorIds = $request->author_ids;

            // get user
            $user = auth()->user();

            // Sync favorite authors
            $user->favoriteAuthors()->sync($authorIds);

            return response()->json(['message' => 'Favourite authors updated successfully.'], 200);
        } catch (\Exception $exception) {
            Log::error("Error in saving favourite authors: " . $exception->getMessage());
            return response()->json(['message' => 'An error occurred while saving favorite authors.'], 500);
        }

    }
}
