<?php

namespace App\Contracts\Repositories;

interface HomeRepositoryInterface

{
    public function create_link();

    public function profile();

    public function update(array $data);

    public function download();

    public function getCampaigns();

    public function saveCampaign( array $data);

    public function uniqueClick(array $data);

    public function trialSignup(array $data);

    public function paidConversion(array $data);

    public function earning(array $data);

    public function reportAll(array $data);

}