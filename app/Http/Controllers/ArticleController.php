<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * Affiche tout les articles.
     */
    public function list()
    {
        $articles = Article::all();
        return $articles; 
    }

    /**
     * Création d'un nouvel article.
     */
    public function create(Request $request)
    {
         // Extraction et sécurisation des valeurs passées dans le body de la requête
        $title = htmlspecialchars($request->input('title'), ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($request->input('content'), ENT_QUOTES, 'UTF-8');
        $user_id = htmlspecialchars($request->input('user_id'), ENT_QUOTES, 'UTF-8');

        // Création d'une nouvelle instance Article
        $article = new Article();

        // Sauvegarde de l'article
        $article->title = $title;
        $article->content = $content;
        $article->user_id = $user_id;

        // Gestion de la réponse HTTP
        if ($article->save()){
            return response()->json($article, Response::HTTP_CREATED);
        } 
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    
    }

    /**
     * Permet de lire un article en particulier.
     */
    public function read(string $id)
    {
        $article = Article::findOrFail($id);
        return $article;
    }

    /**
     * Permet de mettre à jour un article.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        if ($request->has('title')) {
            $article->title = htmlspecialchars($request->input('title'), ENT_QUOTES, 'UTF-8');  // Protection contre les failles XSS
            }

        if ($request->has('content')) {
            $article->content = htmlspecialchars($request->input('content'), ENT_QUOTES, 'UTF-8');  
            }

        // Gestion de la réponse HTTP
        if ($article->save()){
            return response()->json($article);
    }
    return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
   
    }

    /**
     * Permet de supprimer un article de la BDD.
     */
    public function delete(string $id)
    {
        $article = Article::findOrFail($id);
        
        if ($article->delete()){
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
