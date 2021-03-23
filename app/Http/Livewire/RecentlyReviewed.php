<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class RecentlyReviewed extends Component
{
    public $recentlyReviewed = [];

    public function loadRecentlyReviewed()
    {
        $current = Carbon::now()->timestamp;
        $before = Carbon::now()->subMonths(2)->timestamp;

        $recentlyReviewUnformatted = Cache::remember('recently-reviewed', 7, function () use ($current, $before) {
            return Http::withHeaders(config('services.igdb.headers'))
                ->withBody(
                    "fields name, cover.url,first_release_date, platforms.abbreviation, summary, total_rating_count, rating, slug;
        where platforms = (48, 49, 130, 6)
        & (first_release_date >= {$before}
        & first_release_date < {$current}
        & total_rating_count > 5);
        sort total_rating_count desc; limit 2;", 'text/plain'
                )->post('https://api.igdb.com/v4/games/')->json();
        });

        $this->recentlyReviewed = $this->formatForView($recentlyReviewUnformatted);

        collect($this->recentlyReviewed)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('reviewedGameWithRatingAdded', [
                'slug' => 'review_'.$game['slug'],
                'rating' => $game['rating'] / 100,
            ]);
        });

    }

    public function render()
    {
        return view('livewire.recently-reviewed');
    }

    private function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
                'rating' => isset($game['rating']) ? round($game['rating']) : null,
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            ]);
        });
    }
}
