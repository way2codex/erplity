@extends('layouts.app')
@section('title')
    {{ $data['title'] }}
@endsection
@section('custom_style')
@endsection
@section('main')
    <div class="content-body">
        <section id="basic-form-layouts">
            <div class="row match-height">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form"> Admin {{ $data['module'] }}</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <form action="{{ route('update_profile') }}" id='add_form' name="add_form" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="form-group text-center">
                                                    <img src="{{ $user->photo}}" width="100px" height="100px" class="rounded-circle">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Admin Name</label>
                                                    <input type="text" class="form-control" placeholder="Admin Name"
                                                        id='name' name="name" value="{{ old('name', $user->name) }}">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Mobile No</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="Mobile For Login" id='mobile' name="mobile"
                                                        value="{{ old('mobile', $user->mobile) }}" minlength="10"
                                                        maxlength="10">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="alt_mobile">Alt Mobile</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="Alternate Mobile" id='alt_mobile' name="alt_mobile"
                                                        value="{{ old('alt_mobile', $user->alt_mobile) }}" minlength="10"
                                                        maxlength="10">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Upload Admin photo</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image"
                                                            name="image" accept="image/png,image/jpeg,image/jpg">
                                                        <input type="hidden" name="old_photo" value="{{ auth()->user()->photo}}">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            {{ $data['module'] }} Image</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-center">
                                            <button type="submit"
                                                class="btn shadow-primary waves-effect waves-light btn-square btn-primary">
                                                <i class="fa fa-check-square-o"></i> Update & Save
                                            </button>
                                            <a href="{{ route($data['route']) }}">
                                                <button type="button"
                                                    class="btn shadow-danger waves-effect waves-light btn-square btn-danger mr-1">
                                                    <i class="fa fa-times"></i> Cancel
                                                </button>
                                            </a>

                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('custom_script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $("#add_form").validate({
                rules: {
                    name: {
                        required: true
                    },
                    mobile: {
                        required: true,
                        number: true
                    },
                },
                messages: {
                    name: {
                        required: "Please Enter Supplier name.",
                    },
                    mobile: {
                        required: "Please Enter Mobile",
                    },
                }
            });

        });
    </script>
@endsection
