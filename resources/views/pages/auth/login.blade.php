@extends('layout.master2')

@section('content')

<div class="page-content d-flex align-items-center justify-content-center">

    <form method="POST" action="{{ route('login') }}" class="page-content d-flex align-items-center justify-content-center">
        @csrf
  <div class="row w-100  h-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">

      <div class="card">

        <div class="row">

          <div class="col-md-4 pe-md-0">

              <div class="auth-side-wrapper" style="background-image: url('{{ asset('img/advocate.jpg') }}')"></div>

          </div>
          <div class="col-md-8 ps-md-0">
              @error('error')
              <div class=" fs-4 p-2  text-danger"> * البريد الإلكتروني أو كلمة المرور غير صحيحة</div>
              @enderror
            <div class="auth-form-wrapper px-4 py-5">
                <div class="position-relative left-align">
                    <a href="#" class="mb-2 "><img src="{{ asset("/img/logo.png") }}" alt="E-QAQIQ LOGO" style="height: 110px ;"></a>
                </div>
              <form class="forms-sample p-lg-3">
                <div class="mb-3 p-lg-2">
                  <label for="userEmail" class="form-label p-lg-2 fs-5">البريد الإلكتروني</label>
                  <input type="email" name="email" class="form-control" id="userEmail" required placeholder="البريد الإلكتروني">
                </div>
                <div class="mb-3 p-lg-2">
                  <label for="userPassword" class="form-label p-lg-2 fs-5">كلمة المرور</label>
                  <input type="password" name="password" class="form-control" id="userPassword" autocomplete="current-password" required placeholder="كلمة المرور">
                </div>

                <div>
                    <button type="submit"  class="btn btn-primary me-2 mb-2 mb-md-0">مصادقة</button>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    </form>
</div>
@endsection
