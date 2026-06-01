<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\SliderRepository;
use App\Http\Requests\SliderRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends ApiController
{
    private $sliderRepository;
    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }
    public function store(SliderRequest $sliderRequest)
    {
        $imageName = Carbon::now()->microsecond . '-' . $sliderRequest->image->getClientOriginalName();
        $sliderRequest->image->storeAs("images/sliders", $imageName, 'public');

        $sliders = $this->sliderRepository->create($sliderRequest->validated());
        return $this->successResponse(new SliderResource($sliders), 201, 'ok');
    }

    public function index()
    {
        return $this->successResponse(
            [
                "sliders" => SliderResource::collection($this->sliderRepository->getAll()),
                "links" => SliderResource::collection($this->sliderRepository->getAll())->response()->getData()->links,
                "meta" => SliderResource::collection($this->sliderRepository->getAll())->response()->getData()->meta
            ],
            200,
            'ok'
        );
    }
    public function show(Slider $slider)
    {
        return $this->successResponse(new SliderResource($this->sliderRepository->show($slider)), 200, 'ok');
    }

    public function update(Slider $slider, SliderUpdateRequest $sliderUpdateRequest)
    {

        if ($sliderUpdateRequest->has('image') && $sliderUpdateRequest->image !== null) {
            Storage::delete('images/sliders/' . $slider->image);

            $imageName = Carbon::now()->microsecond . '-' . $sliderUpdateRequest->image->getClientOriginalName();
            $sliderUpdateRequest->image->storeAs("images/sliders", $imageName, 'public');
        }

        $sliders = $this->sliderRepository->update($slider, [
            "title" => $sliderUpdateRequest->title,
            "body" => $sliderUpdateRequest->body,
            "image" => $sliderUpdateRequest->image == null ? $slider->image : $imageName,
            "link_title" => $sliderUpdateRequest->link_title,
            "link_address" => $sliderUpdateRequest->link_address
        ]);

        return $this->successResponse(new SliderResource($sliders), 201, 'ok');
    }

    public function destroy(Slider $slider)
    {
        Storage::delete('images/sliders/' . $slider->image);

        return $this->successResponse(new SliderResource($this->sliderRepository->delete($slider)), 200, 'ok');
    }
}
