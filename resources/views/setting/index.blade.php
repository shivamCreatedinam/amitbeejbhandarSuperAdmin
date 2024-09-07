@extends('partials.app')
@section('title', 'Setting Page')
@section('container')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Settings</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Setting</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Settings</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin_setting_update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $setting->id ?? null }}">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="website_name">Website Name <span class="text-danger">*</span></label>
                            <input type="text" name="website_name" class="form-control" id="website_name"
                                value="{{ $setting->website_name ?? null }}" placeholder="Website Name">
                            @error('website_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="from_mail_name">From Mail Name <span class="text-danger">*</span></label>
                            <input type="text" name="from_mail_name" class="form-control" id="from_mail_name"
                                value="{{ $setting->from_mail_name ?? null }}" placeholder="From Mail Name">
                                @error('from_mail_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="from_mail_address">From Mail Address <span class="text-danger">*</span></label>
                            <input type="text" name="from_mail_address" class="form-control" id="from_mail_address"
                                value="{{ $setting->from_mail_address ?? null }}" placeholder="From Mail Address">
                                @error('from_mail_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary float-end">Update Details</button>
                </form>
            </div>
        </div>
    </div>
@endsection
