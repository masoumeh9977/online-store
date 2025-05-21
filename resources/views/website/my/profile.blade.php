@extends('website.layouts.master')
@section('title', 'Profile')

@section('content')
    <section class="section" style="height: 91vh;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mt-4 pt-2">
                    <div class="d-flex align-items-center">
                        <img src="/images/user/avatar.png" class="avatar avatar-md-md rounded-circle" alt="">
                        <div class="ms-3">
                            <h6 class="text-muted mb-0">Hi</h6>
                            <h5 class="mb-0">{{$user->name}}</h5>
                        </div>
                    </div>
                    <ul class="nav nav-pills flex-column bg-white rounded mt-4 shadow p-3 mb-0"
                        id="pills-tab" role="tablist">
                        <li class="nav-item mt-2">
                            <a class="nav-link rounded active" id="order-history" data-bs-toggle="pill" href="#orders"
                               role="tab" aria-controls="orders" aria-selected="false">
                                <div class="py-1 px-3">
                                    <h6 class="mb-0">
                                        <i class="uil uil-list-ul h5 align-middle me-2 mb-0"></i>
                                        Orders
                                    </h6>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link rounded" id="address-detail" data-bs-toggle="pill" href="#address"
                               role="tab" aria-controls="address" aria-selected="false">
                                <div class="py-1 px-3">
                                    <h6 class="mb-0"><i class="uil uil-map-marker h5 align-middle me-2 mb-0"></i>
                                        Address</h6>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link rounded" id="account-details" data-bs-toggle="pill" href="#account"
                               role="tab" aria-controls="account" aria-selected="false">
                                <div class="py-1 px-3">
                                    <h6 class="mb-0"><i class="uil uil-user h5 align-middle me-2 mb-0"></i>Account
                                        Detail</h6>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link rounded" href="{{route('website.logout')}}" aria-selected="false">
                                <div class="py-1 px-3">
                                    <h6 class="mb-0"><i class="uil uil-sign-out-alt h5 align-middle me-2 mb-0"></i>
                                        Logout </h6>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 col-12 mt-4 pt-2">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade bg-white shadow rounded show active p-4" id="orders" role="tabpanel"
                             aria-labelledby="order-history">
                            <div class="table-responsive bg-white shadow rounded">
                                <table class="table mb-0 table-center table-nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="border-bottom">tracking-no</th>
                                        <th scope="col" class="border-bottom">date</th>
                                        <th scope="col" class="border-bottom">status</th>
                                        <th scope="col" class="border-bottom">total-amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->orders as $order)
                                        <tr>
                                            <td>{{$order->tracking_code}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{!! \App\Services\Facades\OrderStatusHelper::badge($order->status) !!}</td>
                                            <td>{{$order->total_amount}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade bg-white shadow rounded p-4" id="address" role="tabpanel"
                             aria-labelledby="addresses">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h5 class="mb-0 fw-bold">Delivery Address</h5>
                                <button type="button" class="btn btn-primary" id="editAddressBtn">
                                    <i data-feather="edit-2" class="icon-xs me-1"></i> Edit Address
                                </button>
                            </div>
                            <div class="address-display p-3 border rounded mb-4" id="addressDisplay">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <i data-feather="map-pin" class="text-primary icon-md"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-dark">Default Shipping Address</h6>
                                        <p class="text-muted mb-2">{{$user->address}}</p>
                                        <span class="badge bg-soft-success text-success">Default Address</span>
                                    </div>
                                </div>
                            </div>
                            <div class="address-edit-form border rounded p-4 bg-light" id="addressEditForm"
                                 style="display: none;">
                                <form method="post" action="{{route('website.user.reset.address')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Full Address</label>
                                                <div class="form-icon position-relative">
                                                    <textarea class="form-control"
                                                              name="address">{{$user->address ?? ''}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Province</label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="globe" class="fea icon-sm icons"></i>
                                                    <select id="province" name="province_id"
                                                            class="form-select form-control ps-5">
                                                        <option value="">Select a province</option>
                                                        @foreach(\App\Models\IranProvince::all() as $province)
                                                            <option value="{{$province->id}}"
                                                                {{$user->province_id == $province->id ? 'selected' : ''}}>{{$province->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">City</label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="globe" class="fea icon-sm icons"></i>
                                                <select id="city" name="city_id" class="form-select form-control ps-5">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex">
                                            <button type="submit" class="btn btn-primary ms-2">Save Address</button>
                                            <button type="button" class="btn btn-light" id="cancelEditBtn">Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="mt-4 p-3 bg-light rounded border-start border-4 border-primary">
                                <h6 class="text-primary mb-2"><i data-feather="info" class="icon-xs me-2"></i>Shipping
                                    Information</h6>
                                <p class="text-muted small mb-0">This address will be used as the default for all your
                                    orders. Please ensure your shipping address is accurate to avoid delivery
                                    issues.</p>
                            </div>
                        </div>
                        <div class="tab-pane fade bg-white shadow rounded p-4" id="account" role="tabpanel"
                             aria-labelledby="account-details">
                            <form method="post" action="{{route('website.user.update')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name </label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="user" class="fea icon-sm icons"></i>
                                                <input name="name" id="first-name" type="text"
                                                       class="form-control ps-5" value="{{$user->name}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                                <input name="email" id="email" type="email"
                                                       class="form-control ps-5" value="{{$user->email}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-2 mb-0">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>

                            <h5 class="mt-4">Change Password</h5>
                            <form method="post" action="{{route('website.user.reset.password')}}">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Old Password</label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input type="password" class="form-control ps-5" name="old_password"
                                                       placeholder="old password" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input type="password" class="form-control ps-5" name="new_password"
                                                       placeholder="new password" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Confirm New Password</label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input type="password" class="form-control ps-5" name="confirm_password"
                                                       placeholder="confirm new password" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-2 mb-0">
                                        <button type="submit" class="btn btn-primary">Save Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            let selectedCityId = @json($user->city_id);
            const $editAddressBtn = $('#editAddressBtn');
            const $addressDisplay = $('#addressDisplay');
            const $addressEditForm = $('#addressEditForm');
            const $cancelEditBtn = $('#cancelEditBtn');
            $editAddressBtn.on('click', function () {
                $addressDisplay.hide();
                $addressEditForm.show();
            });

            $cancelEditBtn.on('click', function () {
                $addressEditForm.hide();
                $addressDisplay.show();
            });

            $('#province').on('change', function () {
                let provinceId = $(this).val();

                let url = '{{route('province.get-cities', ':itemId')}}';
                url = url.replace(':itemId', provinceId);

                if(provinceId){
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (data) {
                            let cities = data.data;
                            let citySelect = $('#city');
                            citySelect.empty().append('<option value="">Select a city</option>');

                            $.each(cities, function (key, city) {
                                let isSelected = (city.id == selectedCityId) ? 'selected' : '';
                                citySelect.append(`<option value="${city.id}" ${isSelected}>${city.name}</option>`);
                            });
                        }
                    });
                }

            });

            $('#province').trigger('change');
        });
    </script>
@endsection
