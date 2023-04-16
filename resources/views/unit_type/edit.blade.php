@extends('layouts.app')
@section('title')
{{$data['title']}}
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
                        <h4 class="card-title" id="basic-layout-form">Edit {{$data['module']}}</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form action="{{ route('update_unit_type') }}" id='add_form' name="add_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $UnitType['id'] }}" id="id" name="id" />
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input value="{{ old('name',$UnitType['name']) }}" type="text" class="form-control" placeholder="Name" id='name' name="name">
                                                @error('name')
                                                        <label id="name-error" class="error" for="name">{{ $errors->first('name')}}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Status</label>
                                                <select id="status" name="status" class="select2 form-control">
                                                    <option <?php if ($UnitType['status'] == 1) {
                                                                echo 'selected';
                                                            } ?> value="1">Active</option>
                                                    <option <?php if ($UnitType['status'] == 0) {
                                                                echo 'selected';
                                                            } ?> value="0">InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn shadow-primary waves-effect waves-light btn-square btn-primary">
                                        <i class="fa fa-check-square-o"></i> Update & Save
                                    </button>
                                    <a href="{{ route($data['route']) }}">
                                        <button type="button" class="btn shadow-danger waves-effect waves-light btn-square btn-danger mr-1">
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
                }
            },
            messages: {
                name: {
                    required: "Please enter a name",
                },
            }
        });
    });
</script>
@endsection
