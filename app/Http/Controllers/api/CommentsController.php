<?php
namespace App\Http\Controllers\api;
use App\User;
use App\Products;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * Class CommentsController
 * @package App\Http\Controllers\api
 */
class CommentsController extends Controller
{
    /**
     * @param Request $request
     * @param $userId
     * @param $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveComment(Request $request, $userId, $productId) {
        if(Products::where('id', $productId)->exists() && User::where('id', $userId)->exists()) {
            if ('' == $request['comment']){
                return response()->json(['status' => false]);
            }
            $comments = new Comment;
            $comments->title = $request['title'];
            $comments->comments_user_id_foreign = $userId;
            $comments->comments_product_id_foreign = $productId;
            $comments->comment = $request['comment'];
            $comments->level = $request['level'];
            $comments->save();
            return response()->json(['status' => true]);
        }
        else{
            return response()->json(['status' => false]);
        }
    }

    public function updateComment(Request $request, $commentId){
        if (Comment::where('id', $commentId)->exists()) {
            $comment = Comment::find($commentId);
            $comment->title = $request['title'];
            $comment->comment = $request['comment'];
            $comment->update();

            return response()->json(['status' => true]);
        }
        else {
            return response()->json(['status' => false]);
        }
    }

    public function deleteComment($commentId) {
        if (Comment::where('id', $commentId)->exists()) {
            $comment = Comment::find($commentId);
            $comment->delete();
            return response()->json(['status' => true]);
        }
        else {
            return response()->json(['status' => false]);
        }
    }

    public function getComment($productId) {
        if (Products::where('id', $productId)->exists()) {
            $comment = Comment::where('comments_product_id_foreign', $productId)->get();

            while(Comment::where('comments_product_id_foreign', $productId)->exists()) {
                $comment_list = Comment::where('comments_product_id_foreign', $productId)->get();
                $result = [];

                if ($comment_list->isEmpty()) {
                    return response()->json(
                        ['error' => 'comments are null']
                    );
                }
                foreach ($comment_list as $item) {
                    $user = User::find($item['comments_user_id_foreign']);
                    $user_name = $user['name'];
                    $result[] = [
                        'user_name' => $user_name,
                        'comment' => $item['comment'],
                        'title' => $item['title'],
                        'level' => $item['level'],
                        'product_id' => $item['comments_product_id_foreign'],
                        'date' => $item->created_at->format('d-m-Y')
                    ];
                }
                return response()->json($result);
            }

//            $user = User::find($comment['comments_user_id_foreign']);
//            $user_name = $user['name'];
//            $result = [
//                'user_name' => $user_name,
//                'comment' => $comment['comment'],
//                'title' => $comment['title'],
//                'level' => $comment['level'],
//                'product_id' => $comment['comments_product_id_foreign'],
//                'date' => $comment->created_at->format('d-m-Y')
//            ];
//
//            return response()->json($result);
        }
        else {
            return response()->json(['status' => false]);
        }
    }

}
