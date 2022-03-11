@extends('layouts.default')
@section('content')
    <div class="content-header">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Acceuil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Utilisateurs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile {{ $user->name }}</li>
                </ol>
            </nav>
            <h4 class="content-title content-title-xs">{{ $titre }}</h4>
        </div>
    </div><!-- content-header -->
    <div class="content-body content-body-profile">
        <div class="profile-sidebar">
            <div class="profile-sidebar-header">
                <div class="avatar">
                    @if (empty($user->avatar))
                        <img src="https://via.placeholder.com/500/637382/fff" class="rounded-circle" alt="">
                    @else
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle" alt="avatar">
                    @endif
                </div>
                <h5>{{ $user->name }}</h5>
                <p>UI Developer (Savior of Mankind)</p>
                <span>{{ $user->adresse }}</span>

                {{-- <div class="d-flex align-self-stretch mg-t-30">
                    <a href="" class="btn btn-brand-01 btn-sm btn-uppercase flex-fill">Follow</a>
                    <a href="" class="btn btn-white btn-sm btn-uppercase flex-fill mg-l-5">Message</a>
                </div> --}}
            </div><!-- profile-sidebar-header -->
            <div class="profile-sidebar-body">

                {{-- <label class="content-label">Websites &amp; Social Channel</label>
                <ul class="list-unstyled profile-info-list">
                    <li><i data-feather="globe"></i> <a href="">http://fenchiumao.me/</a></li>
                    <li><i data-feather="github"></i> <a href="">@fenchiumao</a></li>
                    <li><i data-feather="twitter"></i> <a href="">@fenmao</a></li>
                    <li><i data-feather="instagram"></i> <a href="">@fenchiumao</a></li>
                    <li><i data-feather="facebook"></i> <a href="">@fenchiumao</a></li>
                </ul>

                <hr class="mg-y-25"> --}}

                <label class="content-label">Contact Information</label>
                <ul class="list-unstyled profile-info-list mg-b-0">
                    <li><i data-feather="briefcase"></i> <span class="tx-color-03">Bay Area, San Francisco, CA</span>
                    </li>
                    <li><i data-feather="home"></i> <span class="tx-color-03">{{ $user->adresse }}</span></li>
                    <li><i data-feather="smartphone"></i> <a href="">(+1) 012 345 6789</a></li>
                    <li><i data-feather="phone"></i> <a href="">(+1) 987 654 3201</a></li>
                    <li><i data-feather="mail"></i> <a href="">{{ $user->email }}</a></li>
                </ul>
            </div><!-- profile-sidebar-body -->
        </div><!-- profile-sidebar -->
        <div class="profile-body">
            <div class="profile-body-header">
                <div class="nav-wrapper">
                    <ul class="nav nav-line" id="profileTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab"
                                aria-controls="overview" aria-selected="true">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="projects-tab" data-toggle="tab" href="#timeline" role="tab"
                                aria-controls="projects" aria-selected="false">Projects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="people-tab" data-toggle="tab" href="#people" role="tab"
                                aria-controls="people" aria-selected="false">Connections</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                                aria-controls="settings" aria-selected="false">Settings</a>
                        </li>
                    </ul>
                </div><!-- nav-wrapper -->
            </div><!-- profile-body-header -->
            <div class="tab-content pd-15 pd-sm-20">
                <div id="overview" class="tab-pane active show">

                    <div class="stat-profile">
                        <div class="stat-profile-body">
                            <div class="row row-xs">
                                <div class="col">
                                    <div class="card card-body pd-10 pd-md-15 bd-0 shadow-none bg-primary-light">
                                        <h1 class="tx-light tx-sans tx-spacing--4 tx-primary mg-b-5">102</h1>
                                        <p class="tx-13 tx-lg-14 tx-color-02 mg-b-0">Your profile visitors</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card card-body pd-10 pd-md-15 bd-0 shadow-none bg-teal-light">
                                        <h1 class="mg-b-5 tx-sans tx-spacing--2 tx-light tx-teal">961</h1>
                                        <p class="tx-13 tx-lg-14 tx-color-03 mg-b-0">Search appearances</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card card-body pd-10 pd-md-15 bd-0 shadow-none bg-pink-light">
                                        <h1 class="mg-b-5 tx-sans tx-spacing--2 tx-light tx-pink">665</h1>
                                        <p class="tx-13 tx-lg-14 tx-color-03 mg-b-0">Your activity views</p>
                                    </div>
                                </div>
                            </div><!-- row -->
                        </div><!-- stat-profile-body -->
                    </div><!-- stat-profile -->

                    <hr class="mg-y-15 op-0">

                    <label class="content-label content-label-lg mg-b-15 tx-color-01">Description</label>
                    <p class="tx-color-03">{{ $user->description }} </p>

                    <hr class="mg-y-15 op-0">

                    <label class="content-label content-label-lg mg-b-15 tx-color-01">Work Experience</label>
                    <ul class="list-unstyled media-list-profile">
                        <li class="media">
                            <div class="wd-40 ht-40 bg-teal op-5"></div>
                            <div class="media-body">
                                <h6 class="mg-b-5 tx-semibold">Themepixels, Inc. LTD</h6>
                                <p class="tx-color-03 tx-13">January 2016 - Present</p>
                                <p>An online-based high performing web and mobile development company, with a passion for
                                    making high quality web-based application and services for businesses and organization.
                                </p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="wd-40 ht-40 bg-primary op-5"></div>
                            <div class="media-body">
                                <h6 class="mg-b-5 tx-semibold">Berkeley Systems, Inc.</h6>
                                <p class="tx-color-03 tx-13">December 2012 - November 2015</p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="wd-40 ht-40 bg-pink op-5"></div>
                            <div class="media-body">
                                <h6 class="mg-b-5 tx-semibold">Berkeley Systems, Inc.</h6>
                                <p class="tx-color-03 tx-13">December 2012 - November 2015</p>
                            </div>
                        </li>
                    </ul><!-- media-list-profile -->

                    <hr class="mg-y-15 op-0">

                    <label class="content-label content-label-lg mg-b-15 tx-color-01">Educational Background</label>
                    <ul class="list-unstyled media-list-profile">
                        <li class="media">
                            <div class="wd-40 ht-40 bg-gray-400"></div>
                            <div class="media-body">
                                <h6 class="mg-b-5 tx-semibold">Graduate in BS in Computer Science</h6>
                                <p class="tx-color-03 tx-13">Hold Name University class 2006</p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="wd-40 ht-40 bg-gray-400"></div>
                            <div class="media-body">
                                <h6 class="mg-b-5 tx-semibold">Sacred Heart Academy</h6>
                                <p class="tx-color-03 tx-13">High school graduate class 2002</p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="wd-40 ht-40 bg-gray-400"></div>
                            <div class="media-body">
                                <h6 class="mg-b-5 tx-semibold">Loon Central Elementary School</h6>
                                <p class="tx-color-03 tx-13">Elmentary graduate class 1998</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- tab-content -->
        </div><!-- profile-body -->
    </div><!-- content-body -->
@endsection
@section('scripts')
    <script>
        $(function() {
            'use strict'
            $('#profileMenu').on('click', function(e) {
                e.preventDefault();
                $('body').addClass('profile-menu-show');
                $('#mainMenu').removeClass('d-none');
                $(this).addClass('d-none');
            })

        })
    </script>
@endsection
