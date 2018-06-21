<?php

namespace Yeelight\Transformers;

use Yeelight\Base\Models\BaseModel;
use Yeelight\Base\Transformers\Transformer;

class BaseTransformer extends Transformer
{
    /**
     * Include User.
     *
     * @param BaseModel $model
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(BaseModel $model)
    {
        $user = $model->user;
        if ($user) {
            return $this->item($user, new UserTransformer(), 'user');
        }
    }

    /**
     * Include User.
     *
     * @param BaseModel $model
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthUser(BaseModel $model)
    {
        $user = auth_user();
        if ($user) {
            return $this->item($user, new UserTransformer());
        }
    }
}
