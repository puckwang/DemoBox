<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AprioriResult extends Model
{
    protected $table = "apriori_result";

    public static function put($data, $key = 1)
    {
        $result = static::find($key);

        if (!$result) {
            $result = new static;
        }

        $result->data = $data;
        $result->save();
    }

    public static function pull($key = 1)
    {
        return static::find($key)->data;
    }
}
