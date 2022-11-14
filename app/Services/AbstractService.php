<?php

namespace App\Services;

use App\Services\Interfaces\ServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractService implements ServiceInterface
{
    protected $className = '';
    protected $validationRules = [];

    public function __construct(string $className, array $validationRules)
    {
        $this->className = $className;
        $this->validationRules = $validationRules;
    }

    public function get(int $id = 0)
    {
        if ($id === 0) {
            return $this->className::all();
        } else {
            $entity = $this->className::find($id);
            if (! $entity) {
                throw new HttpException(400, 'Entity not found.');
            } else {
                return $entity;
            }
        }
    }

    public function save(Request $request, int $id = 0)
    {
        $validated = $request->validate($this->validationRules);

        $entity = null;
        if ($id == 0) {
            $entity = $this->className::create($validated);
        } else {
            $entity = $this->get($id);

            $entity->update($validated);
        }

        $entity->save();

        return $entity;
    }

    public function delete(int $id)
    {
        $entity = $this->get($id);

        $entity->delete();
    }
}
