<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\FeatureRepository;
use App\Http\Requests\FeatureRequest;
use App\Http\Requests\FeatureUpdateRequest;
use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureController extends ApiController
{
    protected $featureRepository;
    public function __construct(FeatureRepository $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }

    public function store(FeatureRequest $featureRequest)
    {
        $imageName = Carbon::now()->microsecond . '-' . $featureRequest->icon->getClientOriginalName();
        $featureRequest->icon->storeAs("images/features", $imageName, 'public');

        $features = $this->featureRepository->create($featureRequest->validated());
        return $this->successResponse(new FeatureResource($features), 201, 'ok');
    }

    public function index()
    {
        return $this->successResponse(
            [
                "Features" => FeatureResource::collection($this->featureRepository->getAll()),
                "links" => FeatureResource::collection($this->featureRepository->getAll())->response()->getData()->links,
                "meta" => FeatureResource::collection($this->featureRepository->getAll())->response()->getData()->meta
            ],
            200,
            'ok'
        );
    }
    public function show(Feature $feature)
    {
        return $this->successResponse(new FeatureResource($this->featureRepository->show($feature)), 200, 'ok');
    }

    public function update(Feature $feature, FeatureUpdateRequest $featureUpdateRequest)
    {

        if ($featureUpdateRequest->has('icon') && $featureUpdateRequest->icon !== null) {
            Storage::delete('images/features/' . $feature->icon);

            $imageName = Carbon::now()->microsecond . '-' . $featureUpdateRequest->icon->getClientOriginalName();
            $featureUpdateRequest->icon->storeAs("images/Features", $imageName, 'public');
        }

        $features = $this->featureRepository->update($feature, [
            "title" => $featureUpdateRequest->title,
            "body" => $featureUpdateRequest->body,
            "icon" => $featureUpdateRequest->icon == null ? $feature->icon : $imageName,

        ]);

        return $this->successResponse(new FeatureResource($features), 201, 'ok');
    }

    public function destroy(Feature $feature)
    {
        Storage::delete('images/features/' . $feature->icon);

        return $this->successResponse(new FeatureResource($this->featureRepository->delete($feature)), 200, 'ok');
    }
}
