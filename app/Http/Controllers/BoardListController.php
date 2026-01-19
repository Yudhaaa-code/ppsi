<?php

namespace App\Http\Controllers;

use App\Models\BoardList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardListController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $maxPosition = BoardList::where('user_id', Auth::id())->max('position') ?? -1;

        $list = BoardList::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'position' => $maxPosition + 1,
        ]);

        return response()->json($list);
    }

    public function destroy(BoardList $list)
    {
        if ($list->user_id !== Auth::id()) {
            abort(403);
        }

        $list->delete();

        return response()->json(['message' => 'List deleted']);
    }
}
