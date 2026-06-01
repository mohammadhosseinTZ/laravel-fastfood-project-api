<?php

namespace App\Repositories;

use App\Contracts\Interfaces\SliderRepository;
use App\Models\Slider;
use App\Models\Truck;

class SliderRepositoryImp implements SliderRepository
{
    public function getAll()
    {
        return Slider::latest()->paginate(2);
    }
    public function create(array $sliderRequest)
    {
        return Slider::create($sliderRequest);
    }
    public function update(Slider $slider, array $sliderUpdateRequest)
    {
        $slider->update($sliderUpdateRequest);
        return $slider;
    }
    public function show(Slider $slider)
    {
        return $slider;
    }
    public function delete(Slider $slider)
    {
        $slider->delete();
        return $slider;
    }
}
