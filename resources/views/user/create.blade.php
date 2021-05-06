
@extends('layouts/contentLayoutMaster')

@section('title', 'Tambah data')

@section('content')

<section class="bs-validation">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST" class="form_ajax" novalidate enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="customFile1">Nama</label>
                            <input type="text" name="name" id="" class="form-control" placeholder="Nama" value="" />
                        </div>

                        <div class="form-group">
                            <label for="basicSelect">Role</label>
                            <select class="form-control" name="role_id">
                                @foreach($roles as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="">Email</label>
                            <input type="email" name="email" id="" class="form-control" placeholder="email"  value="" />
                        </div>

                        <div class="form-group">
                            <label for="password-new">New Password</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" tabindex="1" autofocus />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">New Password Confirm</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="password-confirm" name="password-confirm" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password-confirm" tabindex="2" autofocus />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('page-script')
@endsection