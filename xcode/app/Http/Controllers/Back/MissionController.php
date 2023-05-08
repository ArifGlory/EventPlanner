<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\Store;
use App\Models\LogSaldoPoint;
use App\Models\Mission;
use App\Models\User;
use App\Models\Product;
use App\Models\Stores;
use App\Models\SubCategory;
use App\Models\Submission;
use App\Models\Voucher;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;


class MissionController  extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware(['storeaccess']);
        $this->myService = new hideyoriService();
        $this->context = 'mission';
    }

    public function index()
    {
        $view = 'mypanel.mission.index';

        $data = [

        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        if (cekRoleAkses('store')){
            $data = Mission::where('created_by',Auth::user()->id)
                ->get();
        }else if (cekRoleAkses('superadmin') || cekRoleAkses('admin')){
            $data = Mission::get();
        }

       /* $created_by = $request->get('created_by');
        if ($created_by) {
            $data->where('created_by', $created_by);
        }*/

        /*$jenis_id = $request->get('jenis_id');

        if ($jenis_id) {
            $data->whereIn('voucher.subcategory_id', $jenis_id);
        }*/
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
               /* $izin = '<i class="fas fa-ellipsis-h"></i>';
               if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    $izin = checkboxRowDT($row->mission_id);
                }*/
                $izin = checkboxRowDT($row->mission_id);
                return $izin;
            })
            ->editColumn('mission_total_reward', function ($row) {
                return $row->mission_total_reward ? format_angka_indo($row->mission_total_reward) : '';
            })
            ->editColumn('mission_end_date', function ($row) {
                return $row->mission_end_date ? TanggalIndo($row->mission_end_date) : '';
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->mission_id, 'main/mission/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->mission_id, 'main/mission/edit');
                $aksiHapus = deleteButtonDT($row->mission_id, 'deleteDataTable','mission/delete');

                $izin .= $aksiEdit;
                $izin .= $aksiHapus;
                /*if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    $izin .= $aksiEdit;
                }
                if (cekRoleAkses('superadmin') == true){
                    $izin .= $aksiHapus;
                }*/

                return aksiButton($izin);
            })
            ->escapeColumns([])
            ->toJson();
    }

    public function dataSubmission(Request $request)
    {
        $id = $request->get('mission_id');
        $data = Submission::leftjoin('users', 'users.id', '=', 'mission_submission.user_id')
            ->select('mission_submission.*','users.name')
            ->where('mission_id',decodeId($id))
            ->orderBy('submission_id',"DESC")
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
                /* $izin = '<i class="fas fa-ellipsis-h"></i>';
                if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                     $izin = checkboxRowDT($row->mission_id);
                 }*/
                $izin = checkboxRowDT($row->submission_id);
                return $izin;
            })
            ->editColumn('submission_image', function ($row) {
                $gambar = ' <a href="'.getImageOri($row->submission_image).'" class="image-popup-no-margins">
                                        <img class="profile-user-img img-fluid"
                                             src="'.getImageThumb($row->submission_image).'" alt="mission">
                                        </a>';
                return $gambar;
            })
            ->editColumn('updated_at',function ($row){
                return rubah_tanggal_indo($row->updated_at);
            })
            ->addColumn('action', function ($row) {
                $izin = '';

                if (cekRoleAkses('superadmin') || cekRoleAkses('admin')){
                    if ($row->submission_status == "submitted"){
                        $aksiAccept = acceptButtonDT($row->submission_id, 'main/mission/submission/accept');
                        $izin .= $aksiAccept;

                        $aksiDecline  = declineButtonDT($row->submission_id,'main/mission/submission/decline');
                        $izin .= $aksiDecline;
                    }else if ($row->submission_status == "accepted"){
                        $info = '<h6><span class="badge badge-success">Submission Diterima</span></h6>';
                        $izin .=$info;
                    }else if ($row->submission_status == "waiting"){
                        $info = '<h6><span class="badge badge-primary">Menunggu</span></h6>';
                        $izin .=$info;
                    }else if ($row->submission_status == "declined"){
                        $info = '<h6><span class="badge badge-danger">Ditolak <br> <small>'.$row->submission_decline_reason.'</small> </span></h6>';
                        $izin .=$info;
                    }else if ($row->submission_status == "half-accepted"){
                        $info = '<h6><span class="badge badge-warning">Menunggu Konfirmasi Store</span></h6>';
                        $izin .=$info;
                    }else if ($row->submission_status == "half-declined"){
                        $info = '<h6><span class="badge badge-danger">Ditolak oleh Store <br> <small>'.$row->submission_decline_reason.'</small></span></h6>';
                        $izin .=$info;
                    }
                }else{
                    if ($row->submission_status == "accepted"){
                        $info = '<h6><span class="badge badge-success">Submission Diterima</span></h6>';
                        $izin .=$info;
                    }else if ($row->submission_status == "waiting"){
                        $info = '<h6><span class="badge badge-primary">Menunggu</span></h6>';
                        $izin .=$info;
                    }else if ($row->submission_status == "submitted"){
                        $info = '<h6><span class="badge badge-primary">Bukti dikirim</span></h6>';
                        $izin .=$info;
                    }else if ($row->submission_status == "declined"){
                        $info = '<h6><span class="badge badge-danger">Ditolak <br> <small>'.$row->submission_decline_reason.'</small> </span></h6>';
                        $izin .=$info;
                    }else if ($row->submission_status == "half-accepted"){
                        $aksiAccept = acceptButtonDT($row->submission_id, 'main/mission/submission/accept');
                        $izin .= $aksiAccept;

                        $aksiDecline  = declineButtonDT($row->submission_id,'main/mission/submission/decline');
                        $izin .= $aksiDecline;
                    }else if ($row->submission_status == "half-declined"){
                        $info = '<h6><span class="badge badge-danger">Ditolak oleh Store <br> <small>'.$row->submission_decline_reason.'</span></h6>';
                        $izin .=$info;
                    }

                }

                return aksiButton($izin);
            })
            ->escapeColumns([])
            ->toJson();
    }


    public function form()
    {
        $data = [
            'mode' => 'add',
            'action' => url('main/mission/create'),
            'id' => '',
            'isAlreadyJoined' => false,
            'mission_name' => old('mission_name', ''),
            'mission_total_reward' => old('mission_total_reward', ''),
            //'mission_max_participant' => old('mission_max_participant', ''),
            'mission_reward_peserta' => old('mission_reward_peserta', ''),
            'mission_description' => old('mission_description', ''),
            'mission_image' => old('mission_image', ''),
            'mission_end_date' => old('mission_end_date', ''),

        ];
        $view = 'mypanel.mission.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'mission_name' => 'required',
            'mission_total_reward' => 'required',
            'mission_reward_peserta' => 'required',
            'mission_description' => 'required',
            'mission_end_date' => 'required',
            'mission_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'mission_name' => 'nama',
            'mission_total_reward' => 'total reward sebuah mission',
            'mission_reward_peserta' => 'reward per peserta',
            'mission_description' => 'deskripsi ',
            'mission_end_date' => 'waktu akhir mission',
            'mission_image' => 'foto mission',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->id;

        //To Do
        //cek kepemilikan kredit Point pada akun tsb. apakah cukup, jika iya maka insert ke tbl log saldo point,kemudian Point nya akan dikurangi dan Mission akan otomatis terbuat
        if (Auth::user()->saldo_point < $requestData['mission_total_reward']){
            return res500(false, 'maaf saldo point anda tidak cukup untuk membuat mission ini', 'main/mission/form');
        }
        if ($requestData['mission_reward_peserta'] < 1000){
            return res500(false, 'Reward per peserta minimal 1000 point', 'main/mission/form');
        }
        if ($requestData['mission_total_reward'] < 1){
            return res500(false, 'total reward tidak boleh kosong', 'main/mission/form');
        }

        //simpan ke data log_saldo
        $data_log_saldo = array(
            'user_id' => Auth::user()->id,
            'created_by' => Auth::user()->id,
            'log_saldo_nominal' => $requestData['mission_total_reward'],
            'log_saldo_description' => "saldo point digunakan untuk pembuatan mission ".$requestData['mission_name'],
            'log_saldo_status' => "used",
        );
        LogSaldoPoint::create($data_log_saldo);

        //ubah saldo pengguna
        $user = User::find(Auth::user()->id);
        $new_saldo = $user->saldo_point - $requestData['mission_total_reward'];
        $data_update = array(
            'saldo_point' =>$new_saldo
        );
        $user->update($data_update);

        //hitung max partisipan
        $requestData['mission_max_participant'] = $requestData['mission_total_reward'] / $requestData['mission_reward_peserta'];


        if ($request->hasFile('mission_image')) {
            $requestData['mission_image'] = StoreFileWithFolder($request->file('mission_image'), 'public', 'mission');
        }


        return storeData(Mission::class, $requestData, $this->context, true, 'main/mission');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Mission::class, decodeId($id));
        $isAlreadyJoined = Submission::where('mission_id',$master->mission_id)
            ->count();

        $data =
            [
                'mode' => 'edit',
                'action' => url('main/mission/update/' . $id),
                'id' => $id,
                'isAlreadyJoined' => $isAlreadyJoined,
                'mission_name' => old('mission_name', $master->mission_name),
                'mission_total_reward' => old('mission_total_reward', $master->mission_total_reward),
                'mission_reward_peserta' => old('mission_total_reward', $master->mission_reward_peserta),
                'mission_max_participant' => old('mission_max_participant', $master->mission_max_participant),
                'mission_description' => old('mission_description', $master->mission_description),
                'mission_image' => old('mission_image', $master->mission_image),
                'mission_end_date' => old('mission_end_date', $master->mission_end_date),
            ];

        $view = 'mypanel.mission.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(Mission::class, decodeId($id));
        $isAlreadyJoined = Submission::where('mission_id',$master->mission_id)
            ->count();

        $rule = [
            'mission_name' => 'required',
            'mission_description' => 'required',
            'mission_end_date' => 'required',
            'mission_reward_peserta' => 'required',
            'mission_total_reward' => 'required',
            //'mission_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'mission_name' => 'nama produk',
            'mission_description' => 'deskripsi mission',
            'mission_end_date' => 'waktu akhir mission',
            'mission_reward_peserta' => 'reward per peserta',
            //'mission_image' => 'foto produk',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        //jika udah ada yang join, ga boleh ganti total reward
        if ($isAlreadyJoined > 0){
            unset($requestData['mission_total_reward']);
            unset($requestData['mission_max_participant']);
            unset($requestData['mission_reward_peserta']);
        }else{
            //hitung max partisipan
            $requestData['mission_max_participant'] = $requestData['mission_total_reward'] / $requestData['mission_reward_peserta'];
        }

        $gambar = $master->mission_image;
        if ($request->hasFile('mission_image')) {
            $gambar = StoreFileWithFolder($request->file('mission_image'), 'public', 'mission', ['replace' => $master->mission_image]);
        } else {
            if (isset($request->remove_gambar)) {
                removeFileFolder('public', $master->mission_image);
                $gambar = null;
            }
        }
        $requestData['mission_image'] = $gambar;

        return updateData($master, $requestData, $this->context, true, 'main/mission');
    }

    public function updateStatus(Request $request)
    {

    }

    public function bulkStatus(Request $request)
    {

       /* $id = $request->id;
        $nilai = $request->nilai;
        return updateStatus2(BibitMani::class, $id, $nilai, false, true, 'non aktif', 'aktif');*/
    }

    public function show($id)
    {
        $master = $this->myService->find(Mission::class, decodeId($id));
        $individual_reward = $master->mission_total_reward / $master->mission_max_participant;

        $data =
            [
                'row' => $master,
                'individual_reward' => $individual_reward,
            ];
        $view = 'mypanel.mission.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = Mission::find(decodeId($id));
        //TO DO
        //sebelum dihapus, cek dahulu apakah sudah ada yang join sbg partisipan nya

        $delete = $info->destroy(decodeId($id));
        if($delete) {
            $msgsuccess = 'berhasil hapus data';
            return res200(\request()->ajax(), $msgsuccess);
        } else {
            $msgerror = 'gagal hapus data';
            return res500(\request()->ajax(), $msgerror);
        }
    }

    public function acceptSubmission($submission_id)
    {
        $submission = Submission::find(decodeId($submission_id));

        if ($submission->submission_status == "submitted"){
            //misi baru saja di-submit oleh user, admin acc merubah jadi half-accepted
            //ubah status submission
            $data_update_submission = array(
                'submission_status' => "half-accepted"
            );
            $submission->update($data_update_submission);

            return $this->show(encodeId($submission->mission_id));

        }else if ($submission->submission_status == "half-accepted"){
            //misi telah di-acc oleh admin, tapi belum di acc toko
            //pada tahap ini, misi telah benar2 diterima
            if (cekRoleAkses('store')){
                $mision = Mission::find($submission->mission_id);
                $individual_reward = $mision->mission_reward_peserta;

                //simpan ke data log_saldo
                $data_log_saldo = array(
                    'user_id' => $submission->user_id,
                    'created_by' => Auth::user()->id,
                    'log_saldo_nominal' => $individual_reward,
                    'log_saldo_description' => "mendapatkan reward dari mission ".$mision['mission_name'],
                    'log_saldo_status' => "reward",
                );
                LogSaldoPoint::create($data_log_saldo);

                //ubah saldo pengguna
                $user = User::find($submission->user_id);
                $new_saldo = $user->saldo_point + $individual_reward;
                $data_update = array(
                    'saldo_point' =>$new_saldo
                );
                $user->update($data_update);

                //ubah status submission
                $data_update_submission = array(
                    'submission_status' => "accepted"
                );
                $submission->update($data_update_submission);

                return $this->show(encodeId($submission->mission_id));

            }else{
                $msgerror = 'gagal, fungsi ini hanya dapat dilakukan oleh store';
                return res500(\request()->ajax(), $msgerror);
            }

        }else if ($submission->submission_status == "accepted"){
            //misi sudah di acc
            $msgerror = 'gagal, submission sudah pernah diterima sebelumnya';
            return res500(\request()->ajax(), $msgerror);
        }

    }

    public function declineSubmission($submission_id){
        $submission = Submission::leftjoin('users', 'users.id', '=', 'mission_submission.user_id')
            ->leftjoin('mission', 'mission.mission_id', '=', 'mission_submission.mission_id')
            ->select('mission_submission.*','users.name','mission.mission_name')
            ->where('submission_id',decodeId($submission_id))
            ->first();
        $data = [
            'submission' => $submission,
            'mode' => 'add',
            'action' => url('main/mission/submission/decline/store'),
            'id' => '',
            'submission_decline_reason' => old('submission_decline_reason', ''),
        ];
        $view = 'mypanel.mission.decline_submission';
        return view($view, $data);
    }

    public function storeDeclineSubmission(Request $request){
        $rule = [
            'submission_decline_reason' => 'required',
        ];
        $attributeRule = [
            'submission_decline_reason' => 'Alasan penolakan',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['decline_by'] = Auth::user()->id;

        $submission = Submission::find(decodeId($requestData['submission_id']));
        unset($requestData['submission_id']);
        unset($requestData['_token']);
        if (cekRoleAkses('superadmin') || cekRoleAkses('admin')){
            $requestData['submission_status'] = "declined";
        }else{
            $requestData['submission_status'] = "half-declined";
        }


        $submission->update($requestData);

        return $this->show(encodeId($submission->mission_id));
    }



}
