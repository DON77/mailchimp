@extends('layouts.app')


@section('content')

    <h2 class="text-center">MailChimp Lists</h2>

    <div class="container">


        @if ($message = Session::get('success'))

            <div class="alert alert-success alert-block">

                <button type="button" class="close" data-dismiss="alert">×</button>

                <strong>{{ $message }}</strong>

            </div>

        @endif


        @if ($message = Session::get('error'))

            <div class="alert alert-danger alert-block">

                <button type="button" class="close" data-dismiss="alert">×</button>

                <strong>{{ $message }}</strong>

            </div>

        @endif

            <div class="row">
                <div class="col-md-3">
                    <a  class="btn btn-primary" href={{route('list.create')}}>Create new List</a>
                </div>
            </div>
            <br/><br/>

        @foreach($model as $item)
            <div class="row">

                <div class="col-md-9">
                    <a href={{route('list.view', ['id' => $item->id])}}>{{$item->name}}</a>
                </div>

                <div class="col-md-1">
                    <a href={{route('list.update', ['id' => $item->id])}}>Update</a>
                </div>
                <div class="col-md-1">
                    <a href={{route('list.delete', ['id' => $item->id])}}>Delete</a>
                </div>
                <div class="col-md-1">
                    <a href={{route('subscribers', ['id' => $item->mailchimp_list_id])}}>Subscribers</a>
                </div>

            </div>
        @endforeach

    </div>

@endsection