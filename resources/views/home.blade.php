@extends('layouts.app')

@section('content')
    @can('viewReceptionist')
        <view-receptionist
            :user="{{ auth()->user()->load('role', 'hospital') }}"
            :hospital="{{ App\Hospital::find(Auth()->user()->hospital_id)->load('users', 'consultations', 'patients') }}"
        ></view-receptionist>
    @endcan
    @can('viewAdmin')
        <view-admin></view-admin>
    @endcan
@endsection
