<?php
/**
 * Created by PhpStorm.
 * User: hunglam
 * Date: 16/11/2018
 * Time: 11:09
 */

namespace App\Repositories;


use App\Campaign;
use App\Contracts\Repositories\HomeRepositoryInterface;
use App\User;

class HomeRepository implements HomeRepositoryInterface
{
    public function getCampaigns()
    {
        $user = User::where('email',session('email'))->first();
        if( ! $user)
            return false;
//
//        $data = $user->campaign()->orderBy('created_at')->limit(1)->get();
//        $data = json_decode(json_encode($data));
//        if(empty($data)){
//
//            $data = [
//                'custom_url' => config('create_link.custom_link') . $user->partner,
//                'campaign' => '',
//                'source' => '',
//                'medium' => ''
//            ];
//        }
//        else{
//            $data = [
//                'custom_url' => $data[0]->custom_url,
//                'campaign' => $data[0]->campaign,
//                'source' => $data[0]->source,
//                'medium' => $data[0]->medium
//            ];
//        }
        $data = [
            'custom_url' => config('create_link.custom_link') . $user->partner,
            'campaign' => '',
            'source' => '',
            'medium' => ''
        ];

        return $data;
    }

    public function saveCampaign(array $data){

        $user = User::where('email',session('email'))->first();
        if( ! $user)
            return false;
        $check_compaign = Campaign::where('campaign',$data['campaign'])->first();
        if($check_compaign) return false;

        return Campaign::create([
            'custom_url' => $data['custom_link'],
            'campaign' => $data['campaign'],
            'source' => $data['source'],
            'medium' => $data['medium'],
            'click' => 0,
            'user_id' =>$user->id
        ]);
    }

    public function create_link()
    {
        // TODO: Implement create_link() method.
    }

    public function download()
    {
        // TODO: Implement download() method.
    }

    public function profile()
    {
        // TODO: Implement profile() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }
}