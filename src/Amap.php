<?php

namespace Ofancn\Amap;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Amap extends Field {

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'amap';

    public function initLocation($latitude, $longitude) {
        return $this->withMeta([
                    'lat' => $latitude,
                    'lng' => $longitude,
        ]);
    }

    public function zoom($zoom) {
        return $this->withMeta([
                    'zoom' => $zoom
        ]);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute) {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = json_decode($request[$requestAttribute], true);
        }
    }

}
