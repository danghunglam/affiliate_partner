<?php
/**
 * Created by PhpStorm.
 * User: hunglam
 * Date: 16/11/2018
 * Time: 11:09
 */

namespace App\Repositories;


use App\Campaign;
use App\Click;
use App\Contracts\Repositories\HomeRepositoryInterface;
use App\Statistical;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeRepository implements HomeRepositoryInterface
{
    private $count_date;

    private $from_date;

    private $to_date;

    private $date_search = 2;

    private $date_range;

    public function getCampaigns()
    {
        $user = User::where('email',session('email'))->first();
        if( ! $user)
            return false;
//
        $campaign = $user->campaign()->where('campaign','default')->first();

        $data = [
            'custom_url' => $campaign->custom_url,
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

    public function reportAll(array $data)
    {
        $user = User::where('email',session('email'))->first();
        if( ! $user)
            return false;

        $this->checkDate($data);

        $all = $this->all($user);

        $topClick = $this->topClick($user);

        $topTrial = $this->topTrial($user);

        $topPaid = $this->topPaid($user);

        $topEarning = $this->topEarning($user);


        $reportAll = [
            'topClick' => $topClick,
            'topTrial' => $topTrial,
            'topPaid' => $topPaid,
            'topEarning' => $topEarning,
            'all' => $all
        ];
        return $reportAll;
    }

    public function uniqueClick(array $data)
    {
        $user = User::where('email',session('email'))->first();
        if( ! $user)
            return false;


        $this->checkDate($data);

        $clicks = DB::table('clicks');
        //--------------------------------------------------------
        if($this->date_search == config('rule.date.days')){

            $clicks = $clicks
                ->select(DB::raw('sum(clicks.click) as total_click'), 'clicks.created_at');
        }

        if($this->date_search == config('rule.date.weeks')){
            $clicks = $clicks
                ->select(DB::raw('sum(clicks.click) as total_click'), DB::raw('FROM_DAYS(TO_DAYS(clicks.created_at) -MOD(TO_DAYS(clicks.created_at) -1, 7)) as created_at'));
        }

        if($this->date_search == config('rule.date.months')){
            $clicks = $clicks
                ->select(DB::raw('sum(clicks.click) as total_click'), DB::raw('DATE(DATE_FORMAT(clicks.created_at, \'%Y-%m-01\')) as created_at'));
        }
        //-----------------------------------------------------------------
        $clicks = $clicks->join('campaigns','clicks.campaign_id','=','campaigns.id')
                ->where('campaigns.user_id',$user->id)
                ->whereBetween(DB::raw('DATE_FORMAT(clicks.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))]);
//                ->rightJoinSub($this->date_range, 'dates','clicks.create','=','dates.d');
        //-----------------------------------------------------------------
        if($this->date_search == config('rule.date.days')){
            $clicks = $clicks
                ->groupBy(DB::raw('DATE_FORMAT(clicks.created_at, "%Y-%M-%d")'))
                ->orderBy(DB::raw('DATE_FORMAT(clicks.created_at, "%Y-%M-%d")'));
        }

        if($this->date_search == config('rule.date.weeks')){

            $clicks  = $clicks->groupBy(DB::raw('FROM_DAYS(TO_DAYS(DATE_FORMAT(clicks.created_at,"%Y-%m-%d")) -MOD(TO_DAYS(DATE_FORMAT(clicks.created_at,"%Y-%m-%d")) -1, 7))'))
                ->orderBy(DB::raw('FROM_DAYS(TO_DAYS(DATE_FORMAT(clicks.created_at,"%Y-%m-%d")) -MOD(TO_DAYS(DATE_FORMAT(clicks.created_at,"%Y-%m-%d")) -1, 7))'));
        }

        if($this->date_search == config('rule.date.months')){

            $clicks  = $clicks->groupBy(DB::raw('DATE(DATE_FORMAT(clicks.created_at, "%Y-%m-01"))'))
                ->orderBy(DB::raw('DATE(DATE_FORMAT(clicks.created_at, "%Y-%m-01"))'));
        }
        //--------------------------------------------------------------------
        $clicks = $clicks->get()->toArray();
        $data =[];
        foreach ($clicks as $click){
            $data[date('M d',strtotime($click->created_at))] = [
                'data'=>$click->total_click
            ];
        }

        return $data;
    }

    public function trialSignup(array $data){
        $user = User::where('email',session('email'))->first();
        if( ! $user)
            return false;

        $this->checkDate($data);

        $statisticals = DB::table('campaigns');

        if($this->date_search == config('rule.date.days')){

            $statisticals = $statisticals->select('statisticals.status','statisticals.created_at',DB::raw('count(statisticals.id) as total_store'));
        }

        if($this->date_search == config('rule.date.weeks')){
            $statisticals = $statisticals->select('statisticals.status',DB::raw('FROM_DAYS(TO_DAYS(statisticals.created_at) -MOD(TO_DAYS(statisticals.created_at) -1, 7)) as created_at'),DB::raw('count(statisticals.id) as total_store'));
        }

        if($this->date_search == config('rule.date.months')){
            $statisticals = $statisticals->select('statisticals.status',DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\')) as created_at'),DB::raw('count(statisticals.id) as total_store'));
        }

        $statisticals = $statisticals->join('statisticals','statisticals.campaign_id','=','campaigns.id')
            ->where('statisticals.status',config('statistical.status.free'))
            ->where('campaigns.user_id',$user->id)
            ->whereBetween(DB::raw('DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))]);

        if($this->date_search == config('rule.date.days')){
            $statisticals = $statisticals->groupBy(['statisticals.created_at'])
                                        ->orderBy(['statisticals.created_at']);
        }

        if($this->date_search == config('rule.date.weeks')){
            $statisticals = $statisticals->groupBy(DB::raw('FROM_DAYS(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -MOD(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -1, 7))'))
                ->orderBy(DB::raw('FROM_DAYS(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -MOD(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -1, 7))'));
        }

        if($this->date_search == config('rule.date.months')){
            $statisticals = $statisticals->groupBy(DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\'))'))
                ->orderBy(DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\'))'));
        }

        $statisticals = $statisticals->get()->toArray();

        $data =[];
        foreach ($statisticals as $statistical){
            $data[date('M d',strtotime($statistical->created_at))] = [
                'data'=> $statistical->total_store
            ];
        }
        return $data;
    }

    public function paidConversion(array $data)
    {
        $user = User::where('email',session('email'))->first();
        if( ! $user)
            return false;

        $this->checkDate($data);

        $statisticals = DB::table('campaigns');

        if($this->date_search == config('rule.date.days')){

            $statisticals = $statisticals->select('statisticals.status','statisticals.created_at',DB::raw('count(statisticals.id) as total_store'));
        }

        if($this->date_search == config('rule.date.weeks')){

            $statisticals = $statisticals->select('statisticals.status',DB::raw('FROM_DAYS(TO_DAYS(statisticals.created_at) -MOD(TO_DAYS(statisticals.created_at) -1, 7)) as created_at'),DB::raw('count(statisticals.id) as total_store'));
        }

        if($this->date_search == config('rule.date.months')){

            $statisticals = $statisticals->select('statisticals.status',DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\')) as created_at'),DB::raw('count(statisticals.id) as total_store'));
        }

        $statisticals = $statisticals->join('statisticals','statisticals.campaign_id','=','campaigns.id')
            ->where('campaigns.user_id',$user->id)
            ->whereBetween(DB::raw('DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))])
            ->where('statisticals.status','<>',config('statistical.status.free'));

        if($this->date_search == config('rule.date.days')){

            $statisticals = $statisticals->groupBy(['statisticals.created_at'])
                                        ->orderBy(['statisticals.created_at']);
        }

        if($this->date_search == config('rule.date.weeks')){

            $statisticals = $statisticals->groupBy(DB::raw('FROM_DAYS(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -MOD(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -1, 7))'))
                ->orderBy(DB::raw('FROM_DAYS(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -MOD(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -1, 7))'));
        }

        if($this->date_search == config('rule.date.months')){

            $statisticals = $statisticals->groupBy(DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\'))'))
                ->orderBy(DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\'))'));
        }

        $statisticals = $statisticals->get()->toArray();

        $data =[];
        foreach ($statisticals as $statistical){
            $data[date('M d',strtotime($statistical->created_at))] = [
                'data'=> $statistical->total_store
            ];
        }
        return $data;
    }

    public function earning(array $data)
    {
        $user = User::where('email',session('email'))->first();
        if( ! $user)
            return false;

        $this->checkDate($data);

        $statisticals = DB::table('campaigns');

        if($this->date_search == config('rule.date.days')){

            $statisticals = $statisticals->select('statisticals.status','statisticals.created_at',DB::raw('sum(statisticals.earning) as total_earning'));
        }

        if($this->date_search == config('rule.date.weeks')){

            $statisticals = $statisticals->select('statisticals.status',DB::raw('FROM_DAYS(TO_DAYS(statisticals.created_at) -MOD(TO_DAYS(statisticals.created_at) -1, 7)) as created_at'),DB::raw('sum(statisticals.earning) as total_earning'));
        }

        if($this->date_search == config('rule.date.months')){

            $statisticals = $statisticals->select('statisticals.status',DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\')) as created_at'),DB::raw('sum(statisticals.earning) as total_earning'));
        }


        $statisticals = $statisticals->join('statisticals','statisticals.campaign_id','=','campaigns.id')
                                    ->whereBetween(DB::raw('DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))]);

        if($this->date_search == config('rule.date.days')){

            $statisticals = $statisticals->groupBy(['statisticals.created_at'])
                                        ->groupBy(['statisticals.created_at']);
        }

        if($this->date_search == config('rule.date.weeks')){

            $statisticals = $statisticals->groupBy(DB::raw('FROM_DAYS(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -MOD(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -1, 7))'))
                ->orderBy(DB::raw('FROM_DAYS(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -MOD(TO_DAYS(DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")) -1, 7))'));
        }

        if($this->date_search == config('rule.date.months')){

            $statisticals = $statisticals->groupBy(DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\'))'))
                ->orderBy(DB::raw('DATE(DATE_FORMAT(statisticals.created_at, \'%Y-%m-01\'))'));
        }

        $statisticals = $statisticals->get()->toArray();
        $data =[];
        foreach ($statisticals as $statistical){
            $data[date('M d',strtotime($statistical->created_at))] = [
                'data'=> round($statistical->total_earning, 2)
            ];
        }
        return $data;
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

    public function update( array $data)
    {
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

    protected function topClick($user){

        $campaign = DB::table('campaigns')
            ->select('campaigns.id', 'campaigns.user_id','campaigns.created_at', 'campaigns.campaign')
            ->where('campaigns.user_id',$user->id)
            ->groupBy('campaigns.campaign');

        $topClicks = Click::select('campaigns.campaign',DB::raw('sum(IF(clicks.click is null, 0, clicks.click)) as total_click'),'clicks.created_at')
            ->rightJoinSub($campaign, 'campaigns','clicks.campaign_id','=','campaigns.id')
            ->whereBetween(DB::raw('DATE_FORMAT(clicks.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))]);

//        if($this->date_search == config('rule.date.days')){
//            $topClicks  = $topClicks
//        }

        $topClicks = $topClicks->orWhere('clicks.created_at',null)->groupBy('campaigns.campaign')->orderBy('total_click','DESC')->get()->toArray();

        return $topClicks;
    }

    protected function topTrial($user){
        $topTrial = Campaign::select('campaigns.id','campaigns.campaign',DB::raw('SUM(IF(statisticals.`status`='.config('statistical.status.free').',1,0)) as total_store'))
            ->leftJoin('statisticals','campaigns.id','=','statisticals.campaign_id')
            ->whereBetween(DB::raw('DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))])
            ->orWhere('statisticals.created_at',null)
            ->where('campaigns.user_id',$user->id)
            ->groupBy('campaigns.campaign')->orderBy('total_store','DESC')->get()->toArray();

        return $topTrial;
    }

    protected function topPaid($user){
        $topPaid = Campaign::select('campaigns.id', 'campaigns.campaign',DB::raw('SUM(IF(statisticals.`status`<>'.config('statistical.status.free').',1,0)) as total_store'))
            ->leftJoin('statisticals','campaigns.id','=','statisticals.campaign_id')
            ->whereBetween(DB::raw('DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))])
            ->orWhere('statisticals.created_at',null)
            ->where('campaigns.user_id',$user->id)
            ->groupBy(['campaigns.campaign'])
            ->orderBy('total_store','DESC')->get()->toArray();

        return $topPaid;
    }

    protected function topEarning($user){
        $topEarning = Campaign::select('campaigns.id', 'campaigns.campaign',DB::raw('sum(IF(statisticals.earning is null, 0, statisticals.earning)) as total_earning'))
            ->leftJoin('statisticals','statisticals.campaign_id','=','campaigns.id')
            ->whereBetween(DB::raw('DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))])
            ->orWhere('statisticals.created_at',null)
            ->where('campaigns.user_id',$user->id)
            ->groupBy(['campaigns.campaign'])
            ->orderBy('total_earning','DESC')->get()->toArray();

        return $topEarning;
    }

    protected function all($user){
        $campaign = DB::table('campaigns')
            ->select('campaigns.id', 'campaigns.user_id','clicks.created_at', DB::raw('sum( IF(clicks.click is null, 0, clicks.click)) as click'), 'campaigns.campaign')
            ->leftJoin('clicks','campaigns.id','=','clicks.campaign_id')
            ->whereBetween(DB::raw('DATE_FORMAT(clicks.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))])
            ->orWhere('clicks.created_at',null)
            ->where('campaigns.user_id',$user->id)
            ->groupBy('campaigns.campaign');

        $all = DB::table('statisticals')
            ->select(
                'campaigns.campaign',
                'campaigns.created_at',
                'campaigns.click', DB::raw('SUM(IF(statisticals.`status`= 1,1,0)) as trial'),
                DB::raw('SUM(IF(statisticals.`status`<> 1,1,0)) as paid'), DB::raw('SUM( IF(statisticals.earning is null, 0, statisticals.earning)) as earning'))
            ->rightJoinSub($campaign, 'campaigns','statisticals.campaign_id','=','campaigns.id')

            ->whereBetween(DB::raw('DATE_FORMAT(statisticals.created_at,"%Y-%m-%d")'),[date('Y-m-d',strtotime($this->from_date)),date('Y-m-d',strtotime($this->to_date))])

            ->orWhere('statisticals.created_at',null)->groupBy(['campaigns.campaign'])->get()->toArray();
        return $all;
    }

    protected function checkDate($data){
        $this->from_date = $data['from_date'];
        $this->to_date = $data['to_date'];

        //abs lấy giá trị tuyệt đối
        $datediff = abs(strtotime($this->to_date) - strtotime($this->from_date));
        $this->count_date = intval($datediff / (60*60*24)); //floor

//      <= 30 days: mỗi ngày 1 cột
//      31 -  180 days : mỗi tuần 1 cột
//      181 days trở lên: mỗi tháng 1 cột
        if($this->count_date <= 30) $this->date_search = 1;
        if($this->count_date >= 181) $this->date_search = 3;


    }
}