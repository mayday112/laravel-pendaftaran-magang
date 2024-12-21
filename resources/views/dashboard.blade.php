{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
</div>
</x-app-layout> --}}

@extends('layouts.apps')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/ionicons201/css/ionicons.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>
                    {{ __('Dashboard') }}
                </h1>
            </div>

            <div class="section-body">
                <div class="row">
                    @if (Auth::user()->role == 'intern')
                        <div class="col-12 mb-4">
                            <div class="hero align-items-center bg-primary text-white">
                                <div class="hero-inner text-center">
                                    <h2>Halo, {{ Auth::user()->name }}!</h2>
                                    <p class="lead">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi
                                        deserunt et
                                        perspiciatis consequatur ab earum aliquid debitis delectus laboriosam odio.</p>
                                    <div class="mt-4">
                                        @if (!Auth::user()->internship)
                                            <a href="{{ route('intern-create-data') }}"
                                                class="btn btn-outline-white btn-lg btn-icon icon-left"><i
                                                    class="fas fa-sign-in-alt"></i> Daftar Magang</a>
                                        @else
                                            <p>Silakan cek berkala status penerimaan magang anda pada halaman magang</p>
                                            <p>Klik icon <i class="fas fa-bars"></i> pada pojok kiri atas untuk memunculkan
                                                icon menu magang</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12 mb-4">
                            <div class="hero bg-primary text-white">
                                <div class="hero-inner">
                                    <h2>Welcome Back, {{ Auth::user()->name }}!</h2>
                                    <p class="lead">This page is a place to manage posts, categories and more.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-ion-icons.js') }}"></script>
@endpush
