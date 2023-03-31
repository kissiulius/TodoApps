<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Todo extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'content',
        'deadline',
        'isDone'
    ];

    /**
     * 모델 인덱스 이름 가져오기
     *
     * @return string
     */
    public function searchableAs()
    {
        return "todos_index";
    }

    /**
     * Get the indexable data array for the model.
     * 모델에 검색가능한 데이터 배열 가져오기
     *
     * @return array
     */
    public function toSearchableArray()
    {
        //전체 설정
        //return $this->toArray();
        //개별 설정
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'deadline' => $this->deadline,
            'isDone' => $this->isDone,
            //'updated_at_timestamp' => $this->updated_at->timestamp,
            'updated_at' => $this->updated_at,
        ];
    }
}
