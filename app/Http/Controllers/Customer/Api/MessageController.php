<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Message;
use App\Models\Customer;
use App\Models\Property;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Notifications\MessageNotification;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $ids = $request->user()->conversations()->pluck('property_id', 'id');
        $get_messages = Message::with(['messageable:id,owner_id,name,slug', 'conversation', 'messageable.imgs'])
            ->whereIn('conversation_id', $ids->keys())
            ->where('messageable_type', Property::class)
            ->whereIn('messageable_id', $ids)
            ->latest()
            ->paginate($request->page_size ?? 10);
        
        return MessageResource::collection($get_messages);
    }

    public function show(Request $request, Property $property, Customer $customer)
    {
        $this->authorize('messageOwner', [$property, $customer]);

        $conversation = Conversation::firstOrCreate(['property_id' => $property->id, 'customer_id' => $customer->id])
            ->load(['messages', 'messages.messageable' => fn (MorphTo $v) => $v->morphWith([
                Property::class => ['imgs'],
            ])]);

        $request->user()->unreadNotifications->where('type', MessageNotification::class)->where('data.property_id', $property->id)->markAsRead();

        return new ConversationResource($conversation);
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

        $message = $request->user()->messages()->create($validated + ['conversation_id' => $conversation->id]);

        $conversation->property->owner->notify(new MessageNotification($conversation->customer,  $message->body, $conversation->property_id, $conversation->property->name));

        return response()->json(['message' => 'تم إرسال الرسالة بنجاح'], 200);
    }
}
