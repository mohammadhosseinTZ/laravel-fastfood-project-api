<?php

namespace App\Contracts\Interfaces;

interface SliderRepository
{
    public function getAll();
    public function create(array $sliderRequest);
    public function show(\App\Models\Slider $slider);
    public function update(\App\Models\Slider $slider, array $sliderRequest);
    public function delete(\App\Models\Slider $slider);
}
