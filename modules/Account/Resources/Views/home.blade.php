@extends('account::layouts.default')

@section('title', 'Akun saya | ')

@php
    $user = Auth::user();
    $important_updates = [
        'nulled_password' => is_null($user->password) && $user->email_verified_at,
        'filled_profile' => is_null($user->getMeta('contact_number')),
    ];
@endphp

@section('content')
    <div class="card card-body d-flex flex-sm-row align-items-center gap-sm-4 rounded border-0 p-4" style="background: linear-gradient(to bottom, #fcf1f1, transparent);">
        <i class="mdi mdi-home-variant-outline mdi-48px text-danger mx-2"></i>
        <div class="text-sm-start text-center">
            <h2 class="mb-1">Selamat datang, {{ $user->name }}!</h2>
            <div class="text-muted">{{ setting('app_long_name') }}.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body bg-light border-0">
                <div class="mb-3"><i class="mdi mdi-account-alert-outline"></i> Important updates</div>
                <div class="list-group border-top-0">
                    @if (count(array_filter(array_values($important_updates))))
                        @if ($important_updates['filled_profile'])
                            <div class="list-group-item d-flex p-4">
                                <i class="mdi mdi-account-edit-outline text-warning me-2"></i>
                                <div>
                                    <div class="text-warning fw-bold">Your profile is not complete</div>
                                    <div class="mb-2">Completeness of your profile is the main requirement for our resource administration.</div>
                                    <a class="btn btn-secondary btn-sm" href="{{ route('account::user.profile') }}">Complete my profile <i class="mdi mdi-arrow-right"></i></a>
                                </div>
                            </div>
                        @endif
                        @if ($important_updates['nulled_password'])
                            <div class="list-group-item d-flex p-4">
                                <i class="mdi mdi-lock-open-outline text-danger me-2"></i>
                                <form class="form-block" method="post" action="{{ route('account::user.password.reset', ['next' => route('account::home')]) }}"> @csrf
                                    <div class="text-danger fw-bold">You are not setting up your password</div>
                                    <div>It seems, you haven't created a password because you logged in via platform, try clicking <button class="btn btn-link mt-n1 text-dark p-0"><u>reset password</u></button> from your verified email.</div>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="list-group-item d-flex p-4">
                            <i class="mdi mdi-check-circle-outline text-success me-2"></i>
                            <div>All is well, there are no one important informations for you.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
