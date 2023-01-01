@extends('gas::layouts.master')

@section('title')
Dashboard | {!! config('gas.name') !!}
@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Gas Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   .
                </div>
            </div>
        </div>
    </div>

@endsection
