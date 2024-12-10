<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Industry;
use App\Models\Internship;
use App\Models\Student;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2): float
{
    $earthRadius = 6371 * 1000;

    $latFrom = deg2rad($lat1);
    $lonFrom = deg2rad($lon1);
    $latTo = deg2rad($lat2);
    $lonTo = deg2rad($lon2);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $a = sin($latDelta / 2) * sin($latDelta / 2) +
        cos($latFrom) * cos($latTo) *
        sin($lonDelta / 2) * sin($lonDelta / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
}

class StudentController extends Controller
{
    public function home()
    {
        $student = Auth::guard('api')->user()->profile;
        return response()->json([
            'message' => 'get data success',
            'data' => [
                'total_hadir' => count(Attendance::where('student_id', $student->id)->where('status', 'present')->get()),
                'total_izin' => count(Attendance::where('student_id', $student->id)->where('status', 'leave')->get()),
                'total_alfa' => count(Attendance::where('student_id', $student->id)->where('status', 'absent')->get()),
                'total_tugas_selesai' => count(Task::where('student_id', $student->id)->where('is_done', true)->get()),
                'data_user' => $student,
            ]
        ], 200);
    }
    // public function absence(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'latitude' => 'required',
    //         'longitude' => 'required'
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'Invalid input',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }
    //     //can beress
    // }

    public function updateStudent(Request $request)
    {
        $student = Auth::guard('api')->user();
        User::where('id', $student->id)->update([
            'password' => $request->password
        ], 200);
    }
    public function task(Request $request)
    {
        $user = Auth::guard('api')->user()->profile;
        if ($request->date) {
            $task = Task::where('student_id', $user->id)->where('created_at', $request->date)->get();
        } else {
            $task = Task::where('student_id', $user->id)->get();
        }
        if ($task) {
            return response()->json([
                'message' => 'Get success',
                'task' => $task
            ], 200);
        } else {
            return response()->json([
                'message' => 'Id Student or created_at not found'
            ], 404);
        }
    }
    public function setings()
    {
        $student = Auth::guard('api')->user()->profile;
        return response()->json([
            'messagee' => 'Get data success',
            'data_user' => $student
        ], 200);
    }
    public function getProfile()
    {
        $student = Auth::guard('api')->user()->profile;
        return response()->json([
            'message' => "Get profile success",
            'data_profile' => $student
        ], 200);
    }
    //test
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => ['mimes:jpeg,png'],
            'birth_day' => ['date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }

        $student = Auth::guard('api')->user()->profile;
        Student::where('id', $student->id)->update($request);
        return response()->json([
            'message' => "Get profile success",
            'data_profile' => $student
        ], 200);
    }
    public function getStudent()
    {
        $user = Auth::guard('api')->user();
        return response()->json([
            'message' => 'Get student success',
            'data_student' => $user
        ], 200);
    }
    public function absence(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            // 'student_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'face_image' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $siswa = Auth::guard('api')->user()->profile;
        $monitoring = Internship::where('student_id', $siswa->id)->first();
        $industri = Industry::where('id', $monitoring->industry_id)->first();
        $distance = getDistanceBetweenPoints($industri->latitude, $industri->longitude, $request->latitude, $request->longitude);
        if ($distance > 10) {
            return response()->json([
                'message' => 'Anda berada di luar zona kehadiran',
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'distances' => round($distance, 2) . ' M',
            ], 403);
        }

        if ($request->file('face_image')) {
            $file_name = $siswa->nisn.'_'.Carbon::now().'_absence.'.$request->file('face_image')->getClientOriginalExtension();
            $request->file('face_image')->storeAs('absence', $file_name);
        }

        Attendance::create([
            'student_id' => $siswa->id,
            'description' => $request->description ? $request->description : null,
            'status' => 'present',
            'face_image' => $file_name,
            'distance' => round($distance, 2). ' M',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        $absen = Attendance::orderBy('created_at', 'desc')->where('student_id', $siswa->id)->first();
        return response()->json([
            'success' => true,
            'distances' => round($distance, 2). ' M',
            'absen' => $absen,
        ], 201);
    }

    public function history()
    {
        $student = Auth::guard('api')->user()->profile;
        $absence = Attendance::where('student_id', $student->id)->get();
        return response()->json([
            'message' => 'Get History success',
            'absence' => $absence
        ]);
    }

    // public function absensiPulang(Request $request)
    // {
    //     $user_id = auth()->guard('api')->user();
    //     $id_user = $user_id->id;
    //     $siswa = Siswa::where('id_user', $id_user)->first();
    //     $id_siswa = $siswa->id;
    //     $monitoring = Monitoring::where('id_siswa', $id_siswa)->first();
    //     $id_industri = $monitoring->id_industri;
    //     $industri = Industri::where('id', $id_industri)->first();
    //     $latitude = $industri->latitude;
    //     $longitude = $industri->longitude;
    //     $alamat = $industri->alamat;

    //     $point1 = ([
    //         "latitude" => $latitude,
    //         "longitude" => $longitude
    //     ]);
    //     $point2 = ([
    //         "latitude" => $request->latitude,
    //         "longitude" => $request->longitude
    //     ]);
    //     $distance = getDistanceBetweenPoints($point1['latitude'], $point1['longitude'], $point2['latitude'], $point2['longitude']);
    //     $distances = $distance['meters'];

    //     $user = User::where([
    //         'login_token' => $request->token
    //     ])->first();
    //     if ($request->token == null || !$user) {
    //         return response()->json([
    //             'message' => 'Unauthorization User'
    //         ], 401);
    //     } else {
    //         $mode = $request->mode;
    //         $tokenMasuk = TokenKeluar::orderBy('created_at', 'desc')->first();
    //         $currentTime = Carbon::now('Asia/Jakarta');

    //         if ($mode == "Lokasi") {
    //             if ($distances > 1000) {
    //                 return response()->json([
    //                     'message' => 'Anda berada di luar zona kehadiran',
    //                     'latitude' => $point2['latitude'],
    //                     'longitude' => $point2['longitude'],
    //                     'distances' => $distances,
    //                 ], 403);
    //             }
    //         }

    //         if ($mode == "Token") {
    //             if ($request->token_masuk != $tokenMasuk->token_masuk) {
    //                 return response()->json([
    //                     'message' => 'Token tidak sesuai!'
    //                 ], 401);
    //             }

    //             if ($currentTime > $tokenMasuk->kadaluarsa_pada) {
    //                 return response()->json([
    //                     'message' => 'Token expired!'
    //                 ], 404);
    //             }
    //         }
    //         $validator = Validator::make($request->all(), [
    //             'jam_pulang' => 'required',
    //         ]);
    //         if ($validator->fails()) {
    //             return response()->json($validator->errors(), 422);
    //         }
    //         $absensi = Absensi::where('id_siswa', $id_siswa)

    //             ->where('tanggal', $request->tanggal)
    //             ->first();
    //         if (!$absensi) {
    //             return response()->json([
    //                 'message' => 'Absensi masuk belum dilakukan hari ini'
    //             ], 400);
    //         }
    //         $absenPulang = Absensi::where('id_siswa', $id_siswa)
    //             ->where('tanggal', $request->tanggal)
    //             ->update([
    //                 'jam_pulang' => $request->jam_pulang
    //             ]);
    //         if ($absenPulang) {
    //             return response()->json([
    //                 'message' => 'Absensi pulang berhasil diupdate',
    //                 'absensi' => $absenPulang
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => "Absen pulang gagal di update"
    //             ], 409);
    //         }
    //     }
    // }

    // public function dashboard(Request $request,$id){

    //         $user = User::where('id', $id)->first();
    //         $id_user = $user->id;
    //         $siswa = Siswa::where('id_user',$id_user)->with('kelas')->first();
    //         $id_siswa = $siswa->id;
    //         $Kehadiran_hadir = Absensi::where('id_siswa',$id_siswa)->where('status','hadir')->count();
    //         $Kehadiran_izin = Absensi::where('id_siswa',$id_siswa)->where('status','izin')->count();
    //         $Kehadiran_sakit = Absensi::where('id_siswa',$id_siswa)->where('status','sakit')->count();
    //         $kegiatan = Kegiatan::where('id_siswa',$id_siswa)->get();
    //         $total_menit = $kegiatan->sum('durasi');
    //         $total_jam = floor($total_menit / 60);
    //         $remaining_menit = $total_menit % 60;
    //         if ($siswa) {
    //             $siswaWithFoto =[
    //                 'name' => $siswa->name,
    //                 'kelas' => $siswa->kelas->kelas,
    //                 'foto' => $siswa->foto ? asset('storage/' . $siswa->foto) : null,
    //             ];
    //             return response()->json([
    //                 'siswa'=>$siswaWithFoto,
    //                 'hadir'=>$Kehadiran_hadir,
    //                 'izin'=>$Kehadiran_izin,
    //                 'sakit'=>$Kehadiran_sakit,
    //                 'total_jam_kerja' => [
    //                     'jam' => $total_jam,
    //                     'menit' => $remaining_menit,
    //                 ],
    //             ],200);
    //         }else{
    //             return response()->json([
    //                 'message' => 'User not found'
    //             ],404);
    //         }


    // }

    // public function show(Request $request, $id)
    // {
    //     $user = User::where([
    //         'login_token' => $request->token
    //     ])->first();
    //     if ($request->token == null || !$user) {
    //         return response()->json([
    //             'message' => 'Unauthorization User'
    //         ], 401);
    //     } else {
    //         $user = User::where('id', $id)->first();
    //         $id_user = $user->id;
    //         $siswa = Siswa::where('id_user', $id_user)->first();
    //         $id_siswa = $siswa->id;
    //         $kehadiran = Absensi::where('id_siswa', $id_siswa)->where('status', 'hadir')->orderBy('tanggal', 'desc')->get();
    //         return response()->json([
    //             'kehadiran' => $kehadiran,
    //             'kehadiran' => $kehadiran
    //         ], 200);
    //     }
    // }
}
