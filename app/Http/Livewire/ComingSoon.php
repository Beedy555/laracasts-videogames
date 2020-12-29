<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ComingSoon extends Component
{
    public $comingSoon = [];

    public function loadComingSoon()
    {
        $current = Carbon::now()->timestamp;

        $this->comingSoon = Cache::remember('coming-soon', 3600, function () use ($current) {

            return Http::withHeaders(config('services.igdb.headers'))
                ->withBody(
                    "fields name, first_release_date, platforms.abbreviation, summary, rating, slug;
        where platforms = (48, 49, 130, 6)
        & (first_release_date > {$current});
        sort first_release_date desc; limit 4;", 'text/plain'
                )->post('https://api.igdb.com/v4/games/')->json();
        });
    }

    public function render()
    {
        return view('livewire.coming-soon');
    }
}
