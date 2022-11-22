<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Todo extends Model
{
    use Sortable;

    const STATUS = [
        1 => [ 'label' => '未着手' , 'class' => 'label-danger'],
        2 => [ 'label' => '完了' , 'class' => 'label-success'],
    ];

    protected $fillable = ['id','title','status_flag','created_at','updated_at','user_id','due_date','assign_flag','category_id']; 
    public $sortable = ['id','title','status_flag','created_at','updated_at','user_id','due_date','assign_flag','category_id'];

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

    public function coments(){
        return $this->belongsToMany(Coment::class);
    }

}
