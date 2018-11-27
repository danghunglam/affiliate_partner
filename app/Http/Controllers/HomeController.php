<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Contracts\Repositories\HomeRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $homeRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeRepositoryInterface $homeRepositoryInterface)
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
        $email = Auth::user()->email;
        session(['email' => $email]);
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
        $data = $this->homeRepository->update($data);
        return view('profile');
    }

    public function reportAll(Request $request){
        $req = $request->all();
        $data = $this->homeRepository->reportAll($req);
        return response()->json($data);
    }

    public function uniqueClick(Request $request){
        $req = $request->all();
        $data = $this->homeRepository->uniqueClick($req);
        return response()->json($data);
    }

    public function trialSignup(Request $request){
        $req = $request->all();
        $data = $this->homeRepository->trialSignup($req);
        return response()->json($data);
    }

    public function paidConversion(Request $request){
        $req = $request->all();
        $data = $this->homeRepository->paidConversion($req);
        return response()->json($data);
    }

    public function earning(Request $request){
        $req = $request->all();
        $data = $this->homeRepository->earning($req);
        return response()->json($data);
    }


}
