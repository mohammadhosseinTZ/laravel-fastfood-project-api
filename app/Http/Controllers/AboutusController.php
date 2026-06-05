<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AboutusRepository;
use App\Http\Requests\AboutusRequest;
use App\Http\Resources\AboutusResource;
use App\Models\Aboutus;

class AboutusController extends ApiController
{
    protected $aboutusRepository;

    public function __construct(AboutusRepository $aboutusRepository)
    {
        $this->aboutusRepository = $aboutusRepository;
    }
    public function store(AboutusRequest $aboutusRequest)
    {
        $result = $this->aboutusRepository->create($aboutusRequest->validated());
        return $this->successResponse(new AboutusResource($result), 200, 'ok');
    }
    public function show(Aboutus $aboutus)
    {
        $result = $this->aboutusRepository->show($aboutus);
        return $this->successResponse(new AboutusResource($result), 200, 'ok');
    }
    public function index()
    {
        $result = $this->aboutusRepository->getAll();
        return $this->successResponse(AboutusResource::collection($result), 200, 'ok');
    }
    public function destroy(Aboutus $aboutus)
    {
        $this->aboutusRepository->delete($aboutus);
        return $this->successResponse(new AboutusResource($aboutus), 200, 'ok');
    }
    public function update(Aboutus $aboutus, AboutusRequest $aboutusRequest)
    {
        $result = $this->aboutusRepository->update($aboutusRequest->validated(), $aboutus);
        return $this->successResponse(new AboutusResource($result), 200, 'ok');
    }
}
