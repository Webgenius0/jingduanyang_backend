<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    use ApiResponse;

    public function getTeam()
    {
        $data = Team::where('status','active')->get();

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Team fetched successfully', 200);
    }

    public function teamDetail($id)
    {
        $date = Team::find($id);

        if (empty($date)) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($date, 'Team fetched successfully', 200);
    }
}
