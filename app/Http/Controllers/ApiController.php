<?php
/**
 * Created by PhpStorm.
 * User: hunglam
 * Date: 19/11/2018
 * Time: 13:37
 */

namespace App\Http\Controllers;


use App\Contracts\Repositories\ApiRepositoryInterface;
use App\Contracts\Repositories\HomeRepositoryInterface;
use Illuminate\Http\Request;

class ApiController
{
    protected $apiRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiRepositoryInterface $apiRepositoryInterface )
    {
        $this->apiRepository = $apiRepositoryInterface ;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCampaign( Request $request){
        $req = $request->all();
        $data = $this->apiRepository->updateCampaign($req);
        return response()->json($data);
//        $campaign = $data['utm_campaign'];
//        $medium = $data['utm_medium'];
//        $source = $data['utm_source'];
    }
}