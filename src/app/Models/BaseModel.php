<?php


namespace Aldwyn\Blogcms\App\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{


    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = ltrim(strtolower($value),'/');
    }

    public function setLftAttribute($value)
    {
        if (!$value) {
            $this->attributes['lft'] = 0;
        }else{
            $this->attributes['lft'] = $value;
        }
    }

//    public function routeNotificationForTelegram()
//    {
//        return env('TELEGRAM_CHAT_ID');
//    }

}
