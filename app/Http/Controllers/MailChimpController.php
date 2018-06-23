<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Config;
use App\Lists;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
use App\Components\MailchimpComponent;


class MailChimpController extends Controller
{

    public $mailchimp;

    public function __construct(MailchimpComponent $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    public function index()
    {
        $model = Lists::all();

        if ($model->count() == 0) {
            $lists = $this->mailchimp->lists->getList();
            if (!empty($lists['data'])) {
                $this->storeLists($lists['data']);
                $model = Lists::all();
            }
        }

        return view('mailchimp/lists', ['model' => $model]);
    }

    public function view($id)
    {
        $list = Lists::find($id)->first()->toArray();

        return view('mailchimp/list_view', ['list' => $list]);
    }

    public function newMailChimpList()
    {
        return view('mailchimp/list_new');
    }

    public function editMailChimpList($id)
    {
        $list = Lists::find($id)->first()->toArray();

        return view('mailchimp/list_edit', ['list' => $list]);
    }

    public function createMailChimpList(Request $request)
    {
        $validate = $this->validate($request);
        if (!$validate) {
            return redirect('list.create')->withErrors($validate);
        }
        $params = $request->all();

        unset($params['_token']);
        $params['email_type_option'] = true;

        $list = $this->saveList($params);

        $this->store($list);

        return redirect('list');
    }

    public function updateMailChimpList($id, Request $request)
    {
        $validate = $this->validate($request);
        $list = Lists::find($id)->first();

        if (!$validate) {
            return redirect(route('list.update', ['id' => $list->mailchimp_list_id]))->withErrors($validate);
        }
        $params = $request->all();
        unset($params['_token']);
        $params['email_type_option'] = true;

        $list = $this->mailchimp->updateList($list->mailchimp_list_id, $params);

        $this->store($list);

        return redirect('list');
    }

    public function deleteMailChimpList($id)
    {
        $list = Lists::find($id)->first();

        $this->mailchimp->deleteList($list->mailchimp_list_id);
        $list->delete();

        return redirect('list');
    }

    public function storeLists($lists)
    {
        DB::beginTransaction();
        try {
            foreach ($lists as $listItem) {
                $this->store($listItem);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dump($e->getMessage());
            Session::save('error', $e->getMessage());
        }
    }

    public function store($list)
    {
        $validator = Validator::make($list, [
            "id" => "required",
            "web_id" => 'required',
            "name" => "required"
        ]);
        if ($validator->fails()) {
            throw new \Exception(sprintf('List %s is not valide', $list['web_id']));
        }
        $model = new Lists;
        $model->mailchimp_list_id = $list['id'];
        $model->web_id = $list['web_id'];
        $model->name = $list['name'];
        $model->date_created = date("Y-m-d H:i:s", strtotime($list['date_created']));
        $model->email_type_option = $list['email_type_option'] ?: null;
        $model->use_awesomebar = isset($list['use_awesomebar']) ? $list['use_awesomebar'] : null;
        $model->default_from_name = isset($list['default_from_name']) ? $list['default_from_name'] : null;
        $model->default_from_email = isset($list['default_from_email']) ? $list['default_from_email'] : null;
        $model->default_subject = isset($list['default_subject']) ? $list['default_subject'] : null;
        $model->default_language = isset($list['default_language']) ? $list['default_language'] : null;
        $model->list_rating = isset($list['list_rating']) ? $list['list_rating'] : null;
        $model->subscribe_url_short = isset($list['subscribe_url_short']) ? $list['subscribe_url_short'] : null;
        $model->subscribe_url_long = isset($list['subscribe_url_long']) ? $list['subscribe_url_long'] : null;
        $model->beamer_address = isset($list['beamer_address']) ? $list['beamer_address'] : null;
        $model->visibility = isset($list['visibility']) ? $list['visibility'] : null;
        $model->stats = isset($list['stats']) ? $list['stats'] : null;

        $model->save();
    }

    protected function saveList($params) {
        return $this->mailchimp->createList($params);
    }

    public function validate(Request $request, array $rules = [], array $messages = [], array $customAttributes = [])
    {
        return $request->validate([
            "name" => "required",
            "permission_reminder" => "required",
            "email_type_option" => "required",
            'contact' => [
                'company' => 'required',
                'address1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
                'country' => 'required',
            ],
            'campaign_defaults' => [
                'from_name' => 'required',
                'from_email' => 'required',
                'subject' => 'required',
                'language' => 'required'
            ]
        ]);
    }
}