<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lists extends Model
{
    protected $table = 'lists';
    public $timestamps = false;
    public $stats;

    public function afterSave()
    {
        if (!empty($this->stats)) {
            $statsModel = new ListStat();
            foreach ($this->stats as $key => $value) {
                $statsModel->setAttribute($key, $value);
            }
            $statsModel->save();
        }
    }
}
