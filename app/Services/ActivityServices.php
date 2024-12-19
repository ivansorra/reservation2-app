<?php

namespace App\Services;

use App\Repositories\ActivityRepository;
use Illuminate\Http\Request;

use App\Traits\ResponseTraits;

use App\Http\Requests\TravelActivityRequest;

use Illuminate\Http\JsonResponse;

class ActivityServices
{
    use ResponseTraits;

    /**
     * Create a new class instance.
     */
    private $activityRepository;

    public function __construct(ActivityRepository $activity)
    {
        $this->activityRepository = $activity;
    }

    public function getAllTravels(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 10;

            $get_travels = $this->activityRepository->getActivities($limit);

            return $this->successResponse($get_travels, 'Successfully retrieved all travel activities', 200);
        } catch (\Exception $e)
        {
            return ResponseTraits::errorResponse($e, 'Error', 400);
        }
    }

    public function getTravelActivity(Request $request)
    {
        try {
            $activity_id = $request->get('activity_id');

            $get_single_activity = $this->activityRepository->getActivity($activity_id);

            return $this->successResponse($get_single_activity, 'Successfully retrieved travel activity', 200);
        } catch (\Exception $e)
        {
            return ResponseTraits::errorResponse($e, 'Error', 400);
        }
    }

    public function createTravelActivity(Request $request, TravelActivityRequest $travelreq)
    {
        try {
            $validate = $travelreq->authorize($request);

            if ($validate instanceof JsonResponse) {
                return $validate;
            }

            $validatedData = $validate->validated();

            // dd($validatedData);

            $create_travel_act = $this->activityRepository->createActivity($validatedData);

            return $this->successResponse($create_travel_act, 'Successfully created new reservation', 200);
        } catch (\Exception $e)
        {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function updateTravelActivity(Request $request, TravelActivityRequest $travelreq)
    {
        try {
            $validate = $travelreq->authorize($request);

            if ($validate instanceof JsonResponse) {
                return $validate;
            }

            $validatedData = $validate->validated();
            $activity_id = $request->get('activity_id');

            $updateTravelActivity = $this->activityRepository->updateActivity($activity_id, $validatedData);

            return $this->successResponse($updateTravelActivity, 'Successfully updated travel activity', 200);
        } catch (\Exception $e){
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function deleteTravelActivity(Request $request)
    {
        try {
            $activity_id = $request->get('activity_id');

            $deleteActivity = $this->activityRepository->deleteActivity($activity_id);

            return $this->successResponse($deleteActivity, 'Successfully deleted travel activity', 200);
        } catch (\Exception $e){
            return $this->errorResponse($e, 'Error', 400);
        }
    }
}
