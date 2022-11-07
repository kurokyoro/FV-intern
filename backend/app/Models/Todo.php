<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    const STATUS = [
        1 => [ 'label' => '未着手' , 'class' => 'label-danger'],
        2 => [ 'label' => '完了' , 'class' => 'label-success'],
    ];

    // protected $guarded = array('id'); 

    /**
     * 状態のラベル
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        // 状態値
        $status = $this->attributes['status_flag'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label'];
    }


    /**
     * 状態のラベル
     * @return string
     */
    public function getStatusClassAttribute()
    {
        // 状態値
        $status = $this->attributes['status_flag'];
    
        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }
    
        return self::STATUS[$status]['class'];
    }

}
