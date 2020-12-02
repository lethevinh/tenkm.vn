<?php

namespace App\Admin\Forms;
use App\Models\Location;
use Dcat\Admin\Form\Field;

class Address extends Field
{
    /**
     * View for a field to render.
     *
     * @var string
     */
    protected $view = 'admin.form.address';

    public function render()
    {
        $model = $this->form->repository()->eloquent();
        $provincialField = new Field\Select('address.provincial_id', [ __('site.provincial')]);
        $provincialField->options(Location::ofType('provincial')->get()->pluck('title_lb', 'id'))
            ->customFormat(function ($v) {
                if (!$v) return '';
                return array_column($v, 'id');
            })
            ->load('address.district_id', 'api/locations');
        $provincialField->required();
        if ($model->address) {
            $provincialField->value($model->address->provincial_id);
        }
        $districtField = new Field\Select('address.district_id', [ __('site.district')]);
        $districtField->loads(['address.ward_id' , 'address.street_id'], ['api/locations', 'api/locations/street']);

        if ($model->address) {
            $districtField->value($model->address->district_id);
        }
        $wardField = new Field\Select('address.ward_id', [ __('site.ward')]);
        if ($model->address) {
            $wardField->value($model->address->ward_id);
        }
        $streetField = new Field\Select('address.street_id', [ __('site.street')]);
        if ($model->address) {
            $streetField->value($model->address->street_id);
        }
        $locationField = new Field\Map('address.lat_lb', ['address.lng_lb', __('site.location')]);
        if ($model->address) {
            $locationField->value(['lat' => $model->address->lat_lb, 'lng' => $model->address->lng_lb]);
        }
        $mapIframeField = new Field\Text('address.location_lb', [__('site.map_iframe')]);
        if ($model->address) {
            $mapIframeField->value($model->address->location_lb);
        }
        $this->addVariables([
            'provincialField' => $provincialField,
            'districtField' => $districtField,
            'wardField' => $wardField,
            'streetField' => $streetField,
            'locationField' => $locationField,
            'mapIframeField' => $mapIframeField,
        ]);
        return parent::render();
    }
}
