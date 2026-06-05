<?php

namespace App\Repositories;

use App\Contracts\Interfaces\FeatureRepository;
use App\Models\Feature;

class FeatureRepositoryImp implements FeatureRepository
{
    public function getAll()
    {
        return Feature::latest()->paginate(2);
    }
    public function create(array $featureRequest)
    {
        return Feature::create($featureRequest);
    }
    public function update(Feature $feature, array $featureUpdateRequest)
    {
        $feature->update($featureUpdateRequest);
        return $feature;
    }
    public function show(Feature $feature)
    {
        return $feature;
    }
    public function delete(Feature $feature)
    {
        $feature->delete();
        return $feature;
    }
}
