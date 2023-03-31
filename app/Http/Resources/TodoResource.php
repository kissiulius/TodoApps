<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        #디비구조
        #할일:
        #제목 : string required
        #내용 : longtext optional
        #마감기한 : date optional
        #완료여부 : boolean default false

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'deadline' => ($this->deadline == null) ? "마감기간이 정해져 있지 않습니다." : date('Y-m-d', strtotime($this->deadline)),
            'isDone' => $this->isDone,
            'updated_at' => $this->updated_at->diffForHumans() . "에 수정 되었습니다.",
        ];
    }
}
