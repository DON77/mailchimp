@extends('layouts.app')


@section('content')

    <h2 class="text-center">Create new List</h2>

    <div class="container">


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="row">

            <div class="col-md-6">

                <div class="well">

                    @include('mailchimp/form')

                </div>

            </div>

    </div>

@endsection