@extends('layouts.master')

@section('content')
<div class="h-100">
    <div class="row h-100 d-flex align-items-center justify-content-center">
        <div class="col-4">
            <form action="{{ route('user.feedback') }}" method="POST">
                @csrf
                <div class="form-group">
                    <h4 class="text-center mb-4">ZinCat Feedback System</h4>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email address.">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" id="submit_button" class="btn btn-primary btn-block">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Submit 
                </button>
                
                @if(session()->has('error'))
                    <div class="alert alert-danger mt-4" role="alert">
                        <i class="far fa-2x fa-times-circle"></i> {{ session()->get('error.message') }}
                    </div>
                @elseif(session()->has('success'))
                    <div class="alert alert-success mt-4" role="alert">
                        <i class="fas fa-2x fa-check"></i> {{ session()->get('success.message') }}
                    </div>
                @elseif(session()->has('info'))
                    <div class="alert alert-info mt-4" role="alert">
                        <i class="fas fa-2x fa-info-circle"></i> {{ session()->get('info.message') }}
                    </div>
                @elseif(session()->has('warning'))
                    <div class="alert alert-warning mt-4" role="alert">
                        <i class="fas fa-2x fa-exclamation-triangle"></i> {{ session()->get('warning.message') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
