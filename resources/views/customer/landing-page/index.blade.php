@extends('layouts.customer.index')
@push('styles')
<style>
    .fet-icon {
        width: 74px;
        height: 74px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        font-size: 22px;
        border: 2px solid #FBA711;
        color: #FBA711;
        margin-left: auto;
        justify-content: center;
        margin-right: auto;
        background: #F3EDE4;
    }
</style>
@endpush
@section('content')
    @include('customer.landing-page.hero')
    @include('customer.landing-page.ads')
    @include('customer.landing-page.cities')
    @include('customer.landing-page.properties')
    @include('customer.landing-page.features')
    @include('customer.landing-page.download')
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $("#citybtn").click(function() {
            $(".select-city").show();
        });
        $(".select-city .btn").click(function() {
            $(".select-city").hide();
        });
        $("#typebtn").click(function() {
            $(".select-type").show();
        });
        $(".select-type .btn").click(function() {
            $(".select-type").hide();
        });
    </script>
@endpush