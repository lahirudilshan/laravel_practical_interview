@extends('layouts.master')

@section('content')
<div class="h-100">
    <div class="row h-100 d-flex align-items-center justify-content-center">
        <div class="col-4">
            <div class="p-4 text-center">
                <h1><i class="far fa-smile"></i> Thank You!</h1>
                <a href="{{ route('question.summery') }}" class="mt-2 text-center">Click here to see the summery</a>
            </div>
        </div>
    </div>
</div>
@endsection
