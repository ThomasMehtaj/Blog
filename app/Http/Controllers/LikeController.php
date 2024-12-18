<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    
    public function create(Request $request){
        
        $validatedLikes = $request->validate([
            'user_id' => 'required|integer',
            'article_id' => 'required|integer',
        ]);
        
        //Création d'un nouveau like
        $like = new Like();

        $like->user_id = $validatedLikes['user_id'];
        $like->article_id = $validatedLikes['article_id'];;

        if ($like->save()){
            return response()->json($like, Response::HTTP_CREATED);
        } 
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    //Supprime un like
    public function delete(Request $request){


// Dans la table likes il n'y a pas d'id permettant de définir la relation, afin de retrouver la relation, la requête va chercher le user_id saisi et le article_id saisi dans la requête.
//Une fois le user_id et le article_id retrouvé la requête va supprimer la relation dans la table pivot

        if (Like::where('user_id',$request->input('user_id'))->where('article_id',$request->input('article_id'))->delete()){
            return response(null, Response::HTTP_NO_CONTENT);
             }
             return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
