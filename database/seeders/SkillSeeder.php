<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        Skill::insert([
            [
                'name' => 'Laravel',
                'description' => null,
                'start_year' => 2016,
                'level' => 'Expert',
                'icon' => 'fab-laravel',
                'color' => '#ff2d20',
                'sort' => 0,
                'years_of_experience' => 8,
                'is_promoted' => 1,
                'slug' => 'laravel',
            ],
            [
                'name' => 'PHP',
                'description' => null,
                'start_year' => 2008,
                'level' => 'Expert',
                'icon' => 'fab-php',
                'color' => '#777bb3',
                'sort' => 0,
                'years_of_experience' => 16,
                'is_promoted' => 1,
                'slug' => 'php',
            ],
            [
                'name' => 'JavaScript',
                'description' => null,
                'start_year' => 2004,
                'level' => 'Expert',
                'icon' => 'fab-js',
                'color' => '#f0db4f',
                'sort' => 0,
                'years_of_experience' => 20,
                'is_promoted' => 1,
                'slug' => 'js',
            ],
            [
                'name' => 'TypeScript',
                'description' => null,
                'start_year' => 2019,
                'level' => 'Advanced',
                'icon' => 'si-typescript',
                'color' => '#3178c6',
                'sort' => 0,
                'years_of_experience' => 3,
                'is_promoted' => 1,
                'slug' => 'ts',
            ],
            [
                'name' => 'Vue.js',
                'description' => null,
                'start_year' => 2016,
                'level' => 'Advanced',
                'icon' => 'fab-vuejs',
                'color' => '#41b883',
                'sort' => 0,
                'years_of_experience' => 8,
                'is_promoted' => 1,
                'slug' => 'vue',
            ],
            [
                'name' => 'CodeIgniter',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Advanced',
                'icon' => 'si-codeigniter',
                'color' => '#e2491c',
                'sort' => 0,
                'years_of_experience' => 4,
                'is_promoted' => 0,
                'slug' => 'codeigniter',
            ],
            [
                'name' => 'Bash',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Advanced',
                'icon' => 'si-gnubash',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 1,
                'slug' => 'bash',
            ],
            [
                'name' => 'Scrum',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 0,
                'slug' => 'scrum',
            ],
            [
                'name' => 'Bootstrap',
                'description' => null,
                'start_year' => 2011,
                'level' => 'Advanced',
                'icon' => 'fab-bootstrap',
                'color' => '#702bf6',
                'sort' => 0,
                'years_of_experience' => 13,
                'is_promoted' => 1,
                'slug' => 'bootstrap',
            ],
            [
                'name' => 'CSS',
                'description' => null,
                'start_year' => 2004,
                'level' => 'Expert',
                'icon' => 'fab-css3',
                'color' => '#2465f1',
                'sort' => 0,
                'years_of_experience' => 20,
                'is_promoted' => 1,
                'slug' => 'css',
            ],
            [
                'name' => 'Database Architecture',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 0,
                'slug' => 'db-architecture',
            ],
            [
                'name' => 'Docker',
                'description' => null,
                'start_year' => 2019,
                'level' => 'Advanced',
                'icon' => 'fab-docker',
                'color' => '#1d63ed',
                'sort' => 0,
                'years_of_experience' => 5,
                'is_promoted' => 1,
                'slug' => 'docker',
            ],
            [
                'name' => 'Git',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Advanced',
                'icon' => 'fab-git-alt',
                'color' => '#f54e28',
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 0,
                'slug' => 'git',
            ],
            [
                'name' => 'Foundation',
                'description' => null,
                'start_year' => 2013,
                'level' => 'Advanced',
                'icon' => 'devicon-foundation',
                'color' => '#1779ba',
                'sort' => 0,
                'years_of_experience' => 6,
                'is_promoted' => 0,
                'slug' => 'foundation',
            ],
            [
                'name' => 'HTML',
                'description' => null,
                'start_year' => 2004,
                'level' => 'Expert',
                'icon' => 'fab-html5',
                'color' => '#f06529',
                'sort' => 0,
                'years_of_experience' => 20,
                'is_promoted' => 0,
                'slug' => 'html',
            ],
            [
                'name' => 'RESTful APIs',
                'description' => null,
                'start_year' => null,
                'level' => 'Expert',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'rest',
            ],
            [
                'name' => 'Agile Methodologies',
                'description' => null,
                'start_year' => 2015,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 9,
                'is_promoted' => 0,
                'slug' => 'agile',
            ],
            [
                'name' => 'Yii',
                'description' => null,
                'start_year' => 2015,
                'level' => 'Intermediate',
                'icon' => 'si-yii',
                'color' => '#40b3d8',
                'sort' => 0,
                'years_of_experience' => 2,
                'is_promoted' => 0,
                'slug' => 'yii',
            ],
            [
                'name' => 'UML',
                'description' => null,
                'start_year' => 2011,
                'level' => 'Intermediate',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'uml',
            ],
            [
                'name' => 'Unit Testing',
                'description' => null,
                'start_year' => 2012,
                'level' => 'Expert',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 10,
                'is_promoted' => 0,
                'slug' => 'unit-testing',
            ],
            [
                'name' => 'Travis CI',
                'description' => null,
                'start_year' => 2013,
                'level' => 'Intermediate',
                'icon' => 'si-travisci',
                'color' => '#DB4545',
                'sort' => 0,
                'years_of_experience' => 3,
                'is_promoted' => 0,
                'slug' => 'travis',
            ],
            [
                'name' => 'Technical Documentation',
                'description' => null,
                'start_year' => null,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'techdocs',
            ],
            [
                'name' => 'Team Leadership',
                'description' => null,
                'start_year' => 2018,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 6,
                'is_promoted' => 0,
                'slug' => 'team-lead',
            ],
            [
                'name' => 'System Architecture',
                'description' => null,
                'start_year' => 2016,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 8,
                'is_promoted' => 0,
                'slug' => 'sys-architecture',
            ],
            [
                'name' => 'Structured Query Language (SQL)',
                'description' => null,
                'start_year' => 2008,
                'level' => 'Expert',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 10,
                'is_promoted' => 0,
                'slug' => 'sql',
            ],
            [
                'name' => 'Software Architecture',
                'description' => null,
                'start_year' => 2014,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 10,
                'is_promoted' => 0,
                'slug' => 'software-architecture',
            ],
            [
                'name' => 'Shell',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Advanced',
                'icon' => 'lucide-terminal',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 0,
                'slug' => 'shell',
            ],
            [
                'name' => 'Redis',
                'description' => null,
                'start_year' => 2016,
                'level' => 'Intermediate',
                'icon' => 'devicon-redis',
                'color' => '#dd3528',
                'sort' => 0,
                'years_of_experience' => 6,
                'is_promoted' => 1,
                'slug' => 'redis',
            ],
            [
                'name' => 'Python',
                'description' => null,
                'start_year' => 2012,
                'level' => 'Beginner',
                'icon' => 'fab-python',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 4,
                'is_promoted' => 0,
                'slug' => 'python',
            ],
            [
                'name' => 'Project Management',
                'description' => null,
                'start_year' => null,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'project-management',
            ],
            [
                'name' => 'Node.js',
                'description' => null,
                'start_year' => 2013,
                'level' => 'Advanced',
                'icon' => 'fab-node-js',
                'color' => '#699f63',
                'sort' => 0,
                'years_of_experience' => 10,
                'is_promoted' => 1,
                'slug' => 'node',
            ],
            [
                'name' => 'Nginx',
                'description' => null,
                'start_year' => 2014,
                'level' => 'Intermediate',
                'icon' => 'si-nginx',
                'color' => '#019137',
                'sort' => 0,
                'years_of_experience' => 10,
                'is_promoted' => 0,
                'slug' => 'nginx',
            ],
            [
                'name' => 'Natural Language Processing',
                'description' => null,
                'start_year' => null,
                'level' => 'Intermediate',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'nlp',
            ],
            [
                'name' => 'MySQL',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Expert',
                'icon' => 'devicon-mysql',
                'color' => '#42759c',
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 1,
                'slug' => 'mysql',
            ],
            [
                'name' => 'MongoDB',
                'description' => null,
                'start_year' => 2016,
                'level' => 'Intermediate',
                'icon' => 'si-mongodb',
                'color' => '#00684a',
                'sort' => 0,
                'years_of_experience' => 3,
                'is_promoted' => 0,
                'slug' => 'mongo',
            ],
            [
                'name' => 'Microservices',
                'description' => null,
                'start_year' => null,
                'level' => 'Intermediate',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'microservices',
            ],
            [
                'name' => 'Linux',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Expert',
                'icon' => 'fab-linux',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 1,
                'slug' => 'linux',
            ],
            [
                'name' => 'JSON',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Expert',
                'icon' => 'si-json',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 0,
                'slug' => 'json',
            ],
            [
                'name' => 'jQuery',
                'description' => null,
                'start_year' => 2006,
                'level' => 'Expert',
                'icon' => 'si-jquery',
                'color' => '#0769ad',
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 0,
                'slug' => 'jquery',
            ],
            [
                'name' => 'Jira',
                'description' => null,
                'start_year' => 2018,
                'level' => 'Advanced',
                'icon' => 'fab-jira',
                'color' => '#0052cc',
                'sort' => 0,
                'years_of_experience' => 6,
                'is_promoted' => 0,
                'slug' => 'jira',
            ],
            [
                'name' => 'IT Security',
                'description' => null,
                'start_year' => null,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'it-sec',
            ],
            [
                'name' => 'IT administration',
                'description' => null,
                'start_year' => null,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'it-admin',
            ],
            [
                'name' => 'Express',
                'description' => null,
                'start_year' => 2012,
                'level' => 'Advanced',
                'icon' => 'si-express',
                'color' => '#7e7e7e',
                'sort' => 0,
                'years_of_experience' => 12,
                'is_promoted' => 0,
                'slug' => 'express',
            ],
            [
                'name' => 'DevOps',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Intermediate',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 10,
                'is_promoted' => 1,
                'slug' => 'devops',
            ],
            [
                'name' => 'Domain Driven Development',
                'description' => null,
                'start_year' => null,
                'level' => 'Advanced',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'ddd',
            ],
            [
                'name' => 'Continuous Integration',
                'description' => null,
                'start_year' => 2015,
                'level' => 'Expert',
                'icon' => null,
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 9,
                'is_promoted' => 0,
                'slug' => 'ci',
            ],
            [
                'name' => 'CircleCI',
                'description' => null,
                'start_year' => 2015,
                'level' => 'Intermediate',
                'icon' => 'si-circleci',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 9,
                'is_promoted' => 0,
                'slug' => 'circleci',
            ],
            [
                'name' => 'CakePHP',
                'description' => null,
                'start_year' => null,
                'level' => 'Beginner',
                'icon' => 'si-cakephp',
                'color' => '#d33c43',
                'sort' => 0,
                'years_of_experience' => 1,
                'is_promoted' => 0,
                'slug' => 'cakephp',
            ],
            [
                'name' => 'C',
                'description' => null,
                'start_year' => 2011,
                'level' => 'Beginner',
                'icon' => 'devicon-c',
                'color' => '#00589c',
                'sort' => 0,
                'years_of_experience' => 1,
                'is_promoted' => 0,
                'slug' => 'c',
            ],
            [
                'name' => 'C#',
                'description' => null,
                'start_year' => 2008,
                'level' => 'Beginner',
                'icon' => 'devicon-csharp',
                'color' => '#803789',
                'sort' => 0,
                'years_of_experience' => 3,
                'is_promoted' => 0,
                'slug' => 'csharp',
            ],
            [
                'name' => 'Backbone.js',
                'description' => null,
                'start_year' => 2014,
                'level' => 'Intermediate',
                'icon' => 'si-backbonedotjs',
                'color' => '#0071b5',
                'sort' => 0,
                'years_of_experience' => 2,
                'is_promoted' => 0,
                'slug' => 'backbone',
            ],
            [
                'name' => 'Block Element Modifier (BEM)',
                'description' => null,
                'start_year' => 2013,
                'level' => 'Expert',
                'icon' => 'si-bem',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 10,
                'is_promoted' => 0,
                'slug' => 'bem',
            ],
            [
                'name' => 'Apache',
                'description' => null,
                'start_year' => 2008,
                'level' => 'Intermediate',
                'icon' => 'si-apache',
                'color' => '#cb2433',
                'sort' => 0,
                'years_of_experience' => 10,
                'is_promoted' => 0,
                'slug' => 'apache',
            ],
            [
                'name' => 'Ansible',
                'description' => null,
                'start_year' => 2023,
                'level' => 'Beginner',
                'icon' => 'si-ansible',
                'color' => '#c60000',
                'sort' => 0,
                'years_of_experience' => 1,
                'is_promoted' => 0,
                'slug' => 'ansible',
            ],
            [
                'name' => 'Amazon Web Services (AWS)',
                'description' => null,
                'start_year' => 2016,
                'level' => 'Intermediate',
                'icon' => 'fab-aws',
                'color' => '#ff9900',
                'sort' => 0,
                'years_of_experience' => 4,
                'is_promoted' => 1,
                'slug' => 'aws',
            ],
            [
                'name' => 'Sass',
                'description' => null,
                'start_year' => 2012,
                'level' => 'Expert',
                'icon' => 'fab-sass',
                'color' => '#cf649a',
                'sort' => 0,
                'years_of_experience' => 12,
                'is_promoted' => 1,
                'slug' => 'sass',
            ],
            [
                'name' => 'Less',
                'description' => null,
                'start_year' => 2011,
                'level' => 'Advanced',
                'icon' => 'fab-less',
                'color' => '#1d365d',
                'sort' => 0,
                'years_of_experience' => 3,
                'is_promoted' => 0,
                'slug' => 'less',
            ],
            [
                'name' => 'Stylus',
                'description' => null,
                'start_year' => 2011,
                'level' => 'Advanced',
                'icon' => 'si-stylus',
                'color' => '#b3d107',
                'sort' => 0,
                'years_of_experience' => 2,
                'is_promoted' => 0,
                'slug' => 'styl',
            ],
            [
                'name' => 'GitHub',
                'description' => null,
                'start_year' => 2009,
                'level' => 'Advanced',
                'icon' => 'si-github',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 15,
                'is_promoted' => 1,
                'slug' => 'github',
            ],
            [
                'name' => 'GitHub Actions',
                'description' => null,
                'start_year' => 2021,
                'level' => 'Intermediate',
                'icon' => 'si-githubactions',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => 2,
                'is_promoted' => 0,
                'slug' => 'github-actions',
            ],
            [
                'name' => 'SVG',
                'description' => null,
                'start_year' => null,
                'level' => 'Intermediate',
                'icon' => 'si-svg',
                'color' => null,
                'sort' => 0,
                'years_of_experience' => null,
                'is_promoted' => 0,
                'slug' => 'svg',
            ],
        ]);

        $parentRelations = [
            'laravel' => 'php',
            'ts' => 'js',
            'vue' => 'js',
            'codeigniter' => 'php',
            'bash' => 'linux',
            'scrum' => 'agile',
            'bootstrap' => 'css',
            'docker' => 'devops',
            'foundation' => 'css',
            'agile' => 'project-management',
            'yii' => 'php',
            'travis' => 'ci',
            'shell' => 'linux',
            'node' => 'js',
            'nginx' => 'devops',
            'mysql' => 'sql',
            'microservices' => 'devops',
            'jquery' => 'js',
            'jira' => 'project-management',
            'express' => 'node',
            'circleci' => 'ci',
            'cakephp' => 'php',
            'backbone' => 'js',
            'bem' => 'css',
            'apache' => 'devops',
            'ansible' => 'devops',
            'aws' => 'devops',
            'sass' => 'css',
            'less' => 'css',
            'styl' => 'css',
            'github' => 'git',
            'github-actions' => 'github',
        ];

        $parents = Skill::whereIn('slug', array_values($parentRelations))->pluck('id', 'slug');
        $skills = Skill::whereIn('slug', array_keys($parentRelations))->get();

        foreach ($parentRelations as $skillSlug => $parentSlug) {
            $skills->firstWhere('slug', $skillSlug)->update(['parent_id' => $parents->get($parentSlug)]);
        }
    }
}
