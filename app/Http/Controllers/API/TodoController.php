<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Todo 포스트 관리
 *
 * APIs for managing posts
 * Todo 포스트를 관리합니다.
 */
class TodoController extends Controller
{
    /**
     * 포스트 리스트 가져오기
     *
     * @queryParam page integer 페이지 Example: 1
     * @responseFile status=200 scenario="성공" responses/todos.get.json
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //return Todo::all();
        //return TodoResource::collection(Todo::all());
        //return TodoResource::collection(Todo::paginate(5));
        return TodoResource::collection(Todo::orderby('updated_at', 'desc')->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * 포스트 추가하기
     *
     * @responseFile status=201 scenario="success" responses/todo.post.json
     * @responseFile status=201 scenario="마감기한이 정해져 있지 않을 때" responses/todo.get.without_deadline.json
     * @responseFile status=422 scenario="데이터가 유효하지 않을 때" responses/todo.invalid.json
     * @param TodoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $userInput = $request->all();

        $newTodo = Todo::create($userInput);

        return new TodoResource($newTodo);
    }

    /**
     * 특정 할일 가져오기
     *
     * @urlParam id integer required 할일 아이디 Example: 10
     * /**
     * @responseFile status=200 scenario="success" responses/todo.get.json
     * @responseFile status=200 scenario="마감기한이 정해져 있지 않을때" responses/todo.get.without_deadline.json
     * @responseFile status=404 scenario="todo not found" responses/todo.not_found.json
     *
     */
    public function show(string $id)
    {
        if(Todo::where('id', $id)->exists()){
            return new TodoResource(Todo::find($id));
        }else{
            return response()->json([
                "message" => "해당 할일을 찾을수 없습니다.",
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * 특정 할일 수정하기
     *
     * @urlParam id integer required 할일 아이디 Example: 10
     * @responseFile status=200 scenario="success" responses/todo.post.json
     * @responseFile status=404 scenario="todo not found" responses/todo.not_found.json
     * @responseFile status=422 scenario="데이터가 유효하지 않을 때" responses/todo.invalid.json
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoRequest $request, string $id)
    {
        if(Todo::where('id', $id)->exists()){
            $fetchedTodo = Todo::find($id); //찾기

            $fetchedTodo->update($request->all()); //찾은 항목을 유저 입력 값으로 업데이트 하기

            return new TodoResource($fetchedTodo); //수정된 항목 리턴
        }else{
            return response()->json([
                "message" => "해당 할일을 찾을수 없습니다.",
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * 특정 할일 삭제하기
     *
     * @urlParam id integer required 할일 아이디 Example: 10
     * @response status=204 scenario="success" {}
     * @responseFile status=404 scenario="todo not found" responses/todo.not_found.json
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        if(Todo::where('id', $id)->exists()){
            $fetchedTodo = Todo::find($id); //찾기
            $fetchedTodo->delete(); //찾은 항목을 삭제 하기
            return response()->json([
                "message" => "해당 할일을 삭제 하였습니다.",
            ], Response::HTTP_NO_CONTENT);

        }else{
            return response()->json([
                "message" => "해당 할일을 찾을수 없습니다.",
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
