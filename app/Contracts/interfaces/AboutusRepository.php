<?php

namespace App\Contracts\Interfaces;

interface AboutusRepository
{
    public function getAll();
    public function create(array $aboutusRequest);
    public function show(\App\Models\Aboutus $aboutus);
    public function delete(\App\Models\Aboutus $aboutus);
    public function update(array $aboutusRequest, \App\Models\Aboutus $aboutus);
}
