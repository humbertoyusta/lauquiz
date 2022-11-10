<?php

namespace App\Services;

use App\Services\Interfaces\ServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractService implements ServiceInterface 
{
    protected $className = "";

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function get (int $id = 0) 
    {
        if ($id === 0) 
        {
            return $this->className::all();
        }
        else {
            $entity = $this->className::find($id);
            if (!$entity)
                throw new HttpException(400, "Entity not found.");
            else
                return $entity;
        }
    }

    public function save (array $values) {
        $entity = null;
        if (!array_key_exists('id', $values) || $values['id'] == 0)
        {
            $entity = $this->className::create($values);
        }
        else
        {
            $entity = $this->get($values['id']);
            unset($values['id']);

            $entity->update($values);
        }
        
        $entity->save();

        return $entity;
    }

    public function delete (int $id) {
        $entity = $this->get($id);

        $entity->delete();
    }
};