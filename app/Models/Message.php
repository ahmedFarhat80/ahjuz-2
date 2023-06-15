<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    const ATTACHMENTS_STOREAGE = 'media/messages/attachments/';

    protected $guarded = [];

    public function messageable()
    {
        return $this->morphTo();
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function getAttachmentAttribute($value) 
    {
        return $value ? asset('storage/'. $value) : null;
    }

    public function attachmentIsImg() 
    {
        return fileIsImg($this->attachment);
    }

}
