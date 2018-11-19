<?php
/**
 * Created by PhpStorm.
 * User: hunglam
 * Date: 19/11/2018
 * Time: 13:39
 */

namespace App\Contracts\Repositories;


interface ApiRepositoryInterface
{
    public function updateCampaign(array $data);
}