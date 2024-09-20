<?php

namespace Database\Seeders;

use App\Models\Social;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    public function run(): void
    {
        Social::insert([
            [
                'platform' => 'email',
                'url' => 'mailto://hello@wduyck.dev',
                'icon' => 'lucide-mail',
                'color' => null,
                'sort' => 0,
            ],
            [
                'platform' => 'mastodon',
                'url' => 'https://mastodon.social/@fuzzyfox0',
                'icon' => 'fab-mastodon',
                'color' => '#6364ff',
                'sort' => 0,
            ],
            [
                'platform' => 'twtitter',
                'url' => 'https://twitter.com/FuzzyFox0',
                'icon' => 'fab-x-twitter',
                'color' => null,
                'sort' => 0,
            ],
            [
                'platform' => 'linkedin',
                'url' => 'https://linkedin.com/in/wduyck',
                'icon' => 'fab-linkedin',
                'color' => '#0a66c2',
                'sort' => 0,
            ],
            [
                'platform' => 'blog',
                'url' => 'https://ghost.wduyck.me',
                'icon' => 'fas-rss-square',
                'color' => '#eb7818',
                'sort' => 0,
            ],
            [
                'platform' => 'github',
                'url' => 'https://github.com/fuzzyfox',
                'icon' => 'fab-github',
                'color' => null,
                'sort' => 0,
            ],
            [
                'platform' => 'codepen',
                'url' => 'https://codepen.io/fuzzyfox',
                'icon' => 'fab-codepen',
                'color' => null,
                'sort' => 0,
            ],
            [
                'platform' => 'deviantart',
                'url' => 'https://www.deviantart.com/fuzzyfox0',
                'icon' => 'fab-deviantart',
                'color' => '#04cc48',
                'sort' => 0,
            ],
        ]);
    }
}
