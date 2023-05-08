<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BibitMani;
use App\Models\HargaKomoditas;
use App\Models\KomoditasTernak;
use App\Models\MaterialMaster;
use App\Models\Member;
use App\Models\Mission;
use App\Models\Pakan;
use App\Models\Penyedia;
use App\Models\PenyediaMaterial;
use App\Models\pilihPakan;
use App\Models\Product;
use App\Models\ProdukUsaha;
use App\Models\Slider;
use App\Models\Stores;
use App\Models\SubCategory;
use App\Models\Submission;
use App\Models\UPH;
use App\Models\Voucher;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class MissionUserController extends Controller
{


    public function index(Request $request)
    {
        $view = 'myfront.mission.index';
        $now = date('Y-m-d');
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $mission = Mission::where('mission_end_date','>=',$now)
                ->where('mission_name','LIKE','%'.$keyword.'%')
                ->paginate(10);
        }else{
            $mission = Mission::where('mission_end_date','>=',$now)
                ->paginate(10);
        }

        $data = [
            'mission' => $mission,
            'keyword' => $keyword
        ];

        return view($view, $data);
    }

    public function detailMission($id){
        $view = 'myfront.mission.detail_mission';
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }else{
            $user_id = 0;
        }

        $mission = Mission::find(decodeId($id));
        $other_mission =  Mission::inRandomOrder()
            ->limit(5)
            ->get();
        $reward_user = $mission->mission_total_reward / $mission->mission_max_participant;

        $isJoined = Submission::where('mission_id',$mission->mission_id)
            ->where('user_id',$user_id)
            ->first();

        $data = [
            'mission' => $mission,
            'other_mission' => $other_mission,
            'isJoined' => $isJoined,
            'reward_user' => $reward_user,
        ];

        return view($view, $data);
    }

    public function joinMission($id){
        $isJoined = Submission::where('mission_id',decodeId($id))
            ->where('user_id',Auth::user()->id)
            ->first();
        if ($isJoined){
            return $this->detailMission($id);
        }else{
            //cek ketersediaan peserta partisipan
            $mission = Mission::find(decodeId($id));
            $count_submission = Submission::where('mission_id',$mission->mission_id)
                ->count();
            if ($count_submission < $mission->mission_max_participant){
                $data = array(
                    'mission_id' => decodeId($id),
                    'user_id' => Auth::user()->id,
                );
                $insert = Submission::create($data);

                if ($insert){
                    return $this->detailMission($id);
                }else{
                    $msgerror = 'Mohon maaf terjadi kendala saat join mission, coba lagi nanti ';
                    return res500(\request()->ajax(), $msgerror);
                }
            }else{
                $msgerror = 'Mohon maaf, partisipan mission ini sudah penuh';
                return res500(\request()->ajax(), $msgerror);
            }


        }

    }

    public function submission($id){
        $view = 'myfront.mission.send_submission';
        $mission = Mission::find(decodeId($id));
        $submission = Submission::where('mission_id',decodeId($id))
            ->where('user_id',Auth::user()->id)
            ->first();

        $data = [
            'mission' => $mission,
            'submission' => $submission,
        ];

        return view($view, $data);
    }

    public function storeSubmission(Request $request){
        $rule = [
            'mission_id' => 'required',
            'submission_user_socmed_account' => 'required',
            'submission_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'mission_id' => 'nama',
            'submission_user_socmed_account' => 'Akun sosial media yang digunakan',
            'submission_image' => 'foto bukti pengerjaan mission',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $submission = Submission::where('mission_id',decodeId($requestData['mission_id']))
            ->where('user_id',Auth::user()->id)
            ->first();
        if ($request->hasFile('submission_image')) {
            $requestData['submission_image'] = StoreFileWithFolder($request->file('submission_image'), 'public', 'submission');
        }

        $data_update = array(
          'submission_status' => "submitted",
          'submission_image' => $requestData['submission_image'],
          'submission_user_socmed_account' => $requestData['submission_user_socmed_account']
        );
        $update = $submission->update($data_update);

        if ($update){
            return $this->submission(decodeId($requestData['mission_id']));
        }else{
            $msgerror = 'Mohon maaf terjadi kendala saat menyimpan submission, coba lagi nanti ';
            return res500(\request()->ajax(), $msgerror);
        }
    }



}
