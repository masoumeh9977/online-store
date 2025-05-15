@extends('website.layouts.master')
@section('title', 'Login')

@section('content')
    <div class="row">
        <section class="bg-home d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="me-lg-5">
                            <img src="images/user/login.svg" class="img-fluid d-block mx-auto" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="card login-page bg-white shadow rounded border-0">
                            <div class="card-body">
                                <h4 class="card-title text-center">Login</h4>
                                <form class="login-form mt-4" action="{{route('website.login')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input type="email" class="form-control ps-5" placeholder="email"
                                                           name="email" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Password<span
                                                        class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                                    <input type="password" class="form-control ps-5"
                                                           placeholder="password" name="password" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between">
                                                <p class="forgot-pass mb-0"><a href="auth-re-password.html"
                                                                               class="text-dark fw-bold">Forgot
                                                        Password?</a></p>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary">Login</button>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center">
                                            <p class="mb-0 mt-3"><small class="text-dark me-2">Don't Have An
                                                    Account?</small> <a
                                                    href="auth-signup.html" class="text-dark fw-bold">Signup</a>
                                            </p>
                                        </div>
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
