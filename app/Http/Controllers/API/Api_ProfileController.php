<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageProfileRequest;
use App\Http\Requests\Api\TransactionRequest;
use App\Models\Language;
use App\Models\Package;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class Api_ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $id = auth()->user()->id;
        $user = User::where('id', $id)->with(['subscriptions', 'profile', 'languages'])->get();
        $userprofile = Profile::where('user_id', $id)->first();
        $userlangs = Language::where('user_id', $id)->get();

        if ($user->isEmpty()) {
            $response = [
                'status' => true,
                'message' => 'this user dose not exist',
            ];
            return response()->json($response, 404);
        }
        $response = [
            'status' => true,
            'message' => 'this is all data profile',
            'data' => [
                'user' => $user,
                'userprofile' => $userprofile,
                'userlangs' => $userlangs,
            ],
        ];
        return response()->json($response, 200);
    }

    public function editprofile(Request $request, $id)
    {
        //return response()->json($request->get('profile', []), 200);
        $idNow = auth()->user()->id;

        $user = User::where('id',  $idNow)->get();
        $userprofile = Profile::where('user_id', $idNow)->first();
        $userlangs = Language::where('user_id', $idNow)->get();

        if (!$user) {
            $response = [
                'status' => true,
                'message' => 'this user dose not exist',
                'data' => $user,
            ];
            return response()->json($response, 404);
        }

        // Get the data to update from the request
        $dataToUpdate = $request->all();
        $profileToUpdate = $request->get('profile', []);
        $languageToUpdate = $request->get('language', []);
        //return response()->json($languageToUpdate, 200);

        // Iterate through the data and update the user
        foreach ($dataToUpdate as $key => $value) {
            // Check if the key exists as a column in the user table
            if (array_key_exists($key, $user->getAttributes())) {
                $user->$key = $value;
            }
        }

        if (!$userprofile) {
            $userprofile = Profile::create([
                'user_id' => $user->id,
                'name_en' =>  $profileToUpdate['name_en'],
                'birthdate' =>  $profileToUpdate['birthdate'],
                'whatsapp' =>  $profileToUpdate['whatsapp'],
                // 'image' =>  $profileToUpdate['image'],
                'nationality' =>  $profileToUpdate['nationality'],
                'residence_country' =>  $profileToUpdate['residence_country'],
            ]);
        } else {
            foreach ($profileToUpdate as $key => $value) {
                if (array_key_exists($key, $userprofile->getAttributes())) {
                    $userprofile->$key = $value;
                }
            };
            $userprofile->save();
        }

        if ($userlangs->isEmpty()) {
            foreach ($languageToUpdate as $language) {
                Language::create([
                    'user_id' => $user->id,
                    'name' => $language["name"],
                    'level' => $language["level"]
                ]);
            };
        } else {
            Language::where('user_id', $id)->forceDelete();
            /* foreach ($languageToUpdate as $key => $value) {
                if (array_key_exists($key, $userlang->getAttributes())) {
                    $userlang->$key = $value;
                }
            };
            $userlang->save(); */
            foreach ($languageToUpdate as $language) {
                Language::create([
                    'user_id' => $user->id,
                    'name' => $language['name'],
                    'level' => $language['level'],
                ]);
            }
        }

        $user->save();

        $response = [
            'status' => true,
            'message' => 'this is all data profile',
            'data' => [
                'user' => $user,
                'profile' => $userprofile
            ],
        ];
        return response()->json($response, 200);
    }
    public function changeImageProfile(ImageProfileRequest $request)
    {
        //return response()->json($request->get('profile', []), 200);

        $user = auth()->user();

        if (!$user) {
            $response = [
                'status' => true,
                'message' => 'this user dose not exist',
                'data' => $user,
            ];
            return response()->json($response, 404);
        }

        // Get the data to update from the request
        $dataToUpdate = $request->except('image');

        $file = $request->file('image');
        $file_name = time() . '-' . rand(5, 100) . rand(5, 100) .  '-' . $file->getClientOriginalName();
        $path = $file->move(public_path('storage/uploads/category-image'), $file_name);
        $file_name = 'uploads/category-image/' . $file_name;

        $dataToUpdate['image'] = $file_name;

        $user->update($dataToUpdate);

        $response = [
            'status' => true,
            'message' => 'this is all data profile',
            'data' => [
                'user' => $user,
            ],
        ];
        return response()->json($response, 200);
    }

    public function getForms(Request $request)
    {
        $forms = auth()->user()->forms;

        $response = [
            'status' => true,
            'message' => 'this is all data forms',
            'data' => $forms,
        ];
        return response()->json($response, 200);
    }
    public function subscribeNow(TransactionRequest $request)
    {
        $user = auth()->user();

        $package = Package::find($request->package_id);

        if (!$package) {
            $response = [
                'status' => false,
                'message' => 'الباقة غير موجودة',
            ];
            return response()->json($response, 400);
        }

        $user->subscriptions()->create([
            'package_id' => $package->id,
            'start_at' => now(),
            'end_at' => now()->addMonth($package->duration)->format('Y-m-d H:i:s'),
        ]);

        $user->transactions()->create([
            'price' => $package->price,
            'status' => $request->status,
            'bank_name' => $request->bank_name,
        ]);

        $user->update([
            'package_id' => $package->id,
            'package_start_at' => now(),
            'package_end_at' => now()->addMonth($package->duration)->format('Y-m-d H:i:s'),
        ]);

        $response = [
            'status' => true,
            'message' => 'تم الاشتراك بنجاح',
        ];

        return response()->json($response, 200);
    }
    public function myPackage()
    {
        $user = auth()->user();

        if (!$user->package) {
            $response = [
                'status' => false,
                'message' => 'لا توجد باقه',
            ];
            return response()->json($response, 400);
        }

        $reponse = [
            'name' => $user->package->name,
            'advantages_fixed' => 'مدة الاشتراك ' . $user->package->duration . ' اشهر ',
            'advantages' => $user->package->advantages,
            'package_start_at' => $user->package_start_at->format('M D, Y'),
            'package_end_at' => $user->package_end_at->format('M D, Y'),
        ];

        return response()->json($reponse, 200);
    }
    public function myTransaction()
    {
        $transactions = auth()->user()->transactions;

        if (!$transactions->isNotEmpty()) {
            $response = [
                'status' => false,
                'message' => 'لا توجد معاملات',
            ];
            return response()->json($response, 400);
        }

        $response = [];
        foreach ($transactions as $key => $transaction) {
            $response[] = [
                'price' => $transaction->price . '$',
                'bank_name' => $transaction->bank_name,
                'status' => $transaction->status,
                'created_at' => $transaction->created_at->format('m-d-Y'),
            ];
        }

        return response()->json($response, 200);
    }
}
