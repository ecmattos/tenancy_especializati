<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use App\Entities\Material;

/**
 * Class MaterialTransformer.
 *
 * @package namespace App\Transformers;
 */
class MaterialTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'material_unit'
    ];
    
    /**
     * Transform the Material entity.
     *
     * @param \App\Entities\Material $material
     *
     * @return array
     */
    public function transform(Material $material)
    {
        return [
            'id' => (int) $material->id,

            'material_code' => $material->code,
            'material_descripion' => $material->description,
            'material_unit_id' => $material->material_unit_id,

            /* place your other model properties here */

            'created_at' => $material->created_at,
            'updated_at' => $material->updated_at
        ];
    }

    public function includeMaterialUnit(Material $material)
    {
        return $this->item($material->material_unit, new MaterialUnitTransformer());
    }
}
