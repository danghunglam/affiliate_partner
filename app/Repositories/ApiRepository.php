<?php
/**
 * Created by PhpStorm.
 * User: hunglam
 * Date: 19/11/2018
 * Time: 13:40
 */

namespace App\Repositories;


use App\Campaign;
use App\Contracts\Repositories\ApiRepositoryInterface;
use App\Statistical;
use App\User;
use Illuminate\Support\Facades\DB;

class ApiRepository implements ApiRepositoryInterface
{
    public function updateCampaign(array $data){

        $user = User::where('partner',$data['partner_id'])->first();
        if( ! $user)
            return false;
        DB::beginTransaction();
        try{
            $campaign = Campaign::where('user_id',$user->id)->where('campaign',$data['campaign'])->first();
            if(!$campaign) return false;
            $campaign->click = $campaign->click + 1;

            if($campaign->save()){
                Statistical::updateOrCreate(
                    ['store_name'=> $data['store_name'],'app'=> $data['app']],
                    ['status' => config('statistical.'. $data['status'].''),'campaign_id' => $campaign->id]
                );
                DB::commit();
                return true;
            }

        }catch (\Exception $ex){
            DB::rollBack();
            return false;
        }
    }
}