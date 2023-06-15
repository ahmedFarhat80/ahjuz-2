<div class="message-item p-4 border-bottom">
  <div class="d-flex align-items-center">
    <img src="{{ $message->messageable->avatar }}" style="width:50px; height:50px; border-radius:50%">
    <div class="ms-2">
      <h6 class="p-0 m-0 pt-1 mb-1"> {{ $message->messageable->name ?? $message->messageable->full_name }} </h6>
      <i class="text-muted p-0 m-0"> {{ date_hour_ar($message->created_at) }} </i>
    </div>
  </div>
  <p class="p-0 m-0 mt-3">

    {{ $message->body }}

    @if ($message->getRawOriginal('attachment'))
      <div>
        @if ($message->attachmentIsImg())
          <img src="{{ $message->attachment }}" width="100" height="100" alt="">
        @else
          <a href="{{ $message->attachment }}">المرفقات</a>
        @endif
      </div>
    @endif
  </p>
</div>
