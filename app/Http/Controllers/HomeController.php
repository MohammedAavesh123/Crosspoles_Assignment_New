<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use DataTables;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {


        // dd($data);
        if ($request->ajax()) {
            $imageurl = "http://127.0.0.1:8000/storage/uploads/";
            // $data = User::latest()->get();
            $data = DB::table('users as u')
                ->join('countries as c', 'c.id', 'u.country')
                ->join('states as s', 's.id', 'u.state')
                ->join('cities', 'cities.id', 'u.city')
                ->select('u.*', 'c.name as countryname', 's.name as statename', 'cities.name as cityname')
                ->orderBy('u.id', 'desc')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($result) {
                    return ucwords($result->name);
                })
                ->addColumn('email', function ($result) {
                    return $result->email;
                })
                ->addColumn('phone', function ($result) {
                    return $result->phone;
                })
                ->addColumn('country', function ($result) {
                    return $result->countryname;
                })
                ->addColumn('state', function ($result) {
                    return $result->statename;
                })
                ->addColumn('city', function ($result) {
                    return $result->cityname;
                })
                ->addColumn('profile', function ($result) {
                    if ($result->profile != "") {
                        // dd('dsdf');
                        $profile = '<img src="' . 'http://127.0.0.1:8000/storage/uploads/' . $result->profile . '" style="width:50px; height:50px; border-radius:2px;">';
                    } else {
                        // $profile = "test";
                        $profile = '<img src="' . 'http://127.0.0.1:8000/storage/uploads/dummy-user.png' . '" style="width:50px; height:50px; border-radius:2px;">';
                    }
                    return $profile;
                })



                ->rawColumns(['action', 'profile'])

                ->make(true);
        }
        // return view('productAjax');
        // dd('ass');
        $country['countries'] = Country::get(["name", "id"]);
        return view('home', compact('country'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users|max:255',
            'phone' => 'required|numeric|digits:10',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        // $user = new User;

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city

        ];
        $user = new User;
        if ($files = $request->file('avatar')) {
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->storeAs('public/uploads', $profileImage);
            // $path = '/Images/' . $profileImage;
            $details['profile'] = "$profileImage";
        }

        if ($validator->passes()) {
            $product   =   User::updateOrCreate($details);
            // $user->save();
            return response()->json(['success' => 'Added new records.']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function fetchState(Request $request)
    {
        // $data['states'] = State::where("country_id", $request->country_id)
        //     ->get(["name", "id"]);

        $data['states'] = State::where("country_id", $request->country_id)
            ->get(["name", "id"]);
        // return response()->json($data);
        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        // $data['cities'] = City::where("state_id", $request->state_id)
        //     ->get(["name", "id"]);
        $data['cities'] = City::where("state_id", $request->state_id)
            ->get(["name", "id"]);
        return response()->json($data);
    }
}
