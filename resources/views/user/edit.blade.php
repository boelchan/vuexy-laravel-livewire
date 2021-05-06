
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit data')

@section('content')

<section class="bs-validation">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" class="form_ajax" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="customFile1">Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama" value="{{ $user->name }}" />
                        </div>

                        <div class="form-group">
                            <label for="basicSelect">Role</label>
                            <select class="form-control" name="role_id">
                                @foreach($roles as $k => $v)
                                    <option 
                                        value="{{ $k }}" 
                                        @if ($user->role_id == $k)
                                            {{ 'selected' }}
                                        @endif
                                        >
                                        {{ $v }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="">Email</label>
                            <input type="email" name="email" id="" class="form-control" placeholder="email" value="{{ $user->email }}" />
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