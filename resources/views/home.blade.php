@extends('content_data')

@section('data_content')
    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Overview</li>
            </ol>


            <div class="filter-order-date" style="margin-right: 20px">
                <div class="order-date-form">
                    <input id="filter_date_from" v-model="date_from" name="filter_date_from"  class="datepicker" type="button">
                </div>
                <span class="order-date-dash">-</span>
                <div class="order-date-to">
                    <input id="filter_date_to" v-model="date_to" name="filter_date_to"  class="datepicker" type="button">
                </div>
                <div class="filter-order-date-dropdown" @click="showFilterDatePicker">
                    <span><i class="mdi mdi-chevron-down"></i></span>
                </div>
                <div id="filter-date-time-picker" style="padding-bottom: 20px" v-show="show_filter_date_picker">
                    <div id="filter-date-time-picker-from"></div>
                    <div id="filter-date-time-picker-to"></div>
                    <div id="filter-date-time-apply">
                        <button type="button" @click="filterOrdersDate">Apply</button>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <span>Unique clicks</span>
                            <span class="small text-muted" style="float: right">Last 30 days</span>
                        </div>
                        <div class="card-body unique-click">
                            <canvas id="unique_click" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-header">
                            <div >TOP CAMPAIGNS</div>

                            <div v-if="topClicks" v-for="topClick in topClicks" class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">@{{ topClick.campaign }}</a>
                                <span style="float: right">@{{ topClick.total_click }}</span>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <span>Trial Signups</span>
                            <span class="small text-muted" style="float: right">Last 30 days</span>
                        </div>
                        <div class="card-body trial-signup">
                            <canvas id="trial_signup" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-header">
                            <div >TOP CAMPAIGNS</div>

                            <div v-if="topTrials" v-for="topTrial in topTrials" class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">@{{ topTrial.campaign }}</a>
                                <span style="float: right">@{{ topTrial.total_store }}</span>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <span>Paid Conversions</span>
                            <span class="small text-muted" style="float: right">Last 30 days</span>
                        </div>
                        <div class="card-body paid-conversion">
                            <canvas id="paid_conversion" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-header">
                            <div >TOP CAMPAIGNS</div>
                            <div v-if="topPaids" v-for="topPaid in topPaids" class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">@{{ topPaid.campaign }}</a>
                                <span style="float: right">@{{ topPaid.total_store }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <span>Earnings</span>
                            <span class="small text-muted" style="float: right">Last 30 days</span>
                        </div>
                        <div class="card-body earning">
                            <canvas id="earning" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-header">
                            <div >TOP CAMPAIGNS</div>
                            <div v-if="topEarnings" v-for="topEarning in topEarnings" class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">@{{ topEarning.campaign }}</a>
                                <span style="float: right">@{{ parseFloat(topEarning.total_earning).toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Data Table Example</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Campaign</th>
                                <th>Clicks</th>
                                <th>Trials</th>
                                <th>Paid</th>
                                <th>Earnings</th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr v-if="all" v-for="item in all">
                                <td>@{{ item.campaign }}</td>
                                <td>@{{ item.click }}</td>
                                <td>@{{ item.trial }}</td>
                                <td>@{{ item.paid }}</td>
                                <td>$@{{ item.earning }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>--}}
            </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Your Website 2018</span>
                </div>
            </div>
        </footer>

    </div>
@endsection

@section('footer_extend')
    <script src="{{ mix('js/Chart.min.js') }}"></script>
    {{--<script src="{{ mix('js/chart-bar-demo.js') }}"></script>--}}
    <script src="{{ mix('js/home.min.js') }}"></script>
@endsection
