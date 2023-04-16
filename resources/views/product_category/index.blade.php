@extends('layouts.app')
@section('title')
{{$data['title']}}
@endsection
@section('custom_style')

@endsection
@section('main')

<div class="content-body">
    <section id="configuration">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$data['module']}}</h4>
                        <div class="heading-elements">
                            <div class="btn-group float-md-right">

                                <a href="{{route('create_product_category')}}"><button class="btn shadow-primary waves-effect waves-light btn-square btn-primary" type="button">
                                        <i class="icon-plus mr-1"></i>Add {{$data['module']}}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table style="width: 100%;" id="data_table" class="table-sm table-bordered  dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('custom_script')
@include($data['view'].'.script')
@endsection
