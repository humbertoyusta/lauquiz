<?php

namespace App\Services\Interfaces;

interface ServiceInterface
{
    public function get(int $id);

    public function save(array $values);

    public function delete(int $id);
}
