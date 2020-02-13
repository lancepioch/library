@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Libraries</div>

                <div class="card-body">
                @forelse(auth()->user()->libraries as $library)
                    <li><a href="{{ route('library', [$library]) }}">{{ $library->name }}</a></li>
                @empty
                    You don't have any libraries!
                @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
