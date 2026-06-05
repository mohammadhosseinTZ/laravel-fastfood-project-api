<?php

namespace App\Repositories;

use App\Contracts\Interfaces\AboutusRepository;
use App\Models\Aboutus;

class AboutusRepositoryImp implements AboutusRepository
{
    public function getAll()
    {
        return Aboutus::all();
    }
    public function show(Aboutus $aboutus)
    {
        return $aboutus;
    }
    public function create(array $aboutusRequest)
    {
        return Aboutus::create($aboutusRequest);
    }
    public function delete(Aboutus $aboutus)
    {
        $aboutus->delete();
        return $aboutus;
    }
    public function update(array $aboutusRequest, Aboutus $aboutus)
    {
        $aboutus->update($aboutusRequest);
        return $aboutus;
    }
}
