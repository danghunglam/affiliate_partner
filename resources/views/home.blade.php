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



            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <span>Unique clicks</span>
                            <span class="small text-muted" style="float: right">Last 30 days</span>
                        </div>
                        <div class="card-body">
                            <canvas id="unique_click" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-header">
                            <div >TOP CAMPAIGNS</div>

                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">default</a>
                                <span style="float: right">446</span>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">webappdata</a>
                                <span style="float: right">446</span>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">blogpost</a>
                                <span style="float: right">446</span>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">webpage</a>
                                <span style="float: right">446</span>
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
                        <div class="card-body">
                            <canvas id="trial_signup" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-header">
                            <div >TOP CAMPAIGNS</div>
                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">default</a>
                                <span style="float: right">446</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">webappdata</a>
                                <span style="float: right">446</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">blogpost</a>
                                <span style="float: right">446</span>
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
                        <div class="card-body">
                            <canvas id="paid_conversion" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-header">
                            <div >TOP CAMPAIGNS</div>
                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">default</a>
                                <span style="float: right">446</span>
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
                        <div class="card-body">
                            <canvas id="earning" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-header">
                            <div >TOP CAMPAIGNS</div>
                            <div class="col-lg-12 col-md-12">
                                <a style="color: #0b58a2">default</a>
                                <span style="float: right">446</span>
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
                            <tr>
                                <td>default</td>
                                <td>446</td>
                                <td>75</td>
                                <td>16</td>
                                <td>$641.50</td>
                            </tr>
                            <tr>
                                <td>webappdata</td>
                                <td>86</td>
                                <td>1</td>
                                <td>0</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>blogpost</td>
                                <td>60</td>
                                <td>39</td>
                                <td>0</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>webpage</td>
                                <td>17</td>
                                <td>0</td>
                                <td>0</td>
                                <td>$0.00</td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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
    <script src="{{ mix('js/chart-bar-demo.js') }}"></script>
@endsection