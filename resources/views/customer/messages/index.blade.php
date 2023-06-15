@extends('layouts.customer.index')

@push('styles')

@endpush

@section('content')

<div class="container my-5">
  <h5 class="fw-bold mb-3"> الرسائل </h5>
  <div class="row">

    <div class="col-12">
      <div class="bg-light">
        @if ($messages->isNotEmpty())
          @foreach ($messages as $message)
          <a href="{{ route('messages.show', [$message->messageable_id, auth_customer()->id]) }}" class="w-100" style="color: rgb(34, 34, 34)">
            <div class="message-item border-bottom d-flex p-3">
              <img src="{{ $message->messageable->avatar }}" style="height: 50px; width: 50px; border-radius: 50%;">
              <div class="me-3">
                <h5> {{ $message->messageable->name ?? $message->messageable->full_name }} </h5>
                <div class="d-flex">
                  <div class="text-muted small">
                    {{ $message->created_at->diffForHumans() }}
                  </div>
                </div>
                <p class="mt-3 mb-0 p-0">
                  {{ $message->body }}
                </p>
              </div>
            </div>
          </a>
          @endforeach
        @else
        <div class="alert alert-danger my-4">لا يوجد أي رسائل</div>
        @endif

      </div>
    </div>
    <div class="d-flex flex-row-reverse my-5">{{ $messages->links() }}</div>

  </div>
</div>

@endsection

@push('scripts')

@endpush