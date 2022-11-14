<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface ServiceInterface
{
    public function get(int $id);

    public function save(Request $request, int $id);

    public function delete(int $id);
}
