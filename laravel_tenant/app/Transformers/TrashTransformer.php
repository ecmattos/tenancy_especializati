<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Trash;

/**
 * Class TrashTransformer.
 *
 * @package namespace App\Transformers;
 */
class TrashTransformer extends TransformerAbstract
{
    /**
     * Transform the Trash entity.
     *
     * @param \App\Entities\Trash $model
     *
     * @return array
     */
    public function transform(Trash $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
