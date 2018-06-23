@if(!isset($list))
    @php
    $list = []
    @endphp
@endif
{!! Form::open(array('route' => 'list.store')) !!}

<div>

    <h3 class="text-center">Create Your List</h3>

    <input class="form-control" name="name" id="name" type="text" placeholder="List Name"
           value="@if(isset($list['name'])){{$list['name']}}@endif"
           required>

    <br/>
    <h3>Your Contacts</h3>
    <input class="form-control" name="contact[company]" id="company" type="text" placeholder="Company"
           value="@if(isset($list['company '])){{$list['company']}}@endif"
           required>

    <br/>
    <input class="form-control" name="contact[address1]" id="address1" type="text" placeholder="Address 1"
           value="@if(isset($list['address1'])){{$list['address1']}}@endif"
           required>

    <br/>
    <input class="form-control" name="contact[city]" id="city" type="text" placeholder="City"
           value="@if(isset($list['city'])){{$list['city']}}@endif"
           required>

    <br/>
    <input class="form-control" name="contact[state]" id="state" type="text" placeholder="State"
           value="@if(isset($list['state'])){{$list['state']}}@endif"
           required>

    <br/>
    <input class="form-control" name="contact[zip]" id="zip" type="text" placeholder="ZIP"
           value="@if(isset($list['zip'])){{$list['zip']}}@endif"
           required>

    <br/>
    <input class="form-control" name="contact[country]" id="country" type="text" placeholder="Country"
           value="@if(isset($list['country'])){{$list['country']}}@endif"
           required>

    <br/>
    <br/>
    <textarea class="form-control" name="permission_reminder" id="permission_reminder" type="email"
              placeholder="You're receiving this email because you signed up for updates about Freddie's newest hats."
              required>@if(isset($list['permission_reminder'])){{$list['permission_reminder']}}@endif</textarea>

    <br/>

    <h3>Campaign Defaults</h3>
    <input class="form-control" name="campaign_defaults[from_name]" id="from_name" type="text" placeholder="Sender's Name"
           value="@if(isset($list['from_name'])){{$list['from_name']}}@endif"
           required>

    <br/>
    <input class="form-control" name="campaign_defaults[from_email]" id="from_email" type="email" placeholder="Sender's Email Address"
           value="@if(isset($list['from_email'])){{$list['from_email']}}@endif"
           required>

    <br/>
    <input class="form-control" name="campaign_defaults[subject]" id="subject" type="text" placeholder="Subject"
           value="@if(isset($list['subject'])){{$list['subject']}}@endif"
           required>

    <br/>
    <input class="form-control" name="campaign_defaults[language]" id="language" type="text" placeholder="Language"
           value="@if(isset($list['language'])){{$list['language']}}@endif"
           required>

    <br/>
    <label>
        <input class="form-control" name="email_type_option" type="checkbox" required @if(isset($list['email_type_option']) && $list['email_type_option']) checked="checked" @endif> Email Type Option
    </label>

    <br/>

    <div class="text-center">

        <button class="btn btn-info btn-lg" type="submit">Create</button>

    </div>

</div>

{!! Form::close() !!}