<?php

namespace App\Http\Controllers;

use App\Models\BoardCard;
use App\Models\BoardList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BoardCardController extends Controller
{
    public function index()
    {
        $cards = BoardCard::where('user_id', Auth::id())
            ->orderBy('created_at')
            ->get();

        return response()->json($cards);
    }

    public function store(Request $request)
    {
        try {
            \Illuminate\Support\Facades\Log::info('Store Card Request:', $request->all());

            $data = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'list_key' => ['nullable', 'string'],
                'board_list_id' => ['nullable', 'exists:board_lists,id'],
                'due_date' => ['nullable', 'date'],
                'start_date' => ['nullable', 'date'],
                'completed' => ['nullable', 'boolean'],
                'labels' => ['nullable', 'array'],
                'labels.*' => ['string'],
                'checklist' => ['nullable', 'array'],
                'checklist.*.text' => ['required_with:checklist', 'string'],
                'checklist.*.done' => ['required_with:checklist', 'boolean'],
                'attachments' => ['nullable', 'array'],
                'attachments.*.name' => ['required_with:attachments', 'string'],
                'attachments.*.url' => ['required_with:attachments', 'string'],
                'activities' => ['nullable', 'array'],
                'activities.*.text' => ['required_with:activities', 'string'],
                'activities.*.type' => ['required_with:activities', 'string'],
                'members' => ['nullable', 'array'],
                'members.*.id' => ['required_with:members', 'integer'],
                'members.*.name' => ['required_with:members', 'string'],
                'members.*.initials' => ['required_with:members', 'string'],
            ]);

            $boardListId = $data['board_list_id'] ?? null;
            if (!$boardListId && !empty($data['list_key'])) {
                $listTitle = ucfirst($data['list_key']);
                $list = BoardList::where('user_id', Auth::id())
                    ->where('title', $listTitle)
                    ->first();
                if ($list) {
                    $boardListId = $list->id;
                }
            }

            $payload = [
                'user_id' => Auth::id(),
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'list_key' => $boardListId ? null : ($data['list_key'] ?? 'today'),
                'board_list_id' => $boardListId,
                'due_date' => $data['due_date'] ?? null,
                'labels' => $data['labels'] ?? [],
                'checklist' => $data['checklist'] ?? [],
            ];
            if (Schema::hasColumn('board_cards', 'completed')) {
                $payload['completed'] = $data['completed'] ?? false;
            }
            if (Schema::hasColumn('board_cards', 'attachments')) {
                $payload['attachments'] = $data['attachments'] ?? [];
            }
            if (Schema::hasColumn('board_cards', 'activities')) {
                $payload['activities'] = $data['activities'] ?? [];
            }
            if (Schema::hasColumn('board_cards', 'members')) {
                $payload['members'] = $data['members'] ?? [];
            }

            $card = BoardCard::create($payload);
            
            \Illuminate\Support\Facades\Log::info('Card Created:', $card->toArray());

            return response()->json($card, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('Validation Error:', $e->errors());
            throw $e;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Store Card Error: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
            return response()->json(['message' => 'Internal Server Error: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, BoardCard $card)
    {
        $this->authorizeCard($card);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'list_key' => ['nullable', 'string'],
            'board_list_id' => ['nullable', 'exists:board_lists,id'],
            'due_date' => ['nullable', 'date'],
            'start_date' => ['nullable', 'date'],
            'completed' => ['nullable', 'boolean'],
            'labels' => ['nullable', 'array'],
            'labels.*' => ['string'],
            'checklist' => ['nullable', 'array'],
            'checklist.*.text' => ['required_with:checklist', 'string'],
            'checklist.*.done' => ['required_with:checklist', 'boolean'],
            'attachments' => ['nullable', 'array'],
            'attachments.*.name' => ['required_with:attachments', 'string'],
            'attachments.*.url' => ['required_with:attachments', 'string'],
            'activities' => ['nullable', 'array'],
            'activities.*.text' => ['required_with:activities', 'string'],
            'activities.*.type' => ['required_with:activities', 'string'],
            'members' => ['nullable', 'array'],
            'members.*.id' => ['required_with:members', 'integer'],
            'members.*.name' => ['required_with:members', 'string'],
            'members.*.initials' => ['required_with:members', 'string'],
        ]);

        $boardListId = $data['board_list_id'] ?? $card->board_list_id;
        if (isset($data['board_list_id'])) {
             // Use provided
        } elseif (isset($data['list_key']) && $data['list_key'] !== $card->list_key) {
             // Try to resolve
             $listTitle = ucfirst($data['list_key']);
             $list = BoardList::where('user_id', Auth::id())
                 ->where('title', $listTitle)
                 ->first();
             if ($list) {
                 $boardListId = $list->id;
             }
        }

        $updates = [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'list_key' => $data['list_key'] ?? $card->list_key,
            'board_list_id' => $boardListId,
            'due_date' => $data['due_date'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'labels' => $data['labels'] ?? [],
            'checklist' => $data['checklist'] ?? [],
        ];
        if (Schema::hasColumn('board_cards', 'completed')) {
            $updates['completed'] = $data['completed'] ?? $card->completed;
        }
        if (Schema::hasColumn('board_cards', 'attachments')) {
            $updates['attachments'] = $data['attachments'] ?? [];
        }
        if (Schema::hasColumn('board_cards', 'members')) {
            $updates['members'] = $data['members'] ?? [];
        }
        if (Schema::hasColumn('board_cards', 'activities')) {
            $updates['activities'] = $data['activities'] ?? [];
        }

        $card->update($updates);

        return response()->json($card);
    }

    public function updateStatus(Request $request, BoardCard $card)
    {
        $this->authorizeCard($card);
        
        $data = $request->validate([
            'completed' => ['required', 'boolean'],
        ]);

        // Try to update if column exists, otherwise ignore to avoid UI error
        if (Schema::hasColumn('board_cards', 'completed')) {
            $card->update(['completed' => $data['completed']]);
        }

        return response()->json($card);
    }

    public function destroy(BoardCard $card)
    {
        $this->authorizeCard($card);
        $card->delete();
        return response()->json(['message' => 'Card deleted']);
    }

    private function authorizeCard(BoardCard $card): void
    {
        abort_if($card->user_id !== Auth::id(), 403);
    }
}
