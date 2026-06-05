<?php
namespace App\Contracts\Interfaces;

interface FeatureRepository{
    public function getAll();
    public function create(array $featureRequest);
    public function show(\App\Models\Feature $feature);
    public function update(\App\Models\Feature $feature , array $featureRequest);
    public function delete(\App\Models\Feature $feature);
}