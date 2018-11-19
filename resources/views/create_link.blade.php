@extends('content_data')

@section('data_content')
    <div id="create_link" style="width: 100%" >
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Your link</a>
                </li>
            </ol>

            <h4> Create an affiliate link</h4>

            <div class="row" style="border: #0b58a2 1px;padding: 20px">
                <div class="col-md-11 form-group" >
                    <div class="form-label-group">
                        <span></span>
                        <input type="text" id="link" class="form-control" placeholder="Email address" :value="share_link" required="required" disabled="disabled">
                        {{--<label for="inputEmail">address</label>--}}
                    </div>
                </div>
                <div class="col-md-1 form-group">
                    <button type="button" class="btn btn-outline-secondary btn-lg" @click="copyClipboard(event)" style="float: right">Coppy</button>
                </div>
            </div>
            <div class="row" style="border: #0b58a2 1px;padding: 20px">
                <div class="col-md-12 form-group">
                    <span> Campaign name (optional)</span>
                    <div class="form-label-group">
                        <input  type="text" id="campaign" class="form-control" placeholder="Email address" @keyup="addLink()" v-model="campaign" required="required">
                        {{--<input  type="text" id="campaign" class="form-control" placeholder="Email address"  v-model="custom_link + '&utm_campain=' + campaign "  required="required">--}}

                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <span> Source (optional)</span>
                    <div class="form-label-group">
                        <input type="text" id="source" class="form-control" placeholder="Email address" @keyup="addLink()" v-model="source" required="required">

                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <span> Medium (optional)</span>
                    <div class="form-label-group">
                        <input type="text" id="medium" class="form-control" placeholder="Email address" @keyup="addLink()" v-model="medium" required="required">

                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <div class="form-label-group">
                        <button type="button" class="btn btn-secondary btn-lg" @click="save()" style="float: right">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_extend')
    <script src="{{ mix('js/create_link.min.js') }}"></script>
@endsection