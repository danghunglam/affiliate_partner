<?php
/**
 * Created by PhpStorm.
 * User: hunglam
 * Date: 19/11/2018
 * Time: 13:40
 */

namespace App\Repositories;


use App\Campaign;
use App\Click;
use App\Contracts\Repositories\ApiRepositoryInterface;
use App\Statistical;
use App\User;
use Illuminate\Support\Facades\DB;

class ApiRepository implements ApiRepositoryInterface
{
    public function updateCampaign(array $data)
    {

        $user = User::where('partner',$data['partner_id'])->first();
        if( ! $user)
            return false;

        try{

            DB::beginTransaction();
            $campaign = Campaign::where('user_id',$user->id)->where('campaign',$data['campaign'])->first();

            if(!$campaign) return false;

//            $click = Click::where('campaign_id',$campaign->id)->first();

            Click::updateOrCreate(
                ['created_at' => Click::where(DB::raw('DATE(DATE_FORMAT(created_at , \'%Y-%m-%d\'))'),date("Y-m-d"))->first()->created_at ?? date("Y-m-d"), 'campaign_id' => $campaign->id ],
                [ 'click' => DB::raw('click + 1'), 'campaign_id' => $campaign->id]

            );
            Statistical::updateOrCreate(
                ['store_name'=> $data['store_name'],'app'=> $data['app']],
                ['status' => config('statistical.status.'. $data['status'].''),'campaign_id' => $campaign->id]
            );

            DB::commit();
            return true;

        }catch (\Exception $ex){
            DB::rollBack();
            return false;
        }
    }

    public function upgradeCampaign(array $data)
    {
        $statistical = Statistical::where('store_name',$data['store_name'])->where('app',$data['app'])->first();
        if( ! $statistical)
            return false;
        $statistical->status = config('statistical.status.'. $data['status'].'');
        $statistical->earning = (float) $data['price'] * config('statistical.discount.'. $data['status'].'')/100;
        $statistical->save();
        return true;
    }
}