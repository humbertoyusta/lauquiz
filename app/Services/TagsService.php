<?php

namespace App\Services;

use App\Models\Tag;

class TagsService extends AbstractService
{
    public function __construct()
    {
        parent::__construct(
            Tag::class,
            [
                'name' => 'required|string',
            ],
        );
    }

    public function firstOrCreate(array $values)
    {
        return Tag::firstOrCreate($values);
    }
}
