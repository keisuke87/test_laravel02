<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Task;
use Illuminate\Http\Request;
// 表示処理の作成
Route::get('/', function () {
    $tasks = Task::orderBy('deadline', 'asc')->get();
        return view('tasks', [
            'tasks' => $tasks
]);
});
// 登録処理の作成
Route::post('/tasks', function (Request $request) {
 //バリデーション
    $validator = Validator::make($request->all(), [
    'task' => 'required|max:255',
 ]);
 
//バリデーション:エラー
if ($validator->fails()) {
    return redirect('/')
    ->withInput()
    ->withErrors($validator);
}

// Eloquentモデル
    $task = new Task;
    $task->task = $request->task;
    $task->deadline = '2019-01-23';
    $task->comment = 'todo!';
    $task->save();
//「/」ルートにリダイレクト
    return redirect('/');
});

// 削除処理の作成
Route::post('/task/{task}', function (Task $task) {
    $task->delete();
    return redirect('/');
});