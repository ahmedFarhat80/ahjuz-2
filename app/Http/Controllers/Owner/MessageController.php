<?php

namespace App\Http\Controllers\Owner;

use App\Models\Message;
use App\Models\Customer;
use App\Models\Property;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Http\Controllers\Controller;
use App\Notifications\MessageNotification;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MessageController extends Controller
{
    public function index()
    {
        $properties = auth_owner()->properties()->pluck('id');
        $ids = Conversation::whereIn('property_id', $properties)->pluck('customer_id', 'id');
        $messages = Message::with('messageable', 'conversation')->whereIn('conversation_id', $ids->keys())->where('messageable_type', Customer::class)->whereIn('messageable_id', $ids)->latest()->paginate(10);
        return view('owner.messages.index', compact('messages'));
    }

    public function show(Property $property, Customer $customer)
    {
        $this->authorize('messageCustomer', [$property, $customer]);

        $conversation = Conversation::firstOrCreate(['property_id' => $property->id, 'customer_id' => $customer->id])
            ->load(['messages', 'messages.messageable' => fn(MorphTo $v) => $v->morphWith([
                Property::class => ['imgs'],
            ])]);

        auth_owner()->unreadNotifications->where('type', MessageNotification::class)->where('data.property_id', $property->id)->markAsRead();

        return view('owner.messages.show.index', compact('conversation'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $this->authorize('messageCustomer', $conversation);

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

        $message = $conversation->property->messages()->create($validated + ['conversation_id' => $conversation->id]);

        $message_html = view('owner.messages.show.message', compact('message'))->render();

        $conversation->customer->notify(new MessageNotification($conversation->property, $message->body, $conversation->property_id));

        if ($token = $conversation->customer->fcm_token) {
            FirebaseService::sendMessageNotification($token, 'يوجد لديك رسالة جديدة', $conversation->property, $conversation->customer, $message->body);
        }

        return response()->json(compact('message_html'));
    }
}
