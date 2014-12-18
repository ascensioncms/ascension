<?php
/*!
 * Ascension
 * Copyright 2014 Jack Polgar
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Ascension\Controllers;

use Ascension\Models\Article;

/**
 * Articles controller.
 */
class Articles extends AppController
{
    /**
     * Current article.
     *
     * @var Article
     */
    protected $article;

    /**
     * Override constructor to add before filters.
     */
    public function __construct()
    {
        parent::__construct();

        $this->before('show', function(){
            $this->article = Article::find($this->route['params']['id']);

            if (!$this->article) {
                return $this->show404();
            }
        });
    }

    /**
     * Article listing.
     */
    public function indexAction()
    {
        return $this->render('articles/index.html.twig', [
            'articles' => Article::all()
        ]);
    }

    /**
     * Show article.
     *
     * @param integer $id Article ID
     */
    public function showAction($id)
    {
        return $this->render('articles/show.html.twig', [
            'article' => $this->article
        ]);
    }
}
