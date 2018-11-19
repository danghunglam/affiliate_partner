<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Contracts\Repositories\HomeRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $homeRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeRepositoryInterface $homeRepositoryInterface )
    {
        $this->middleware('auth');
        $this->homeRepository = $homeRepositoryInterface;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function download()
    {
        return view('download');
    }

    public function createLink()
    {
        return view('create_link');

    }

    public function getCampaigns(){
        $data = $this->homeRepository->getCampaigns();
//        return view('create_link',['data'=>$data]);
        return response()->json($data);
    }

    public function saveCampaign(Request $request){
        $req = $request->all();
        $data = $this->homeRepository->saveCampaign($req);
        return response()->json($data);
    }

    public function profile()
    {
        return view('profile');
    }

    public function update( Request $request)
    {
        $data = $request->all();
        $user = User::where('email',$data['email'])->first();
        if($user){
            $this->validator($data);
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->name = $data['first_name'] . ' ' . $data['last_name'];
            $user->email = $data['email'];
            $user->payout_email = $data['email'];
            $user->partner = str_random(20).time();
            $user->password = Hash::make($data['password']);
            $user->save();
        }
        return view('profile');
    }

    public function updateCampaign( Request $request){
        var_dump($request->all());
        die;
        $req = $request->all();
        $data = $this->homeRepository->updateCampaign($req);
        return response()->json($data);

//        $campaign = $data['utm_campaign'];
//        $medium = $data['utm_medium'];
//        $source = $data['utm_source'];
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'payout_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }
}
