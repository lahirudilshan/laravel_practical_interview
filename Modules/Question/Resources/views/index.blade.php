@extends('layouts.master')

@section('content')
<div class="h-100">
    <div class="row h-100 d-flex align-items-center justify-content-center">
        <div class="col-4">
            <div class="bg-white p-4">
                <form action="{{ route('user.answer') }}" method="POST">
                    @csrf
                    <ol>
                        @foreach ($questions as $question)
                            <li class="mt-3">{{ $question->name }}</li>
                            @if($question->answers)
                            <ul>
                                @foreach($question->answers as $answer)
                                    <li>
                                        <label class="radio-inline">
                                            <input type="radio" name="answer[{{ $question->id }}]" class="mr-2" value="{{ $answer->id }}"> {{ $answer->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        @endforeach
                    </ol>
                    <button type="submit" id="submit_button" class="btn btn-primary btn-block mt-4">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Submit 
                    </button>
                    @error('answer')
                        <div class="alert alert-danger mt-4" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
