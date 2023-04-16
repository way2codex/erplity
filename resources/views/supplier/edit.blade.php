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
                            <h4 class="card-title" id="basic-layout-form">Edit {{ $data['module'] }}</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <form action="{{ route('update_supplier') }}" id='add_form' name="add_form" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{ $supplier['id'] }}" id="id" name="id" />
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">GST No</label>
                                                    <input type="text" class="form-control" placeholder="GST NO"
                                                        id='gst_no' name="gst_no" value="{{ old('gst_no',$supplier->gst_no) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Full Name</label>
                                                    <input type="text" class="form-control" placeholder="Full Name"
                                                        id='name' name="name" value="{{ old('name',$supplier->name) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Mobile</label>
                                                    <input type="number" class="form-control" placeholder="Mobile"
                                                        id='mobile' name="mobile" value="{{ old('mobile',$supplier->mobile) }}" maxlength="10" minlength="10">
                                                        @error('mobile')
                                                        <label id="name-error" class="error" for="name">{{ $errors->first('mobile')}}</label>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Alt Mobile </label>
                                                    <input type="number" class="form-control" placeholder="Alternate Mobile"
                                                        id='alt_mobile' name="alt_mobile" value="{{ old('alt_mobile',$supplier->alt_mobile) }}" maxlength="10" minlength="10">
                                                        @error('alt_mobile')
                                                        <label id="name-error" class="error" for="name">{{ $errors->first('alt_mobile')}}</label>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">E-Mail </label>
                                                    <input type="email" class="form-control" placeholder="E-Mail"
                                                        id='email' name="email" value="{{ old('email',$supplier->email) }}">
                                                        @error('email')
                                                        <label id="name-error" class="error" for="name">{{ $errors->first('email')}}</label>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">City</label>
                                                    <input type="text" class="form-control" placeholder="City"
                                                        id='city' name="city" value="{{ old('city',$supplier->city) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Pincode</label>
                                                    <input type="number" class="form-control" placeholder="Pincode"
                                                        id='pincode' name="pincode" value="{{ old('pincode',$supplier->pincode) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Upload Image (Optional)</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image"
                                                            name="image" accept="image/png,image/jpeg,image/jpg">
                                                        <input type="hidden" name="old_image" value="{{ $supplier->photo }}">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            {{ $data['module'] }} Image</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Status</label>
                                                    <select id="status" name="status" class="select2 form-control">
                                                        <option <?php if (old('status',$supplier['status']) == 1) {
                                                            echo 'selected';
                                                        } ?> value="1">Active</option>
                                                <option <?php if (old('status',$supplier['status']) == 0) {
                                                            echo 'selected';
                                                        } ?> value="0">InActive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Address</label>
                                                    <textarea name="address" class="form-control" placeholder="Address">
                                                        {{old('address',$supplier->address)}}
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-body">
                                        <div class="row">
                                                <div class="col-md-6">
                                                    <label for="image">{{$data['title']}} Photo</label>
                                                    <div class="form-group">
                                                        <img src="{{ $supplier['photo'] }}" style="width: 100px;border:2px solid #ff6a00;" id="image" alt="No Image Uploaded"/>
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
                        number:true,
                        remote: {
                            type: 'POST',
                            url: "{{ route('supplier_mobile_check') }}",
                            data: {
                                mobile: function() {
                                    return $("#mobile").val();
                                },
                                id: function() {
                                    return $("#id").val();
                                },
                            },
                        },
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
                        required: "Please Enter Mobile.",
                        remote: "This Mobile Already Taken."
                    },
                    city: {
                        required: "Please Enter City",
                    },
                }
            });

        });
    </script>
@endsection
