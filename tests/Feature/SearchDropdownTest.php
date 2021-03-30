<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Http;
use App\Http\Livewire\SearchDropdown;

class SearchDropdownTest extends TestCase
{
    /** @test */
    public function the_search_dropdown_searches_for_games()
    {
        Http::fake([
            'https://api.igdb.com/v4/games/' => $this->fakeSearchGames(),
        ]);

        Livewire::test(SearchDropdown::class)
            ->assertDontSee('zelda')
            ->set('search', 'zelda')
            ->assertSee('Zelda 2 End of Day')
            ->assertSee('the-legend-of-zelda-skyward-sword-hd');
    }

    private function fakeSearchGames()
    {
        return Http::response([
            0 => [
                "id" => 144640,
                "cover" => [
                    "id" => 133803,
                    "url" => "//images.igdb.com/igdb/image/upload/t_thumb/co2v8r.jpg"
                ],
                "slug" => "zelda-ii-end-of-day",
                "name" => "Zelda 2 End of Day",
            ],
            1 => [
                "id" => 145224,
                "cover" => [
                    "id" => 135666,
                    "url" => "//images.igdb.com/igdb/image/upload/t_thumb/co2woi.jpg"
                ],
                "slug" => "zelda",
                "name" => "zelda",
            ],
            2 => [
                "id" => 143614,
                "cover" => [
                    "id" => 131541,
                    "url" => "//images.igdb.com/igdb/image/upload/t_thumb/co2thx.jpg"
                ],
                "slug" => "the-legend-of-zelda-skyward-sword-hd",
                "name" => "The Legend of Zelda Skyward Sword HD",
            ],
        ], 200);
    }
}
