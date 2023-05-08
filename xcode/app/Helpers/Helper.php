<?php


use App\Models\Penyedia;
use App\Models\Settings;
use App\Models\UserHasRole;
use App\Services\hideyoriService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Vinkla\Hashids\Facades\Hashids;

if (!function_exists('assetku')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function assetku($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}
if (!function_exists('activeMenu')) {
    function activeMenu($uri = '')
    {
        $active = '';

        if (Request::is($uri . '/*') || Request::is($uri)) {
            $active = 'active';
        }
        return $active;
    }
}

if (!function_exists('activeOpen')) {
    function activeOpen($uri = '')
    {
        $active = '';

        if (Request::is($uri . '/*') || Request::is($uri)) {
            $active = 'menu-open';
        }
        return $active;
    }
}

if (!function_exists('activeMenuSeg1')) {
    function activeMenuSeg1($uri = '')
    {
        $active = '';

        if (Request::is($uri)) {
            $active = 'active';
        }
        return $active;
    }
}

if (!function_exists('activeSegment')) {
    function activeSegment($uri = '')
    {
        $active = '';

        if (Request::is($uri)) {
            $active = 'active';
        }
        return $active;
    }
}


if (!function_exists('getImage')) {
    function getImage($path, $image, $name)
    {
        if ($image) {
            return url($path . '/' . $image);
        } else {
            return 'https://ui-avatars.com/api/?background=random&name=' . $name;
        }
    }
}

if (!function_exists('getActiveLabel')) {
    function getActiveLabel($active)
    {
        $data = [
            'icon' => 'fa fa-times',
            'color' => 'danger',
            'teks' => 'TIDAK AKTIF'
        ];
        if ($active == 'aktif') {
            $data = [
                'icon' => 'fa fa-check',
                'color' => 'success',
                'teks' => 'AKTIF'
            ];
        }
        return $data;
    }
}
if (!function_exists('getActiveLabel2')) {
    function getActiveLabel2($active)
    {
        $data = [
            'icon' => 'fa fa-times',
            'color' => 'danger',
            'teks' => 'TIDAK AKTIF'
        ];
        if ($active == true) {
            $data = [
                'icon' => 'fa fa-check',
                'color' => 'success',
                'teks' => 'AKTIF'
            ];
        }
        return $data;
    }
}
if (!function_exists('getActiveLabel3')) {
    function getActiveLabel3($active)
    {
        $data = [
            'icon' => 'fa fa-times',
            'color' => 'danger',
            'teks' => 'TIDAK AKTIF'
        ];
        if ($active == '1') {
            $data = [
                'icon' => 'fa fa-check',
                'color' => 'success',
                'teks' => 'AKTIF'
            ];
        }
        return $data;
    }
}

if (!function_exists('getActiveLabelTeks')) {
    function getActiveLabelTeks($value, $teks1, $teksNon1)
    {
        $data = [
            'icon' => 'fa fa-times',
            'color' => 'danger',
            'teks' => $teksNon1
        ];
        if ($value == $teks1) {
            $data = [
                'icon' => 'fa fa-check',
                'color' => 'success',
                'teks' => $teks1
            ];
        }
        return $data;
    }
}

if (!function_exists('pilihButtonAjaxDT')) {
    function pilihButtonAjaxDT($id, $option = [], $text = null, $clickable = 'clickable-pilih')
    {
        $opsi = '';
        if ($option != []) {
            foreach ($option as $ed => $val) {
                $opsi .= $ed . '="' . $val . '" ';
            }
        }
        $aksiPilih = '';
        if ($id) {
            $aksiPilih = '<a href="javascript:void(0)" title="PILIH" '
                . $opsi . '
            class="'.$clickable.' btn btm-default btn-sm text-primary"><i class="fas fa-angle-down"></i> ' . $text . '</a>';
        }

        return $aksiPilih;
    }
}

if (!function_exists('getImageIconThumb')) {
    function getImageIconThumb($icon)
    {
        if ($icon) {
            return url('uploads/thumbnail/' . $icon);
        } else {
            return url('uploads/noicon.png');
        }
    }
}

if (!function_exists('getImageIcon')) {
    function getImageIcon($icon)
    {
        if ($icon) {
            return url('uploads/' . $icon);
        } else {
            return url('uploads/noicon.png');
        }
    }
}


if (!function_exists('activeSide')) {
    function activeSide($uri = '')
    {
        $active = '';

        if (Request::is($uri . '/*') || Request::is($uri)) {
            $active = 'active';
        }
        return $active;
    }
}
if (!function_exists('ganti_titik_ke_koma')) {
    function ganti_titik_ke_koma($angka)
    {
        return str_replace(".", ",", $angka);
    }
}
if (!function_exists('format_angka_indo')) {
    function format_angka_indo($angka)
    {
        $rupiah = number_format($angka, 0, ',', '.');
        return $rupiah;
    }
}
if (!function_exists('rubah_tanggal_indo')) {
    function rubah_tanggal_indo($format_tgl)
    {
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $tahun = substr($format_tgl, 0, 4);
        $bulan = substr($format_tgl, 5, 2);
        $tgl = substr($format_tgl, 8, 2);
        $tgl_indonesia = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;

        return $tgl_indonesia;
    }
}
//DATE INDONESIA BY FERI
if (!function_exists('date_indonesian')) {
    function date_indonesian($date, $format = 'd F Y')
    {
        $date = date_create($date);
        $array1 = array('January', 'February', 'March', 'May', 'June', 'July', 'August', 'October', 'December', 'Aug', 'Oct', 'Dec', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $array2 = array('Januari', 'Februari', 'Maret', 'Mei', 'Juni', 'Juli', 'Agustus', 'Oktober', 'Desember', 'Agu', 'Okt', 'Dec', 'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        $new_date = date_format($date, $format);
        $hasil = str_replace($array1, $array2, $new_date);
        return $hasil;
    }
}
if (!function_exists('TanggalIndowaktu')) {
    function TanggalIndowaktu($date)
    {

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 8);
        $result = $tgl . "/" . $bulan . "/" . $tahun . ' ' . $waktu;
        return ($result);
    }
}
if (!function_exists('DateTimeFormatDB')) {
    function DateTimeFormatDB($date)
    {
        if ($date):
            $tahun = substr($date, 6, 4);
            $bulan = substr($date, 3, 2);
            $tgl = substr($date, 0, 2);
            $waktu = substr($date, 11, 8);
            $result = $tahun . "-" . $bulan . "-" . $tgl . ' ' . $waktu;
            return ($result);
        else:
            return false;
        endif;
    }
}
if (!function_exists('DateTimeFormatDB2')) {
    function DateTimeFormatDB2($date)
    {
        if ($date):
            $tahun = substr($date, 6, 4);
            $bulan = substr($date, 3, 2);
            $tgl = substr($date, 0, 2);
            $waktu = substr($date, 11, 5);
            $result = $tahun . "/" . $bulan . "/" . $tgl . ' ' . $waktu;
            return ($result);
        else:
            return false;
        endif;
    }
}

if (!function_exists('TanggalIndo')) {
    function TanggalIndo($date)
    {
        if ($date):
            $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

            $tahun = substr($date, 0, 4);
            $bulan = substr($date, 5, 2);
            $tgl = substr($date, 8, 2);

            $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
            return ($result);
        else:
            return '';
        endif;
    }
}
if (!function_exists('TanggalIndo2')) {
    function TanggalIndo2($date)
    {

        if ($date):
            $tahun = substr($date, 0, 4);
            $bulan = substr($date, 5, 2);
            $tgl = substr($date, 8, 2);

            $result = $tgl . "/" . $bulan . "/" . $tahun;
            return ($result);
        else:
            return '';
        endif;
    }
}
if (!function_exists('BulanTahunAja')) {
    function BulanTahunAja($date)
    {

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);

        $result = $bulan . "/" . $tahun;
        return ($result);
    }
}
if (!function_exists('TanggalAja')) {
    function TanggalAja($date)
    {

        $tgl = substr($date, 8, 2);

        $result = $tgl;
        return ($result);
    }
}
if (!function_exists('ubahformatTgl')) {
    function ubahformatTgl($tanggal)
    {
        if ($tanggal):
            $pisah = explode('/', $tanggal);
            $urutan = array($pisah[2], $pisah[1], $pisah[0]);
            $satukan = implode('-', $urutan);
            return $satukan;
        else:
            return '';
        endif;
    }
}
if (!function_exists('ubahformatTgllurus')) {
    function ubahformatTgllurus($tanggal)
    {
        if ($tanggal):
            $pisah = explode('-', $tanggal);
            $urutan = array($pisah[2], $pisah[1], $pisah[0]);
            $satukan = implode('-', $urutan);
            return $satukan;
        else:
            return '';
        endif;
    }
}

if (!function_exists('assetRoot')) {

    function assetRoot($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}
if (!function_exists('tanggalWaktu')) {
    function tanggalWaktu($tanggal)
    {
        return Carbon::parse($tanggal)->isoFormat('Do MMMM YYYY, h:mm:ss a');
    }
}
if (!function_exists('Respon')) {
    function Respon($data, $status, $pesan, $statusCode)
    {

        $res['status'] = $status;
        $res['pesan'] = $pesan;
        $res['data'] = $data;

        return response()->json($res, $statusCode);
    }
}
if (!function_exists('setImage')) {
    function setImage($file, $dir)
    {
        $file_name = round(microtime(true) * 1000) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $file_name);
        return $file_name;
    }
}
if (!function_exists('tanggalIndo')) {
    function tanggalIndo($tanggal)
    {
        return Carbon::parse($tanggal)->format('d M Y');
    }
}

if (!function_exists('angkaTitikTiga')) {
    function angkaTitikTiga($var)
    {
        return number_format($var, 0, ',', '.');
    }
}
if (!function_exists('arrBulan')) {
    function arrBulan()
    {
        return array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    }
}

if (!function_exists('removeBaseURL')) {
    function removeBaseURL($string)
    {
        return str_replace(url('/'), '', $string);
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        $result = Settings::where('setting_var', $key)->first();
        if ($result) {
            return $result->setting_val;
        } else {
            return '';
        }
    }
}


if (!function_exists('detectDelimiter')) {
    function detectDelimiter($csvFile)
    {
        $delimiters = [";" => 0, "," => 0, "\t" => 0, "|" => 0];

        $handle = fopen($csvFile, "r");
        $firstLine = fgets($handle);
        fclose($handle);
        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($firstLine, $delimiter));
        }

        return array_search(max($delimiters), $delimiters);
    }
}
if (!function_exists('SelisihTanggal')) {
    function SelisihTanggal($start, $end = null)
    {
        if ($start == $end) {
            return 0;
        } else {

            if (!($start instanceof DateTime)) {
                $start = new DateTime($start);
            }

            if ($end === null) {
                $end = new DateTime();
            }

            if (!($end instanceof DateTime)) {
                $end = new DateTime($start);
            }

            $interval = $end->diff($start);
            $doPlural = function ($nb, $str) {
                //return $nb > 1 ? $str . 's' : $str;
                return $nb > 1 ? $str . '' : $str;
            }; // adds plurals

            $format = array();
            if ($interval->y !== 0) {
                $format[] = "%y " . $doPlural($interval->y, "tahun");
            }
            if ($interval->m !== 0) {
                $format[] = "%m " . $doPlural($interval->m, "bulan");
            }
            if ($interval->d !== 0) {
                $format[] = "%d " . $doPlural($interval->d, "hari");
            }
            if ($interval->h !== 0) {
                $format[] = "%h " . $doPlural($interval->h, "jam");
            }
            if ($interval->i !== 0) {
                $format[] = "%i " . $doPlural($interval->i, "menit");
            }
            if ($interval->s !== 0) {
                if (!count($format)) {
                    return "sekitar satu menit yg lalu";
                } else {
                    $format[] = "%s " . $doPlural($interval->s, "detik");
                }
            }

            // We use the two biggest parts
            if (count($format) > 1) {
                $format = array_shift($format) . " , " . array_shift($format);
            } else {
                $format = array_pop($format);
            }

            // Prepend 'since ' or whatever you like
            return $interval->format($format);

        }
    }
}

if (!function_exists('getImageOri')) {
    function getImageOri($image)
    {
        $avatar = asset('statis/noicon.png');
        if ($image) {
            $avatar = asset('files/' . $image);
        }
        return $avatar;
    }
}

if (!function_exists('getImageThumb')) {
    function getImageThumb($image)
    {
        $thumb = asset('statis/noicon.png');
        if ($image) {
//            $checkThumb = str_replace(basename($image), '', $image);
//            $checkThumb = $checkThumb . 'thumbnail/' . basename($image);
//            $thumb = asset('img/' . $checkThumb);
            $thumb = asset('files/' . $image);
            if (file_exists('thumbnail/' . $image)) {
                $thumb = asset('thumbnail/' . $image);
            }

        }
        return $thumb;
    }
}

if (!function_exists('getRoleNameForUser')) {
    function getRoleNameForUser($row)
    {
        $has_role = UserHasRole::leftJoin('role','role.id_role','=','user_has_role.role_id')
            ->join('users','users.id','=','user_has_role.user_id')
            ->where('user_has_role.user_id',$row->id)
            ->first();
        $getRoleNames = $has_role->role_name;
        return $getRoleNames;

    }
}

if (!function_exists('pairGroup')) {
    function pairGroup($labelField, $valueField, $totalField, $countField, $items)
    {
        return $items->each(function ($key, $value) use ($labelField, $valueField, $totalField, $countField) {
            $key->label = $key[$labelField];
            $key->value = $key[$valueField];
            $key->count = $key[$totalField];
            $key->total = $key[$countField];
            return $key;
        })->toArray();
    }
}
if (!function_exists('decodeId')) {
    function decodeId($id)
    {
        try {
            return Hashids::decode($id)[0] ?? $id;
        } catch (ErrorException $e) {
            abort(404);
        }
    }
}

if (!function_exists('saveLogs')) {
    /**
     * @param $modelTouched
     * @param string $messageLog
     * @param string $event
     * @param $data
     * @return void
     */
    function saveLogs($modelTouched, $logName, string $messageLog, string $event, $data = null)
    {
        activity()
            ->performedOn($modelTouched ?? null)
            ->useLog($logName)
            ->causedBy(Auth::user())
            ->withProperties($data)
            ->event($event)
            ->log($messageLog);
    }
}
if (!function_exists('root_path')) {
    function root_path($path = '')
    {
        $pathroot = str_replace('xcode', '', base_path());
        return $pathroot . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}
if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return base_path('..') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}
if (!function_exists('removeFile')) {
    function removeFile($disk, $folder, $filename)
    {
        if (Storage::disk($disk)->exists($folder . '/' . $filename)) {
            Storage::disk($disk)->delete($folder . '/' . $filename);
            if (Storage::disk($disk)->exists($folder . '/thumbs/' . $filename)) {
                Storage::disk($disk)->delete($folder . '/thumbs/' . $filename);
            }
        }
    }
}
if (!function_exists('uploadFile')) {
    function uploadFile($disk, $folder, $fileName, $file, $options = []): string
    {
        if (substr($file->getMimeType(), 0, 5) == 'image' && isset($options['thumb']) && $options['thumb'] || substr($file->getMimeType(), 0, 5) == 'image' && isset($options['resize']) && $options['resize'] != 0) {
            $img = Image::make($file);

            if (isset($options['thumb']) && $options['thumb']) {
                $img->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::disk($disk)->path($folder) . '/thumbs/' . $fileName . '.' . $file->extension(), '60');
            }

            if (isset($options['resize']) && $options['resize'] != 0) {
                $img->resize($options['resize'], null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::disk($disk)->path($folder) . '/' . $fileName . '.' . $file->extension(), '60');
            } else {
                $img->save(Storage::disk($disk)->path($folder) . '/' . $fileName . '.' . $file->extension(), '60');
            }
            // resize the image to a height of 200 and constrain aspect ratio (auto width)
            /*$img->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            });*/
        } else {
            Storage::disk($disk)->putFileAs($folder, $file, $fileName . '.' . $file->extension(), $options);
        }

        if (isset($options['replace']) && $options['replace'] != null) {
            removeFile($disk, $folder, $options['replace']);
        }

        return $fileName . '.' . $file->extension();
    }
}
if (!function_exists('destroyFunction')) {
    function destroyFunction($id, $model, $forceDelete = false)
    {
        DB::beginTransaction();
        try {
            $idDecode = decodeId($id);
            if (useSoftDelete() == false) {
                $data = $model::find($idDecode);
            } else {
                if ($forceDelete) {
                    $data = $model::withTrashed()->find($idDecode);
                } else {
                    $data = $model::find($idDecode);
                }
            }


            if ($data) {
                if (useSoftDelete() == false) {
                    $delete = $data->forceDelete();
                } else {
                    if ($forceDelete) {
                        $delete = $data->forceDelete();
                    } else {
                        $delete = $data->delete();
                    }
                }

                if ($delete) {
                    DB::commit();
                    return $data;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Illuminate\Database\QueryException|\ErrorException|Error $e) {
            DB::rollBack();
            throw new ErrorException($e->getMessage(), $e->getCode());
        }
    }
}
if (!function_exists('file_newname')) {
    function file_newname($path, $your_filename)
    {
        if ($pos = strrpos($your_filename, '.')) {
            $name = substr($your_filename, 0, $pos);
            $ext = substr($your_filename, $pos);
        } else {
            $name = $your_filename;
        }

        $newpath = $path . '/' . $your_filename;
        $tmp_name = $your_filename;
        $uniq_no = 0;
        while (file_exists($newpath)) {
            $tmp_name = $name . '_' . $uniq_no . $ext;
            $newpath = $path . '/' . $tmp_name;
            $uniq_no++;
        }

        return $tmp_name;
    }
}

if (!function_exists('StoreFileWithFolder')) {
    function StoreFileWithFolder($file, $disk, $folder, $opsi = [], $thumb = true)
    {
        $cekFile = substr($file->getMimeType(), 0, 5);
        $nameFileBaru = time() . '.' . $file->extension();
        Storage::disk($disk)->putFileAs($folder, $file, $nameFileBaru);
        if ($file->extension() != 'ico') {
            if ($thumb == true) {
                if ($cekFile == 'image') {
                    if (!is_dir('thumbnail/' . $folder)) {
                        mkdir('thumbnail/' . $folder, 0755, true);
                    }
                    $img = Image::make($file->path());
                    $img->resize(500, 375, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save('thumbnail/' . $folder . '/' . $nameFileBaru);
                }
            }
        }

        if (isset($opsi['replace']) && $opsi['replace'] != null) {
            removeFileFolder($disk, $opsi['replace']);
        }

        return $folder . '/' . $nameFileBaru;
    }
}
if (!function_exists('removeFileFolder')) {
    function removeFileFolder($disk, $filename)
    {
        if (Storage::disk($disk)->exists($filename)) {
            Storage::disk($disk)->delete($filename);
            if (file_exists('thumbnail/' . $filename)) {
                unlink('thumbnail/' . $filename);
            }

        }

    }
}

if (!function_exists('encodeId')) {
    function encodeId($id)
    {
        try {
            return Hashids::encode($id);
        } catch (ErrorException $e) {
            abort(404);
        }
    }
}

if (!function_exists('checkboxRowDT')) {
    function checkboxRowDT($id, $teks = null)
    {
        $aksiCheckbox = '';
        if ($id) {
            $aksiCheckbox = '<div class="custom-control custom-checkbox"><input class="custom-control-input data-check" type="checkbox" id="customCheckbox_' . $id . '" value="' . encodeId($id) . '"><label for="customCheckbox_' . $id . '" class="custom-control-label">' . $teks . '</label></div>';
        }
        return $aksiCheckbox;


    }
}


if (!function_exists('restoreButtonDT')) {
    function restoreButtonDT($id, $function = 'restoreData')
    {
        $aksiRestore = '';
        if ($id) {
            $aksiRestore = '<a href="javascript:void(0)" title="RESTORE" onclick="' . $function . '(' . "'" . encodeId($id) . "'" . ')" class="btn btn-sm  item-restore text-info"><i class="fa fa-undo"></i></a>';
        }
        return $aksiRestore;
    }
}
if (!function_exists('deleteButtonDT')) {
    function deleteButtonDT($id, $function ,$url)
    {
        $aksiDelete = '';
        if ($id) {
            $aksiDelete = '<a href="javascript:void(0)" title="HAPUS" onclick="' . $function . '(' . "'" . encodeId($id) . "'" . ',' . "'" . $url . "'" . ')" class="btn btn-sm  item-delete text-danger"><i class="fa fa-trash"></i></a>';
        }
        return $aksiDelete;
    }
}
if (!function_exists('deleteButtonLinkDT')) {
    function deleteButtonLinkDT($id, $url )
    {
        $aksiDelete = '';
        if ($id) {
            $aksiDelete = '<a href = "' . url($url . '/' . encodeId($id)) . '" title = "Hapus" class="btn btn-sm item-detail text-danger" ><i class="fa fa-trash" ></i ></a > ';
        }
        return $aksiDelete;
    }
}
if (!function_exists('deleteButtonText')) {
    function deleteButtonText($id, $text = 'HAPUS', $function = 'deleteData')
    {
        $aksiDelete = '';
        if ($id) {
            $aksiDelete = '<a href="javascript:void(0)" title="HAPUS" onclick="' . $function . '(' . "'" . encodeId($id) . "'" . ')" title="HAPUS"><small class="text-danger">' . $text . '</small><a>';
        }
        return $aksiDelete;
    }
}
if (!function_exists('editButtonAjaxDT')) {
    function editButtonAjaxDT($id, $option = [], $text = null)
    {
        $opsi = '';
        if ($option != []) {
            foreach ($option as $ed => $val) {
                $opsi .= $ed . '="' . $val . '" ';
            }
        }
        $aksiEdit = '';
        if ($id) {
            $aksiEdit = '<a href="javascript:void(0)" title="UBAH" '
                . $opsi . '
            class="clickable-edit btn btn-sm  item-edit text-success"><i class="fa fa-edit"></i> ' . $text . '</a>';
        }

        return $aksiEdit;
    }
}
if (!function_exists('editButtonDT')) {
    function editButtonDT($id, $url, $text = null)
    {
        $aksiEdit = '';
        if ($id) {
            $aksiEdit = '<a href="' . url($url . '/' . encodeId($id)) . '" title="UBAH"
                            class="btn btn-sm  item-edit text-success"><i class="fa fa-edit"></i> ' . $text . '</a>';
        }
        return $aksiEdit;
    }
}
if (!function_exists('stokHargaButtonDT')) {
    function stokHargaButtonDT($id, $url, $text = null)
    {
        $aksiStokHarga = '';
        if ($id) {
            $aksiStokHarga = '<a href="' . url($url . '/' . encodeId($id)) . '" title="Stok&Harga"
                            class="btn btn-sm  item-stok text-danger"><i class="fa fa-dollar-sign"></i> ' . $text . '</a>';
        }
        return $aksiStokHarga;
    }
}
if (!function_exists('editButtonText')) {
    function editButtonText($id, $url, $text = 'EDIT')
    {
        $aksiEdit = '';
        if ($id) {
            $aksiEdit = '<a href="' . url($url . '/' . encodeId($id)) . '" title="UBAH"><small class="text-success">' . $text . '</small><a>';
        }
        return $aksiEdit;
    }
}
if (!function_exists('editButtonAjaxText')) {
    function editButtonAjaxText($id, $option = [], $text = 'EDIT')
    {
        $opsi = '';
        if ($option != []) {
            foreach ($option as $ed => $val) {
                $opsi .= $ed . '="' . $val . '" ';
            }
        }
        $aksiEdit = '';
        if ($id) {
            $aksiEdit = '<a href="javascript:void(0)" title="UBAH" '
                . $opsi . '
                    class="clickable-edit"><small class="text-success">' . $text . '</small></a>';
        }

        return $aksiEdit;
    }
}
if (!function_exists('detailButtonDT')) {
    function detailButtonDT($id, $url)
    {
        $aksiDetail = '';
        if ($id) {
            $aksiDetail = '<a href = "' . url($url . '/' . encodeId($id)) . '" title = "DETAIL" class="btn btn-sm item-detail text-primary" ><i class="fa fa-list" ></i ></a > ';
        }

        return $aksiDetail;
    }
}
if (!function_exists('detailButtonText')) {
    function detailButtonText($id, $url, $text = 'DETAIL')
    {
        $aksiDetail = '';
        if ($id) {
            $aksiDetail = '<a href = "' . url($url . '/' . encodeId($id)) . '" title = "DETAIL" ><small class="text-primary" > ' . $text . '</small ><a>';
        }
        return $aksiDetail;
    }
}
if (!function_exists('acceptButtonDT')) {
    function acceptButtonDT($id, $url)
    {
        $aksiAccept = '';
        if ($id) {
            $aksiAccept = '<a href = "' . url($url . '/' . encodeId($id)) . '" title = "ACCEPT" class="btn btn-md item-detail btn-success" ><i class="fa fa-check-circle" ></i ></a > ';
        }

        return $aksiAccept;
    }
}
if (!function_exists('declineButtonDT')) {
    function declineButtonDT($id, $url)
    {
        $aksiDecline = '';
        if ($id) {
            $aksiDecline = '<a href = "' . url($url . '/' . encodeId($id)) . '" title = "DECLINE" class="btn btn-md btn-danger" ><i class="fa fa-ban" ></i ></a > ';
        }

        return $aksiDecline;
    }
}

if (!function_exists('max_upload_file')) {
    function max_upload_file()
    {

        return env('SIZE_MAX_UPLOAD_FILE', 2048);
    }
}
if (!function_exists('max_upload_image')) {
    function max_upload_image()
    {

        return env('SIZE_MAX_UPLOAD_IMAGE', 2048);
    }
}
if (!function_exists('permission_file')) {
    function permission_file()
    {

        return 'pdf';
    }
}
if (!function_exists('permission_image')) {
    function permission_image()
    {

        return 'png,jpg,gif,JPG,jpeg,JPEG,ico';
    }
}

if (!function_exists('change_event_name')) {
    function change_event_name($eventName)
    {
        return str_replace(['created', 'updated', 'deleted', 'restored'], ['telah dibuat', 'telah diperbarui', 'telah dihapus', 'telah dikembalikan ke dalam data'], $eventName);

    }
}
if (!function_exists('respon200')) {
    function respon200($message = 'berhasil', $redirect = null)
    {
        $msg['title'] = 'BERHASIL';
        $msg['status'] = true;
        $msg['tipe'] = 'success';
        $msg['message'] = $message;
        Session::flash('feedback', $msg);
        if ($redirect != null) {
            return redirect($redirect)->withInput();
        } else {
            return back();
        }
    }
}
if (!function_exists('respon403')) {
    function respon403($message = 'tidak diizinkan', $redirect = null)
    {
        $msg['title'] = 'INFO';
        $msg['status'] = true;
        $msg['tipe'] = 'warning';
        $msg['message'] = $message;
        Session::flash('feedback', $msg);
        if ($redirect != null) {
            return redirect($redirect)->withInput();
        } else {
            return back();
        }
    }
}
if (!function_exists('respon500')) {
    function respon500($message = 'gagal', $redirect = null)
    {
        $msg['title'] = 'GAGAL';
        $msg['status'] = false;
        $msg['tipe'] = 'error';
        $msg['message'] = $message;
        Session::flash('feedback', $msg);
        if ($redirect != null) {
            return redirect($redirect)->withInput();
        } else {
            return back();
        }
    }
}

if (!function_exists('ajaxrespon200')) {
    function ajaxrespon200($message = 'berhasil')
    {
        $msg['title'] = 'BERHASIL';
        $msg['status'] = true;
        $msg['tipe'] = 'success';
        $msg['message'] = $message;
        return response()->json($msg, 200);
    }
}


if (!function_exists('ajaxrespon403')) {
    function ajaxrespon403($message = 'tidak diizinkan')
    {
        $msg['title'] = 'INFO';
        $msg['status'] = true;
        $msg['tipe'] = 'warning';
        $msg['message'] = $message;
        return response()->json($msg, 200);
    }
}

if (!function_exists('ajaxrespon500')) {
    function ajaxrespon500($message = 'gagal')
    {

        $msg['title'] = 'GAGAL';
        $msg['status'] = false;
        $msg['tipe'] = 'error';
        $msg['message'] = $message;
        return response()->json($msg, 500);
    }
}

if (!function_exists('res200')) {
    function res200($ajax = false, $msg = null, $redirect = null)
    {

        if ($ajax == true) {
            return ajaxrespon200($msg);
        } else {
            return respon200($msg, $redirect);
        }
    }
}

if (!function_exists('res500')) {
    function res500($ajax = false, $msg = null, $redirect = null)
    {

        if ($ajax == true) {
            return ajaxrespon500($msg);
        } else {
            return respon500($msg, $redirect);
        }
    }
}

if (!function_exists('res403')) {
    function res403($ajax = false, $msg = null, $redirect = null)
    {

        if ($ajax == true) {
            return ajaxrespon403($msg);
        } else {
            return respon403($msg, $redirect);
        }
    }
}

if (!function_exists('destroyData')) {
    function destroyData($model, $id, $context = null, $force = false)
    {

        try {
            $myService = new hideyoriService();
            if ($force == false) {
                $myService->delete($model, $id, false);
            } else {
                $myService->delete($model, $id, true);
            }

        } catch (\ErrorException $e) {
            $msgerror = $e->getMessage() ?? 'gagal hapus ' . $context;
            return res500(\request()->ajax(), $msgerror);
        }
        $msgsukses = 'berhasil hapus ' . $context;
        return res200(\request()->ajax(), $msgsukses);
    }
}

if (!function_exists('destroyBulk')) {
    function destroyBulk($model, $id, $context = null, $force = false)
    {
        try {
            $myService = new hideyoriService();
            if ($force == false) {
                $myService->deleteBulk($model, $id, false);
            } else {
                $myService->deleteBulk($model, $id, true);
            }
        } catch (\ErrorException $e) {
            $msgerror = $e->getMessage() ?? 'gagal hapus ' . $context;
            return res500(\request()->ajax(), $msgerror);
        }
        $msgsukses = 'berhasil hapus ' . $context . ' yang dipilih';
        return res200(\request()->ajax(), $msgsukses);
    }
}

if (!function_exists('storeData')) {
    function storeData($model, $requestData, $context = null, $return = true, $redirect = null)
    {
        try {
            $myService = new hideyoriService();
            $create = $myService->create($model, $requestData);
        } catch (QueryException|\ErrorException $e) {
            $msgerror = $e->getMessage() ?? 'gagal tambah ' . $context;
            return res500(\request()->ajax(), $msgerror);
        }
        if ($return == true) {
            $msgsuccess = 'berhasil tambah ' . $context;
            return res200(\request()->ajax(), $msgsuccess, $redirect);
        } else {
            return $create;
        }

    }
}

if (!function_exists('storeDataNoReturn')) {
    function storeDataNoReturn($model, $requestData, $context = null)
    {
        try {
            $myService = new hideyoriService();
            $create = $myService->create($model, $requestData);
        } catch (QueryException|\ErrorException $e) {
            $msgerror = $e->getMessage() ?? 'gagal tambah ' . $context;
            return res500(\request()->ajax(), $msgerror);
        }
        return $create;
    }
}
if (!function_exists('updateData')) {
    function updateData($master, $requestData, $context = null, $return = true, $redirect = null)
    {
        try {
            $myService = new hideyoriService();
            $update = $myService->update($master, $requestData);
        } catch (QueryException $e) {
            $msgerror = $e->getMessage() ?? 'gagal perbarui ' . $context;
            return res500(\request()->ajax(), $msgerror);
        }

        if ($return == true) {
            $msgsuccess = 'berhasil perbarui ' . $context;
            return res200(\request()->ajax(), $msgsuccess, $redirect);
        } else {
            return $update;
        }
    }
}
if (!function_exists('updateDataNoReturn')) {
    function updateDataNoReturn($master, $requestData, $context = null)
    {
        try {
            $myService = new hideyoriService();
            $update = $myService->update($master, $requestData);
        } catch (QueryException $e) {
            $msgerror = $e->getMessage() ?? 'gagal perbarui ' . $context;
            return res500(\request()->ajax(), $msgerror);
        }
        return $update;
    }
}
if (!function_exists('restoreData')) {
    function restoreData($master, $context = null, $return = true)
    {
        try {
            $myService = new hideyoriService();
            $update = $myService->restore($master);
        } catch (QueryException $e) {
            $msgerror = $e->getMessage() ?? 'gagal restore ' . $context;
            return res500(\request()->ajax(), $msgerror);
        }

        if ($return == true) {
            $msgsuccess = 'berhasil restore ' . $context;
            return res200(\request()->ajax(), $msgsuccess);
        } else {
            return $update;
        }
    }
}
if (!function_exists('restoreBulk')) {
    function restoreBulk($model, $id, $context = null)
    {
        try {
            $myService = new hideyoriService();
            foreach ($id as $x) {
                $master = $myService->find($model, decodeId($x), true);
                $myService->restore($master);
            }
        } catch (\ErrorException $e) {
            $msgerror = $e->getMessage() ?? 'gagal hapus ' . $context;
            return res500(\request()->ajax(), $msgerror);
        }
        $msgsukses = 'berhasil hapus ' . $context . ' yang dipilih';
        return res200(\request()->ajax(), $msgsukses);
    }
}
if (!function_exists('getLastWord')) {
    function getLastWord($string)
    {
        $string = explode(' ', $string);
        $last_word = array_pop($string);
        return $last_word;
    }
}
if (!function_exists('removeLastWord')) {
    function removeLastWord($string)
    {
        $words = explode(" ", $string);
        array_splice($words, -1);
        return implode(" ", $words);
    }
}
if (!function_exists('isActive')) {
    function isActive($value)
    {
        $res = '<span class="badge bg-label-danger">NON AKTIF</span>';
        if ($value == 1) {
            $res = '<span class="badge bg-label-success">AKTIF</span>';
        }
        return $res;

    }
}
if (!function_exists('changerStatus')) {
    function changerStatus($id, $value, $teks1 = 'Aktif', $teks0 = 'Non Aktif', $deleted_at = null, $izin = true)
    {
        $checked = $value == 1 ? 'checked' : '';
        $keterangan = $value == 1 ? $teks1 : $teks0;
        $encode = encodeId($id);
        $disabled = 'disabled';
        $changer_status = '';

        if ($deleted_at == null) {
            if ($izin == true) {
                $disabled = '';
                $changer_status = 'changer-status';
            }
        }


        $switch = '<div class="form-group"><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input ' . $changer_status . '" name="changecheckbox" data-id="' . $encode . '" data-value="' . $value . '"  id="customSwitch' . $id . '" ' . $checked . ' ' . $disabled . '><label class="custom-control-label label-status' . $value . '" for="customSwitch' . $id . '">' . $keterangan . '</label></div></div>';

        return $switch;

    }
}

if (!function_exists('changerStatus2')) {
    function changerStatus2($id, $value, $teks1 ='1', $teks0='Non 1', $deleted_at = null, $izin = true)
    {
        $checked = $value == $teks1 ? 'checked' : '';
        $keterangan = $value == $teks1 ? strtoupper($teks1) : strtoupper($teks0);
        $encode = encodeId($id);
        $disabled = 'disabled';
        $changer_status = '';

        if ($deleted_at == null) {
            if ($izin == true) {
                $disabled = '';
                $changer_status = 'changer-status';
            }
        }


        $switch = '<div class="form-group"><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input ' . $changer_status . '" name="changecheckbox" data-id="' . $encode . '" data-value="' . $value . '"  id="customSwitch' . $id . '" ' . $checked . ' ' . $disabled . '><label class="custom-control-label label-status' . $value . '" for="customSwitch' . $id . '">' . $keterangan . '</label></div></div>';

        return $switch;

    }
}

if (!function_exists('changerStatus3')) {
    function changerStatus3($id, $value, $teks1 ='1', $teks0='Non 1', $deleted_at = null, $izin = true)
    {

        $checked = $value == "1" ? 'checked' : '';

        $keterangan = $value == "1" ? strtoupper($teks1) : strtoupper($teks0);
        $encode = encodeId($id);
        $disabled = 'disabled';
        $changer_status = '';

        if ($deleted_at == null) {
            if ($izin == true) {
                $disabled = '';
                $changer_status = 'changer-status';
            }
        }


        $switch = '<div class="form-group"><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input ' . $changer_status . '" name="changecheckbox" data-id="' . $encode . '" data-value="' . $value . '"  id="customSwitch' . $id . '" ' . $checked . ' ' . $disabled . '><label class="custom-control-label label-status' . $value . '" for="customSwitch' . $id . '">' . $keterangan . '</label></div></div>';

        return $switch;

    }
}

if (!function_exists('changerStatus4')) {
    function changerStatus4($id, $value, $teks1 ='1', $teks0='Non 1', $deleted_at = null, $izin = true)
    {

        $checked = $value == true ? 'checked' : '';

        $keterangan = $value == true ? strtoupper($teks1) : strtoupper($teks0);
        $encode = encodeId($id);
        $disabled = 'disabled';
        $changer_status = '';

        if ($deleted_at == null) {
            if ($izin == true) {
                $disabled = '';
                $changer_status = 'changer-status';
            }
        }


        $switch = '<div class="form-group"><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input ' . $changer_status . '" name="changecheckbox" data-id="' . $encode . '" data-value="' . $value . '"  id="customSwitch' . $id . '" ' . $checked . ' ' . $disabled . '><label class="custom-control-label label-status' . $value . '" for="customSwitch' . $id . '">' . $keterangan . '</label></div></div>';

        return $switch;

    }
}

if (!function_exists('updateStatus')) {
    function updateStatus($model, $id, $nilai, $dibalik = true, $banyak = false)
    {

        $ubahvalue = $nilai;
        if ($dibalik == true) {
            $ubahvalue = $nilai == 1 ? 0 : 1;
        }

        DB::beginTransaction();
        try {
            $myService = new hideyoriService();
            //$master = $myService->find($model, $decodeId);
            if ($banyak == false) {
                $decodeId = decodeId($id);
                $myService->statusBulk($model, [$decodeId], $ubahvalue);
            } else {
                foreach ($id as $x) {
                    $decodeId = decodeId($x);
                    $myService->statusBulk($model, [$decodeId], $ubahvalue);
                }
            }

            //saveLogs($master, $model::FIELDSTATUS, $model::FIELDSTATUS.' '. $master->name . ' updated', 'updated', $master);
        } catch (\ErrorException $e) {
            DB::rollBack();
            $msgerror = $e->getMessage() ?? 'gagal perbarui data';
            return res500(\request()->ajax(), $msgerror);
        }

        DB::commit();
        $msgsuccess = 'berhasil perbarui data';
        return res200(\request()->ajax(), $msgsuccess);
    }
}

if (!function_exists('updateStatus3')) {
    function updateStatus3($model, $id, $nilai, $dibalik = true, $banyak = false)
    {

        $ubahvalue = $nilai;
        if ($dibalik == true) {
            $ubahvalue = $nilai == true ? false : true;
        }
        //$ubahvalue = $nilai == true ? false : true;

        DB::beginTransaction();
        try {
            $myService = new hideyoriService();
            //$master = $myService->find($model, $decodeId);
            if ($banyak == false) {
                $decodeId = decodeId($id);
                $myService->statusBulk($model, [$decodeId], $ubahvalue);
            } else {
                foreach ($id as $x) {
                    $decodeId = decodeId($x);
                    $myService->statusBulk($model, [$decodeId], $ubahvalue);
                }
            }

            //saveLogs($master, $model::FIELDSTATUS, $model::FIELDSTATUS.' '. $master->name . ' updated', 'updated', $master);
        } catch (\ErrorException $e) {
            DB::rollBack();
            $msgerror = $e->getMessage() ?? 'gagal perbarui data';
            return res500(\request()->ajax(), $msgerror);
        }

        DB::commit();
        $msgsuccess = 'berhasil perbarui data';
        return res200(\request()->ajax(), $msgsuccess);
    }
}

if (!function_exists('updateStatus2')) {
    function updateStatus2($model, $id, $nilai, $dibalik = true, $banyak = false, $teks0 = 'Non 1', $teks1 = '1')
    {

        $ubahvalue = $nilai;
        if ($dibalik == true) {
            $ubahvalue = $nilai == $teks1 ? $teks0 : $teks1;
        }

        DB::beginTransaction();
        try {
            $myService = new hideyoriService();
            //$master = $myService->find($model, $decodeId);
            if ($banyak == false) {
                $decodeId = decodeId($id);
                $myService->statusBulk($model, [$decodeId], $ubahvalue);
            } else {
                foreach ($id as $x) {
                    $decodeId = decodeId($x);
                    $myService->statusBulk($model, [$decodeId], $ubahvalue);
                }
            }

            //saveLogs($master, $model::FIELDSTATUS, $model::FIELDSTATUS.' '. $master->name . ' updated', 'updated', $master);
        } catch (\ErrorException $e) {
            DB::rollBack();
            $msgerror = $e->getMessage() ?? 'gagal perbarui data';
            return res500(\request()->ajax(), $msgerror);
        }

        DB::commit();
        $msgsuccess = 'berhasil perbarui data';
        return res200(\request()->ajax(), $msgsuccess);
    }
}


if (!function_exists('xhasRole')) {
    function xhasRole($role)
    {
        if (Auth::check()) {
            //return Auth::user()->hasRole($role);
            return Auth::user()->hasRole($role);
        }
        return false;
    }
}

if (!function_exists('xhasPermission')) {
    function xhasPermission($permission)
    {
        if (Auth::check()) {
            return Auth::user()->can($permission);
        }
        return false;
    }
}


if (!function_exists('useSoftDelete')) {
    function useSoftDelete()
    {
        return env('SOFTDELETE', false);
    }
}

if (!function_exists('checkSoftDelete')) {
    function checkSoftDelete()
    {
        if (useSoftDelete() == false) {
            $msgerror = 'tidak diizinkan akses fungsi grup soft delete';
            return res500(\request()->ajax(), $msgerror);
        }
    }
}

if (!function_exists('cekIzin')) {
    function cekIzin($row, $permission)
    {
        if (xhasRole(['superadmin', 'admin'])) {
            return true;
        } else {
            if (xhasPermission($permission)) {
                if ($row->created_by == Auth::user()->id) {
                    return true;
                }
            }
        }
        return false;
    }
}

if (!function_exists('itemCreated')) {
    function itemCreated($model, $kondisi = false)
    {

        $tableUser = 'users_login';
        $IdUser = 'id_users';
        $data = $model::join($tableUser, $model::TABLE . '.created_by', '=', $tableUser . '.' . $IdUser)->leftJoin('ktp', 'ktp.nik', '=', $model::tableUser . '.nik');
        if ($kondisi == true) {
            $data->where('created_by', Auth::user()->id);
        }
        $list = $data->pluck('created_by', $tableUser . '.nama')->all();
        return $list ?? [];
    }
}

if (!function_exists('rubah_input_angka_indo')) {
    function rubah_input_angka_indo($angka)
    {

        $res = 0;
        if ($angka) {
            $res = str_replace(array('.', ',', ' '), array('', '.', ''), $angka);
        }

        return $res;
    }
}


if (!function_exists('bulkHash')) {
    function bulkHash($model, $id, $fieldhash = 'idhash', $banyak = true)
    {


        DB::beginTransaction();
        try {
            $myService = new hideyoriService();
            //$master = $myService->find($model, $decodeId);
            if ($banyak == false) {
                $decodeId = decodeId($id);
                $master = $myService->find($model, $decodeId);
                $makeHash = random_strings(10);
                $requestData[$fieldhash] = $makeHash;
                $myService->update($master, $requestData);
            } else {
                foreach ($id as $x) {
                    $decodeId = decodeId($x);
                    $master = $myService->find($model, $decodeId);
                    $makeHash = random_strings(10);
                    $requestData[$fieldhash] = $makeHash;
                    $myService->update($master, $requestData);
                }
            }

            //saveLogs($master, $model::FIELDSTATUS, $model::FIELDSTATUS.' '. $master->name . ' updated', 'updated', $master);
        } catch (\ErrorException $e) {
            DB::rollBack();
            $msgerror = $e->getMessage() ?? 'gagal perbarui data';
            return res500(\request()->ajax(), $msgerror);
        }

        DB::commit();
        $msgsuccess = 'berhasil hashing data';
        return res200(\request()->ajax(), $msgsuccess);
    }
}


// This function will return
// A random string of specified length
if (!function_exists('random_strings')) {
    function random_strings($length_of_string)
    {
        // return substr(sha1(time()), 0, $length_of_string);
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),
            0, $length_of_string);
    }
}

if (!function_exists('check_role')) {
    function check_role($roles)
    {
        $access = auth()->user()->access;
        if ($access == 'admin') {
            return true;
        }
        $roles = explode('|', $roles);
        $userRoles = auth()->user()->role->pluck('nama_role');
        if (count($userRoles) > 0) {
            $check = $userRoles->contains(function ($item, $key) use ($roles) {
                if (in_array($item, $roles)) {
                    return true;
                }
            });
            if ($check) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
if (!function_exists('hasRole')) {
    function hasRole($array)
    {
//        if ($this->whereAccess('sup'))
        return Auth::user()->whereHas('role', function ($q) use ($array) {
            $q->whereIn('nama_role', $array);
        })->exists();
    }
}
if (!function_exists('unlessRole')) {
    function unlessRole($array)
    {
        return Auth::user()->whereHas('role', function ($q) use ($array) {
            $q->whereIn('role_name', $array);
        })->doesntExist();
    }
}
if (!function_exists('cekRole_admin_gudang_ternak')) {
    function cekRole_admin_gudang_ternak()
    {

        if (Auth::check()) {
            if (in_array(Auth::user()->access, ['superadmin', 'admin_gudang_ternak'])) {
                if (Auth::user()->active == '1') {
                    return true;
                }
                return false;
            }
            return false;
        } else {
            return false;
        }
    }
}

if (!function_exists('getMemberId')) {
    function getMemberId()
    {
        $id_member = null;
        $getMemberId = \App\Models\Member::where('nik', Auth::user()->nik)->first();
        if ($getMemberId) {
            $id_member = $getMemberId->id_member;
        }
        return $id_member;
    }
}

if (!function_exists('getSektorID')) {
    function getSektorID($word = 'peternakan')
    {

        $sektor_id = 0;
        $getSektorId = \App\Models\Sektor::where('sektor', 'ILIKE', '%' . $word . '%')->first();
        if ($getSektorId) {
            $sektor_id = $getSektorId->id;
        }
        return $sektor_id;
    }
}

if (!function_exists('getRolePelakuUsaha')) {
    function getRolePelakuUsaha($word = 'pelaku')
    {

        $role_id = 0;
        $getRoleId = \App\Models\Role::where('nama_role', 'ILIKE', '%' . $word . '%')->first();
        if ($getRoleId) {
            $role_id = $getRoleId->id_role;
        }
        return $role_id;
    }
}

if (!function_exists('getDistributorId')) {
    function getDistributorId()
    {
        $jenis_penyedia = [];
        $getJenisPenyedia = \App\Models\JenisPenyedia::where('penyedia_level_status', true)->whereIn('penyedia_level_nama', ['distributor', 'Distributor', 'DISTRIBUTOR'])->first();
        if ($getJenisPenyedia) {
            $jenis_penyedia = $getJenisPenyedia->penyedia_level_id;
        }
        return $jenis_penyedia;
    }
}

if (!function_exists('getRoleKarantina')) {
    function getRoleKarantina()
    {
        $getRole = DB::table('role')->whereIn('nama_role', ['karantina', 'Karantina', 'KARANTINA'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;

        } else {
            DB::beginTransaction();
            try {
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'nama_role' => 'Karantina',
                    'keterangan' => 'Petugas karantina ternak'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();

            $idRole = $create->id_role;
        }
        return $idRole;
    }
}

if (!function_exists('getRoleGudang')) {
    function getRoleGudang()
    {
        $getRole = DB::table('role')->whereIn('nama_role', ['gudang', 'Gudang', 'GUDANG'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;

        } else {
            DB::beginTransaction();
            try {
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'nama_role' => 'Gudang',
                    'keterangan' => 'Petugas warehouse ternak'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();

            $idRole = $create->id_role;
        }
        return $idRole;
    }
}

if (!function_exists('getRoleDistributor')) {
    function getRoleDistributor()
    {
        $getRole = DB::table('role')->whereIn('nama_role', ['distributor', 'Distributor', 'DISTRIBUTOR'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;

        } else {
            DB::beginTransaction();
            try {
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'nama_role' => 'Distributor',
                    'keterangan' => 'Stakeholder Distributor'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();

            $idRole = $create->id_role;
        }
        return $idRole;
    }
}

if (!function_exists('getRolePoultryshop')) {
    function getRolePoultryshop()
    {
        $getRole = DB::table('role')->whereIn('nama_role', ['poultryshop', 'Poultryshop', 'POULTRYSHOP'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;
        } else {
            DB::beginTransaction();
            try {
                //$idRole = $create->id_role;
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'nama_role' => 'Poultryshop',
                    'keterangan' => 'Stakeholder Poultryshop'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();
            $idRole = $create->id_role;
        }
        return $idRole;
    }
}

if (!function_exists('getPoultryshopId')) {
    function getPoultryshopId()
    {
        $jenis_penyedia = [];
        $getJenisPenyedia = \App\Models\JenisPenyedia::where('penyedia_level_status', true)->whereIn('penyedia_level_nama', ['poultryshop', 'Poultryshop', 'POULTRYSHOP'])->first();
        if ($getJenisPenyedia) {
            $jenis_penyedia = $getJenisPenyedia->penyedia_level_id;
        }
        return $jenis_penyedia;
    }
}

if (!function_exists('getRoleAdminGudter')) {
    function getRoleAdminGudter()
    {
        $getRole = DB::table('role')->where('nama_role', ['Admin Gudter'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;
        } else {
            DB::beginTransaction();
            try {
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'nama_role' => 'Admin Gudter',
                    'keterangan' => 'Admin Gudang Ternak'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();
            $idRole = $create->id_role;
        }
        return $idRole;
    }
}

if (!function_exists('getRoleAdmin')) {
    function getRoleAdmin()
    {
        $getRole = DB::table('role')->where('role_name', ['admin'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;
        } else {
            DB::beginTransaction();
            try {
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'role_name' => 'admin',
                    'role_description' => 'Role admin sistem'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();
            $idRole = $create->id_role;
        }
        return $idRole;
    }
}
if (!function_exists('getRoleSuperadmin')) {
    function getRoleSuperadmin()
    {
        $getRole = DB::table('role')->where('role_name', ['superadmin'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;
        } else {
            DB::beginTransaction();
            try {
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'role_name' => 'superadmin',
                    'role_description' => 'Role superadmin sistem'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();
            $idRole = $create->id_role;
        }
        return $idRole;
    }
}
if (!function_exists('getRoleStore')) {
    function getRoleStore()
    {
        $getRole = DB::table('role')->where('role_name', ['store'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;
        } else {
            DB::beginTransaction();
            try {
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'role_name' => 'store',
                    'role_description' => 'Role user dengan akses store'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();
            $idRole = $create->id_role;
        }
        return $idRole;
    }
}
if (!function_exists('getRoleUserBiasa')) {
    function getRoleUserBiasa()
    {
        $getRole = DB::table('role')->where('role_name', ['user'])->first();
        if ($getRole) {
            $idRole = $getRole->id_role;
        } else {
            DB::beginTransaction();
            try {
                //$idRole = DB::table('role')->insertGetId([
                $create = \App\Models\Role::create([
                    'role_name' => 'user',
                    'role_description' => 'Role user dengan akses biasa'
                ]);
            } catch (ErrorException $e) {
                DB::rollBack();
                throw new ($e->getMessage());
            }
            DB::commit();
            $idRole = $create->id_role;
        }
        return $idRole;
    }
}

if (!function_exists('aksiButton')) {
    function aksiButton($btn = '')
    {
        $aksi = '<span class="badge badge-warning"><i class="fa fa-lock"></i> TERKUNCI</span>';
        if ($btn) {
            $aksi = '<div class="btn-group" role="group" aria-label="First group">' . $btn . '</div>';
        }
        return $aksi;


    }
}


if (!function_exists('permission_file_impor')) {
    function permission_file_impor()
    {

        return 'xls,xlsx,csv,txt';
    }
}

if (!function_exists('cekRoleAkses')) {
    function cekRoleAkses($pilihanRole)
    {

        if (Auth::check()) {
            if ($pilihanRole == 'admin') {
                $checkakses = DB::table('user_has_role')->where([['role_id', getRoleAdmin()], ['user_id', Auth::user()->id]])->count();
            }else if ($pilihanRole == 'superadmin') {
                $checkakses = DB::table('user_has_role')->where([['role_id', getRoleSuperadmin()], ['user_id', Auth::user()->id]])->count();
            } else if ($pilihanRole == 'store') {
                $checkakses = DB::table('user_has_role')->where([['role_id', getRoleStore()], ['user_id', Auth::user()->id]])->count();
            } else if ($pilihanRole == "user") {
                $checkakses = DB::table('user_has_role')->where([['role_id', getRoleUserBiasa()], ['user_id', Auth::user()->id]])->count();
            }

            if ($checkakses > 0) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }
}

if (!function_exists('getPakanId')) {
    function getPakanId()
    {
        $getPakanId = [];
        $Pakan = DB::table('master_kategori')->whereIn('kategori', ['Pakan', 'pakan', 'PAKAN'])->first();
        if ($Pakan) {
            $getPakanId = $Pakan->id;
        }
        return $getPakanId;
    }
}


if (!function_exists('getListDistributor')) {
    function getListDistributor()
    {
        $getPakanId = [];
        $Pakan = DB::table('master_kategori')->whereIn('kategori', ['Pakan', 'pakan', 'PAKAN'])->first();
        if ($Pakan) {
            $getPakanId = $Pakan->id;
        }
        return $getPakanId;

        $member_id = Auth::user()->member->id;

        $data = Penyedia::where('jenispenyedia_id', getPoultryshopId())
            ->where('member_id', $member_id)
            ->orderBy('nama', 'ASC')->limit(100)->get();

        return response()->json($data);
    }
}

if (!function_exists('getGudang')) {
    function getGudang($gudangId)
    {
        $gudang = \App\Models\Gudang::find($gudangId);

        return $gudang;
    }
}
