<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\ManPowerSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PremiumManPowerController extends Controller
{
    public function index()
    {
        $manPowerSchedules = ManPowerSchedule::where('type', 'premium')->where('center_id', Auth::user()->center_id)->orderBy('date', 'DESC')->get();
        return view('Administrator.premiumManPower.index', compact('manPowerSchedules'));
    }

    public function create(){
        $manPowerSchedule = ManPowerSchedule::where('type', 'premium')->where('center_id', Auth::user()->center_id)->orderBy('date', 'DESC')->first();
        $center = auth()->user()->center;
        return view('Administrator.premiumManPower.create', compact('manPowerSchedule','center'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'morningSlotStart' => 'required',
            'morningSlotEnd' => 'required',
            'daySlotStart' => 'required',
            'daySlotEnd' => 'required',
            'timeForPcr' => 'required',
            'timeForVaccine' => 'required',
            'timeForBooster' => 'required',
            'trustedMedicalAssistantForPcr' => 'required',
            'volunteerForVaccine' => 'required',
            'volunteerForBooster' => 'required',
            'fromDate' => 'required',
            'toDate' => 'required',
        ]);

        $avaiable =  get_available_service_per_day(auth()->user()->center->space);
        if ($request->booster_available_set <= $avaiable && $request->pcr_available_set <= $avaiable && $request->vaccine_available_set <= $avaiable) {

            $d1 = strtotime($request->fromDate);
            $d2 = strtotime($request->toDate);
            $totalDiffDays = abs($d1-$d2)/60/60/24;

            $newArray = [];
            for ($i = 0; $i<=$totalDiffDays; $i++) {
                $d = $d1 + $i * (3600*24);
                $newArray[$i] = date("Y-m-d", $d);
                
                $oldManPower = ManPowerSchedule::where('type', 'premium')->where('center_id', Auth::user()->center_id)->where('date', date("Y-m-d", $d))->first();
                if ($oldManPower) {
                    $manPowerSchedule = $oldManPower;
                } else {
                    $manPowerSchedule = new ManPowerSchedule();
                }
            
                $manPowerSchedule->type                     = 'premium';
                $manPowerSchedule->morning_starting_time    = $request->morningSlotStart;
                $manPowerSchedule->morning_ending_time      = $request->morningSlotEnd;
                $manPowerSchedule->day_starting_time        = $request->daySlotStart;
                $manPowerSchedule->day_ending_time          = $request->daySlotEnd;
                $manPowerSchedule->trusted_medical_assistant_for_pcr        = $request->trustedMedicalAssistantForPcr;
                $manPowerSchedule->trusted_medical_assistant_for_vaccine    = $request->volunteerForVaccine;
                $manPowerSchedule->trusted_medical_assistant_for_booster    = $request->volunteerForBooster;
                $manPowerSchedule->date                     = date("Y-m-d", $d);
                $manPowerSchedule->pcr_time                 = $request->timeForPcr;
                $manPowerSchedule->vaccine_time             = $request->timeForVaccine;
                $manPowerSchedule->booster_time             = $request->timeForBooster;
                $manPowerSchedule->booster_available_set    = $request->booster_available_set;
                $manPowerSchedule->vaccine_available_set    = $request->vaccine_available_set;
                $manPowerSchedule->pcr_available_set        = $request->pcr_available_set;
                $manPowerSchedule->center_id                = Auth::user()->center_id;
                $manPowerSchedule->save();      
            }

            return response()->json([
                'type' => 'success',
                'message' => 'Schedule uploaded successfully !',
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'The Space are not available for this schedule!',
            ]);
        }

        
    }

    public function edit($id){
        $manPowerSchedule = ManPowerSchedule::findOrFail($id);
        $center = auth()->user()->center;
        return view('Administrator.premiumManPower.edit', compact('manPowerSchedule','center'));
    }

    public function update(Request $request, $id){


        $request->validate([
            'morningSlotStart' => 'required',
            'morningSlotEnd' => 'required',
            'daySlotStart' => 'required',
            'daySlotEnd' => 'required',
            'timeForPcr' => 'required',
            'timeForVaccine' => 'required',
            'timeForBooster' => 'required',
            'trustedMedicalAssistantForPcr' => 'required',
            'volunteerForVaccine' => 'required',
            'volunteerForBooster' => 'required',
        ]);

        $avaiable =  get_available_service_per_day(auth()->user()->center->space);
        
        if ($request->booster_available_set <= $avaiable && $request->pcr_available_set <= $avaiable && $request->vaccine_available_set <= $avaiable) {
                
            $manPowerSchedule = ManPowerSchedule::findOrFail($id);
            
            $manPowerSchedule->morning_starting_time    = $request->morningSlotStart;
            $manPowerSchedule->morning_ending_time      = $request->morningSlotEnd;
            $manPowerSchedule->day_starting_time        = $request->daySlotStart;
            $manPowerSchedule->day_ending_time          = $request->daySlotEnd;
            $manPowerSchedule->trusted_medical_assistant_for_pcr        = $request->trustedMedicalAssistantForPcr;
            $manPowerSchedule->trusted_medical_assistant_for_vaccine    = $request->volunteerForVaccine;
            $manPowerSchedule->trusted_medical_assistant_for_booster    = $request->volunteerForBooster;
            $manPowerSchedule->pcr_time                 = $request->timeForPcr;
            $manPowerSchedule->vaccine_time             = $request->timeForVaccine;
            $manPowerSchedule->booster_time             = $request->timeForBooster;
            $manPowerSchedule->booster_available_set    = $request->booster_available_set;
            $manPowerSchedule->vaccine_available_set    = $request->vaccine_available_set;
            $manPowerSchedule->pcr_available_set        = $request->pcr_available_set;

            try {
                $manPowerSchedule->save();      
                return response()->json([
                    'type' => 'success',
                    'message' => 'Schedule uploaded successfully !',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Something going wrong. ' . $exception.getMessage(),
                ]);
            }
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'The Space are not available for this schedule!',
            ]);
        }

    }

    public function destroy($id)
    {
        try {
            ManPowerSchedule::findOrFail($id)->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Deleted !!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'error' . $exception->getMessage(),
            ]);
        }
    }
}
