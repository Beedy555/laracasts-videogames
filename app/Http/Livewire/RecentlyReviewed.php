<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RecentlyReviewed extends Component
{
    public $recentlyReviewed = [];

    public function loadRecentlyReviewed()
    {
        $current = Carbon::now()->timestamp;
        $beforeTwoWeeks = Carbon::now()->subWeeks(3)->timestamp;

        $this->recentlyReviewed = Cache::remember('recently-reviewed', 3600, function () use ($current, $beforeTwoWeeks) {
            return Http::withHeaders(config('services.igdb.headers'))
                ->withBody(
                    "fields name, cover.url,first_release_date, platforms.abbreviation, total_rating_count, summary, rating, slug;
        where platforms = (48, 49, 130, 6)
        & (first_release_date >= {$beforeTwoWeeks}
        & first_release_date < {$current}
        & total_rating_count > 5);
        sort total_rating_count desc; limit 3;", 'text/plain'
                )->post('https://api.igdb.com/v4/games/')->json();
        });
    }

    public function render()
    {
        return view('livewire.recently-reviewed');
    }
}
