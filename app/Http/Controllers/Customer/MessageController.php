<?php

namespace App\Http\Controllers\Customer;

use App\Models\Message;
use App\Models\Customer;
use App\Models\Property;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\MessageNotification;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MessageController extends Controller
{
    public function index()
    {
        $ids = auth_customer()->conversations()->pluck('property_id', 'id');
        $messages = Message::with('messageable', 'messageable.imgs', 'conversation')
            ->whereIn('conversation_id', $ids->keys())
            ->where('messageable_type', Property::class)
            ->whereIn('messageable_id', $ids)
            ->latest()
            ->paginate(10);
            
        return view('customer.messages.index', compact('messages'));
    }

    public function show(Property $property, Customer $customer)
    {
        $this->authorize('messageOwner', [$property, $customer]);

        $conversation = Conversation::firstOrCreate(['property_id' => $property->id, 'customer_id' => $customer->id])
            ->load(['messages', 'messages.messageable' => fn(MorphTo $v) => $v->morphWith([
                Property::class => ['imgs'],
            ])]);


        auth_customer()->unreadNotifications->where('type', MessageNotification::class)->where('data.property_id', $property->id)->markAsRead();

        return view('customer.messages.show.index', compact('conversation'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $this->authorize('messageOwner', $conversation);

        $validated = $request->validate([
            'body' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:8096',
        ]);

        if ($request->hasFile('attachment')) {
            if (fileIsImg($request->file('attachment'))) {
                $validated['attachment'] = img_upload($request->file('attachment'), Message::ATTACHMENTS_STOREAGE);
            } else {
                $validated['attachment'] = $request->file('attachment')->store(Message::ATTACHMENTS_STOREAGE, 'public');
            }
        }

        $message = auth_customer()->messages()->create($validated + ['conversation_id' => $conversation->id]);

        $message_html = view('customer.messages.show.message', compact('message'))->render();

        $conversation->property->owner->notify(new MessageNotification($conversation->customer,  $message->body, $conversation->property_id, $conversation->property->name));

        return response()->json(compact('message_html'));
    }
}
