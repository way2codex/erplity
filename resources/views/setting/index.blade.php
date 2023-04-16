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
                            <h4 class="card-title" id="basic-layout-form">Add {{ $data['module'] }}</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <form action="{{ route('update_setting') }}" id='add_form' name="add_form" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Company Name</label>
                                                    <input type="text" class="form-control" placeholder="Company Name"
                                                        id='company_name' name="company_name" value="{{ old('company_name',$setting->company_name) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">GST No</label>
                                                    <input type="text" class="form-control" placeholder="GST NO"
                                                        id='gst_no' name="gst_no" value="{{ old('gst_no',$setting->gst_no) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Pan No</label>
                                                    <input type="text" class="form-control" placeholder="Pan No"
                                                        id='pan_no' name="pan_no" value="{{ old('pan_no',$setting->pan_no) }}">
                                                        @error('pan_no')
                                                        <label id="name-error" class="error" for="name">{{ $errors->first('pan_no')}}</label>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Mobile</label>
                                                    <input type="number" class="form-control" placeholder="Mobile"
                                                        id='mobile' name="mobile" value="{{ old('mobile',$setting->mobile) }}" maxlength="10" minlength="10">
                                                        @error('mobile')
                                                        <label id="name-error" class="error" for="name">{{ $errors->first('mobile')}}</label>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">E-Mail </label>
                                                    <input type="email" class="form-control" placeholder="E-Mail"
                                                        id='email' name="email" value="{{ old('email',$setting->email) }}">
                                                        @error('email')
                                                        <label id="name-error" class="error" for="name">{{ $errors->first('email')}}</label>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">City</label>
                                                    <input type="text" class="form-control" placeholder="City"
                                                        id='city' name="city" value="{{ old('city',$setting->city) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Pincode</label>
                                                    <input type="number" class="form-control" placeholder="Pincode"
                                                        id='pincode' name="pincode" value="{{ old('pincode',$setting->pincode) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Upload Company Logo</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image"
                                                            name="image" accept="image/png,image/jpeg,image/jpg">
                                                        <input type="hidden" name="old_logo" value="{{ $setting->logo}}">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            {{ $data['module'] }} Image</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Address</label>
                                                    <textarea name="address" class="form-control" placeholder="Address">
                                                        {{$setting->address}}
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-body">
                                        <div class="row">
                                                <div class="col-md-6">
                                                    <label for="image">{{$data['title']}} Image</label>
                                                    <div class="form-group">
                                                        <img src="{{ $setting['logo'] }}" style="width: 100px;border:2px solid #ff6a00;" id="image" alt="No Image Uploaded"/>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
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
                        number:true
                    },
                    city: {
                        required: true
                    },
                    pincode: {
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
                    city: {
                        required: "Please Enter City",
                    },
                }
            });

        });
    </script>
@endsection
