{!! Form::open(array('route' => isset($route) ? $route : 'subscribtion.store')) !!}

<div>

    <h3 class="text-center">Add Subscriber</h3>

    <input class="form-control" name="email" id="email" type="text" placeholder="Email"
           value="@if(isset($subscriber['email'])){{$subscriber['email']}}@endif"
           required>

    <br/>
    <input  name="list_id" type="hidden"
           value="@if(isset($subscriber['list_id'])){{$subscriber['list_id']}}@endif"
           required>

    <div class="text-center">

        <button class="btn btn-info btn-lg" type="submit">Create</button>

    </div>

</div>

{!! Form::close() !!}