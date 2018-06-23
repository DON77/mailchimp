<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use Auth;
use Config;
use App\Lists;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
use App\Components\MailchimpComponent;


class SubscriberController extends Controller
{

    public $mailchimp;

    public function __construct(MailchimpComponent $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    public function listSubscribers($id)
    {
        $model = Subscriber::where(['list_id' => $id])->get();

        return view('subscriber/list', ['model' => $model, 'id' => $id]);
    }

    public function newSubscriber($id)
    {
        return view('subscriber/new', [
            'model' => [
                'email' => '',
                'list_id' => $id
            ]
        ]);
    }

    public function edit($id)
    {
        $model = Subscriber::find($id)->first()->toArray();

        return view('subscriber/edit', ['model' => $model]);
    }

    public function create(Request $request)
    {
        $validate = $this->validate($request);
        if (!$validate) {
            return redirect(route('subscribtion.create', ['id' => $request->list_id]))->withErrors($validate);
        }

        DB::beginTransaction();
        try {
            $this->mailchimp->createSubscriber($request->list_id, $request->email);
            $this->store($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect(route('subscribers', ['id' => $request->list_id]));
    }

    public function update($id, Request $request)
    {
        $validate = $this->validate($request);
        if (!$validate) {
            return redirect(route('subscribtion.update', ['id' => $request->list_id]))->withErrors($validate);
        }

        DB::beginTransaction();
        try {
            $this->mailchimp->updateSubscriber($request->list_id, $request->email);
            $subscriber = Subscriber::find($id)->first();
            $subscriber->email = $request->email;
            $subscriber->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect(route('subscribers', ['id' => $request->list_id]));
    }

    public function delete($id)
    {
        $subscriber = Subscriber::find($id)->first();

        $this->mailchimp->deleteSubscriber($subscriber->list_id, $subscriber->email);
        $subscriber->delete();

        return redirect(route('subscribers', ['id' => $subscriber->list_id]));
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request);
        if ($validator->fails()) {
            redirect(route('subscriber.new', ['id' => $request->list_id]))->withErrors($validator);
        }
        $model = new Subscriber();
        $model->list_id = $request->list_id;
        $model->email = $request->email;

        $model->save();
    }

    public function validate(Request $request, array $rules = [], array $messages = [], array $customAttributes = [])
    {
        return Validator::make($request->all(), [
            "email" => 'required|email'
        ]);
    }
}