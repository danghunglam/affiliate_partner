<?php

namespace App\Contracts\Repositories;

interface HomeRepositoryInterface

{
    public function create_link();

    public function profile();

    public function update();

    public function download();

    public function getCampaigns();

    public function saveCampaign( array $data);

}