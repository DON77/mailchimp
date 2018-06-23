@extends('layouts.app')


@section('content')

    <h2 class="text-center">MailChimp Lists</h2>

    <div class="container">

            <div class="row">
                <div class="col-md-3">
                    <a  class="btn btn-primary" href={{route('subscribtion.create', ['id' => $id])}}>Create new Subscribtion</a>
                </div>
            </div>
            <br/><br/>

        @foreach($model as $item)
            <div class="row">

                <div class="col-md-9">
                    {{$item->email}}
                </div>

                <div class="col-md-1">
                    <a href={{route('subscribtion.edit', ['id' => $item->id])}}>Update</a>
                </div>
                <div class="col-md-1">
                    <a href={{route('subscribtion.delete', ['id' => $item->id])}}>Delete</a>
                </div>

            </div>
        @endforeach

    </div>

@endsection