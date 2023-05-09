<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('email', 'LIKE', '%' . $query . '%')
            ->orWhere('first_name', 'LIKE', '%' . $query . '%')
            ->orWhere('last_name', 'LIKE', '%' . $query . '%')
            ->paginate(10);

        $usersCollection = UserResource::collection($users);
        $nextPageUrl = $users->nextPageUrl();
        if ($nextPageUrl) {
            $nextPageUrl .= "&q={$query}";
        }
        return response()->json([
            'items' => $usersCollection,
            'metadata' => [
                'current_url' => url('/api/v1') . '?q=' . $query,
                'next_url' => $nextPageUrl,
                'total_pages' => $users->lastPage(),
            ],
        ]);
    }
}