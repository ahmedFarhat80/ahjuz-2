<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ConversationsDataTable;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ConversationController extends Controller
{
    public function index(ConversationsDataTable $dataTable)
    {
        return $dataTable->render('admin.conversations.table.index');
    }

    public function show(Conversation $conversation)
    {
        $conversation->load(['messages', 'messages.messageable' => fn(MorphTo $v) => $v->morphWith([
            Property::class => ['imgs'],
        ])]);
        
        return view('admin.conversations.details.index', compact('conversation'));
    }
}
