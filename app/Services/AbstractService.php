<?php

namespace App\Services;

use App\Services\Interfaces\ServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * AbstractService to be extended by other Services
 */
abstract class AbstractService implements ServiceInterface
{
    protected $className = '';
    protected $validationRules = [];

    /**
     * Parameters to construct, model name and validation rules to create or update
     */
    public function __construct(string $className, array $validationRules)
    {
        $this->className = $className;
        $this->validationRules = $validationRules;
    }

    /**
     * Get all if no id is given or id = 0, otherwise find by id
     */
    public function get(int $id = 0)
    {
        if ($id === 0) {
            return $this->className::all();
        } else {
            return $this->className::findOrFail($id);
        }
    }

    /**
     * Save a model from request validation rules
     * updates if id != 0, creates otherwise
     */
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

    /**
     * Deletes a model given id
     */
    public function delete(int $id): bool
    {
        $entity = $this->get($id);

        return $entity->delete();
    }
}
