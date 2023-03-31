<?php

namespace App\Http\Controllers;


use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group 검색
 *
 * APIs for search todos
 * Todo 할일을 검색 합니다.
 *
 * 검색처리 컨트롤러
 */

class SearchController extends Controller
{
    /**
     * 할일 검색 하기
     *
     * @queryParam query string 검색어 Example: 안녕
     * @responseFile status=200 scenario="success" responses/todo.get.json
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request){

        $results = [];
        //요청에 query라는 키가 붙어 있다면
        if($query = $request->get('query')){

            //전체 가져오기
            //$results = Todo::search($query)->get();
            //페이징 처리후 가져오기
            //$results = Todo::search($query)->paginate(3);

            /*$results = Todo::search($query, function ($meilisearch, $query, $options) use ($request){
                $rankingRules = $meilisearch->getRankingRules();
                return $meilisearch->search($query, $options);
            })->paginate(3);*/

            $results = Todo::search($query, function ($meilisearch, $query, $options) use ($request){
                $rankingRules = $meilisearch->getRankingRules();

                //$updated_desc_ranking = "updated_at_timestamp:desc";
                $updated_desc_ranking = "updated_at:asc";

                if(!in_array($updated_desc_ranking, $rankingRules)){
                    $meilisearch->updateRankingRules(
                      [
                          //'updated_at_timestamp:desc'
                          'updated_at:asc'
                      ]
                    );
                }

                //dd($rankingRules);

                return $meilisearch->search($query, $options);
            })->paginate(3);


            return response()->json([
                //'result' => $results,
                //그냥 가져오기
                //'data' => $results->items(),
                //Todo Resource로 정제 하기
                'data' => TodoResource::collection($results->items()),
                'meta' => [
                    'current_page' => $results->currentPage(),
                    'last_page' => $results->lastPage(),
                    'path' => $results->path(),
                    'per_page' => $results->perPage(),
                    'hasMorePages' => $results->hasMorePages(),
                    'total' => $results->total(),
                ]
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'result' => null,

            ], Response::HTTP_NO_CONTENT);
        }
    }
}
