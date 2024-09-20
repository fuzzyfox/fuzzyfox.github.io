<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positons = [
            [
                'title' => 'Head of Engineering',
                'company' => 'Address Intelligence',
                'description' => 'Introduced engineering best practices that enhanced code quality and maintainability. Developed a high-performance property search platform with advanced filtering and demographic integration using Laravel, VueJS, and MySQL. Led the architecture and development of a nationwide web-to-print WYSIWYG tool for targeted direct mail marketing campaigns.',
                'type' => 'FullTime',
                'locality' => 'London',
                'region' => 'GB',
                'start_date' => '2018-03-01',
                'end_date' => '2023-12-01',
            ],
            [
                'title' => 'Senior Fullstack Engineer',
                'company' => 'Firedrop',
                'description' => 'As a key team member at Firedrop, I was instrumental in developing an AI-driven website builder with a cutting-edge conversational interface. I collaborated with AI specialists to design the chatbot workflow and templating engine, enhancing user interaction and web design quality. Later, I led the adaptation of our AI technology for a major multinational client, automating and scaling packaging design processes, which significantly improved global production efficiency and consistency.',
                'type' => 'FullTime',
                'locality' => 'London',
                'region' => 'GB',
                'start_date' => '2016-07-01',
                'end_date' => '2018-06-01',
            ],
            [
                'title' => 'Fullstack Engineer',
                'company' => 'Powermeeter',
                'description' => null,
                'type' => 'FullTime',
                'locality' => 'London',
                'region' => 'GB',
                'start_date' => '2015-12-01',
                'end_date' => '2016-07-01',
            ],
            [
                'title' => 'Creative Coder',
                'company' => 'Mozilla Foundation',
                'description' => null,
                'type' => 'FullTime',
                'locality' => 'London',
                'region' => 'GB',
                'start_date' => '2013-07-01',
                'end_date' => '2014-09-01',
            ],
        ];

        Position::insert($positons);
    }
}
