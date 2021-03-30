<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class SearchDropdown extends Component
{

    public $search;

    public $searchResults = [];

    public function render()
    {
        if(strlen($this->search) >= 2) {
            $this->searchResults = Http::withHeaders(config('services.igdb.headers'))
                ->withBody(
                    "
                search \"{$this->search}\";
                fields name, game.slug, game.cover.url;
                limit 8;
                ", 'text/plain')->post('https://api.igdb.com/v4/search/')->json();
        }

        dump($this->searchResults);

        return view('livewire.search-dropdown');
    }
}
