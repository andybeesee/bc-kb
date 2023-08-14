<?php

namespace App\Livewire\Kb;

use App\Models\Article;
use App\Models\HistoricalVersion;
use Livewire\Component;

// TODO: Approval process
// TODO: Lock down article
class NewArticleForm extends Component
{
    public $title = '';

    public $summary = '';

    public $released = false;

    public $version = 0.01;

    public function render()
    {
        return view('livewire.kb.new-article-form');
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|unique:articles',
        ]);

        $article = new Article();
        $article->title = $this->title;
        $article->summary = $this->summary;
        $article->released = $this->released;
        $article->current_version = $this->version;
        $article->save();

        HistoricalVersion::generate($article, 'Initially Created, Empty');

        return $this->redirect(route('articles.show', $article->id));
    }
}
