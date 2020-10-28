<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends AdminController
{

    public function index()
    {

        $articles = Article::all();
        return view('Admin.articles.all' , compact('articles'));
    }


    public function create()
    {
        return view('Admin.articles.create');
    }


    public function store(Request $request)
    {
        $imagesUrl = $this->uploadImages($request->file('imageUrl'));

        auth()->user()->article()->create(array_merge($request->all() , [ 'imageUrl' => $imagesUrl]));

        return redirect(route('articles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('Admin.articles.edit' , compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest|Request $request
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $file = $request->file('imageUrl');
        $inputs = $request->all();

        if($file) {
            $inputs['imageUrl'] = $this->uploadImages($request->file('imageUrl'));
        } else {
            $inputs['imageUrl'] = $article->imageUrl;
            $inputs['imageUrl']['thumb'] = $inputs['imagesThumb'];
        }

        unset($inputs['imagesThumb']);
        $article->update($inputs);

        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect(route('articles.index'));
    }
}
