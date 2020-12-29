<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class MostAnticipated extends Component
{
    public $mostAnticipated = [];

    public function loadMostAnticipated()
    {
        $current = Carbon::now()->timestamp;
        $afterFourMonths = Carbon::now()->addMonths(4)->timestamp;

        $this->mostAnticipated = Cache::remember('most-anticipated', 3600, function () use ($current, $afterFourMonths) {
            return Http::withHeaders(config('services.igdb.headers'))
                ->withBody(
                    "fields name, cover.url,first_release_date, platforms.abbreviation, total_rating, summary, slug;
        where platforms = (48, 49, 130, 6)
        & (first_release_date > {$current}
        & first_release_date < {$afterFourMonths});
        sort total_rating desc; limit 4;", 'text/plain'
                )->post('https://api.igdb.com/v4/games/')->json();
        });
    }

    public function render()
    {
        return view('livewire.most-anticipated');
    }
}
