<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Sushi\Sushi;

class Icon extends Model
{
    use Sushi;

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';

    public function getRows()
    {
        $icons = [];

        $sets = app(\BladeUI\Icons\Factory::class)->all();

        foreach ($sets as $setName => $set) {
            foreach ($set['paths'] as $path) {
                foreach (File::files($path) as $file) {
                    $icons[] = [
                        'set' => $setName,
                        'prefix' => $set['prefix'],
                        'name' => $file->getFilenameWithoutExtension(),
                        'svg' => $file->getContents(),
                        'id' => $set['prefix'].'-'.$file->getFilenameWithoutExtension(),
                    ];
                }
            }
        }

        return $icons;
    }
}
