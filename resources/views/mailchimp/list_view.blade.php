@extends('layouts.app')


@section('content')

    <h2 class="text-center">{{$list['name']}}</h2>

    <div class="container">

        @foreach($list as $label => $value)
            @if($label == 'name')
                @continue
            @endif
            <div class="row">

                <div class="col-md-4">
                    <b>{{$label}}:</b>
                </div>

                <div class="col-md-8">
                    {{$value}}
                </div>

            </div>
        @endforeach

    </div>

@endsection