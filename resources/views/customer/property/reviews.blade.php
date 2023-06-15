@if ($reviews->isNotEmpty())

    {{-- @foreach (range(1, 5) as $item) --}}
    @foreach ($reviews as $review)
    <div class="rate-item bg-light rounded border p-3 mb-2">
        <div class="d-flex align-items-center">
            <img src="{{ asset($review->customer->avatar) }}" style="width: 48px; height: 48px; border-radius:50%;">
            <div class="mx-2">
                <h5 class="m-0"> {{ $review->customer->full_name }} </h5>
                <div class="rate" data-rate="{{ $review->customer_id }}"></div>
            </div>
        </div>
        <p class="mt-2 mb-0 pb-0 mx-2 pe-5">
            {{ $review->body }}
        </p>
    </div>
    @endforeach

    <div class="reviews_pagination d-flex flex-row-reverse">
        {{ $reviews->appends(request()->except('page'))->links() }}
    </div>

    {{-- @endforeach --}}

@else
    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle ms-2"></i>
        <div>
            نأسف لا يوجد تقييم حاليا
        </div>
    </div>
@endif