@extends('layouts.default')
@section('content')
    <div class="content-header">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Acceuil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Utilisateurs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Options {{ $user->name }}</li>
                </ol>
            </nav>
            <h4 class="content-title content-title-xs">{{ $titre }}</h4>
        </div>
    </div><!-- content-header -->
    <div class="content-body">
        <div class="row row-xs">
            <div class="col-md-4">
                <ul class="list-group list-group-settings">
                    <li class="list-group-item list-group-item-action">
                        <a href="#paneProfile" data-toggle="tab"
                            class="media {{ $active === $user::ACTIVE_PANEL['info'] ? 'active' : '' }}">
                            <i data-feather="user"></i>
                            <div class="media-body">
                                <h6>Information de profil</h6>
                                <span>Vos informations personnelles</span>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <a href="#paneAccount" data-toggle="tab"
                            class="media {{ $active === $user::ACTIVE_PANEL['comp'] ? 'active' : '' }}">
                            <i data-feather="settings"></i>
                            <div class="media-body">
                                <h6>Compte</h6>
                                <span>Suppression définitive du compte</span>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <a href="#paneSecurity" data-toggle="tab"
                            class="media {{ $active === $user::ACTIVE_PANEL['secu'] ? 'active' : '' }}">
                            <i data-feather="shield"></i>
                            <div class="media-body">
                                <h6>Sécurité</h6>
                                <span>Gestion des mots de passe</span>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <a href="#paneNotification" data-toggle="tab"
                            class="media {{ $active === $user::ACTIVE_PANEL['noti'] ? 'active' : '' }}">
                            <i data-feather="bell"></i>
                            <div class="media-body">
                                <h6>Notifications</h6>
                                <span>Configurer les notifications à recevoir</span>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <a href="#paneBilling" data-toggle="tab"
                            class="media {{ $active === $user::ACTIVE_PANEL['perm'] ? 'active' : '' }}">
                            <i data-feather="users"></i>
                            <div class="media-body">
                                <h6>Permissions</h6>
                                <span>Roles Permissions à assigner</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div><!-- col -->
            <div class="col-md-8">
                <div class="card card-body pd-sm-40 pd-md-30 pd-xl-y-35 pd-xl-x-40">
                    <div class="tab-content">
                        <div id="paneProfile"
                            class="tab-pane {{ $active === $user::ACTIVE_PANEL['info'] ? 'active show' : '' }}">
                            <h6 class="tx-uppercase tx-semibold tx-color-01 mg-b-0">Informations de profil</h6>
                            <hr>
                            <div class="form-settings">
                                <form action="{{ route('admin.user.informations') }}" method="POST"
                                    enctype="multipart/form-data">
                                    <div class="form-group">
                                        @csrf
                                        <input type="text" name='id' hidden value="{{ $user->id }}">
                                        <input type="text" name='panel' hidden value="{{ $user::ACTIVE_PANEL['info'] }}">
                                        <div class="avatar avatar-xxl">
                                            @if (empty($user->avatar))
                                                <img src="https://via.placeholder.com/500/637382/fff" class="rounded-circle"
                                                    alt="">
                                            @else
                                                <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle"
                                                    alt="avatar">
                                            @endif
                                        </div>
                                        <div class="custom-file mg-t-5">
                                            <input name="avatar" type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choix de l'avatar</label>
                                        </div>
                                        <label class="form-label mg-t-5">Nom complet</label>
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Entrer votre nom complet" value="{{ $user->name }}" />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="tx-11 tx-sans tx-color-04 mg-t-5">
                                            Votre nom peut apparaître ici où on parle de vous. Vous pouvez le modifier à
                                            tout moment.
                                        </div>
                                    </div><!-- form-group -->
                                    <div class="form-group">
                                        <label class="form-label">Description Utilisateur</label>
                                        <textarea name="description" class="form-control"
                                            rows="3">{{ $user->description }}</textarea>
                                    </div><!-- form-group -->
                                    <div class="form-group">
                                        <label class="form-label">Aller au profil</label>
                                        <a href="{{ route('admin.user.show', $user->id) }}">lien vers le profile de
                                            l'utilisateur {{ $user->name }}
                                        </a>
                                    </div><!-- form-group -->
                                    <div class="form-group">
                                        <label class="form-label">Adresse</label>
                                        <input name="adresse" type="text"
                                            class="form-control @error('adresse') is-invalid @enderror"
                                            placeholder="Adresse utilisateur" value="{{ $user->adresse }}">
                                    </div><!-- form-group -->
                                    <div class="form-group tx-13 tx-color-04">
                                        vous nous donnez votre consentement pour partager ces données où que vous soyez.
                                    </div>
                                    <hr class="op-0">
                                    <button type="submit" class="btn btn-brand-02">Modifier le profile</button>
                                </form>
                            </div>
                        </div><!-- tab-pane -->
                        <div id="paneAccount"
                            class="tab-pane {{ $active === $user::ACTIVE_PANEL['comp'] ? 'active show' : '' }}">
                            <h6 class="tx-uppercase tx-semibold tx-color-01 mg-b-0">Compte</h6>

                            <hr>
                            <div class="form-settings">
                                <div class="form-group">
                                    <label class="form-label text-danger">Supprimer le compte</label>
                                    <p class="tx-sm tx-color-04">Une fois que vous supprimez votre compte, il n'y a pas de
                                        retour en arrière. S'il vous plaît soyez certain.</p>
                                    <button href="#modal" data-toggle="modal" class="btn btn-sm btn-danger">suppression
                                        du compte</button>
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalLabel">
                                                        Confirmation
                                                        de suppression
                                                    </h6>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i data-feather="x"></i></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mg-b-0">Voulez vous réelement supprimer le compte
                                                        de l'utilisateur: <b>{{ $user->name }}</b></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                        data-dismiss="modal">Close</button>
                                                    <a href="{{ route('admin.user.trash', $user->id) }}"
                                                        class="btn btn-danger">Confirmer</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- form-group -->
                            </div><!-- form-settings -->
                        </div><!-- tab-pane -->
                        <div id="paneSecurity"
                            class="tab-pane {{ $active === $user::ACTIVE_PANEL['secu'] ? 'active show' : '' }}">
                            <h6 class="tx-uppercase tx-semibold tx-color-01 mg-b-0">Option de sécurité</h6>
                            <hr>
                            <div class="form-settings">
                                <form action="{{ route('admin.user.securite') }}" method="post">
                                    <div class="form-group">
                                        @csrf
                                        <input type="text" name='id' hidden value="{{ $user->id }}">
                                        <input type="text" name='panel' hidden value="{{ $user::ACTIVE_PANEL['secu'] }}">
                                        <label class="form-label">Modifier ancien mot de passe</label>
                                        <input name="oldPassword" type="password"
                                            class="form-control @error('oldPassword') is-invalid @enderror"
                                            placeholder="Ancien mot de passe">
                                        @error('oldPassword')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <input name="password" type="text"
                                            class="form-control @error('password') is-invalid @enderror mg-t-5"
                                            placeholder="Nouveau mot de passe">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <input name="password_confirmation" type="text" class="form-control mg-t-5"
                                            placeholder="Confirmation nouveau mot de passe">
                                    </div><!-- form-group -->
                                    <button type="submit" class="btn btn-brand-02">Modifier mot de passe</button>
                                </form>
                            </div><!-- form-settings -->
                        </div><!-- tab-pane -->
                        <div id="paneNotification"
                            class="tab-pane {{ $active === $user::ACTIVE_PANEL['noti'] ? 'active show' : '' }}">
                            <h6 class="tx-uppercase tx-semibold tx-color-01 mg-b-0">Parametre de notification</h6>
                            <hr>
                            <div class="form-settings mx-wd-100p">
                                <div class="form-group">
                                    <label class="form-label mg-b-2">Alertes de sécurité</label>
                                    <p class="tx-sm tx-color-04">Recevoir les alertes de sécurité par email</p>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Email each time a
                                            vulnerability is found</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2">Email a digest summary of
                                            vulnerabilities</label>
                                    </div>
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <input type="text" name='panel' hidden value="{{ $user::ACTIVE_PANEL['noti'] }}">
                                    <label class="form-label">SMS Notifications</label>
                                    <ul class="list-group list-group-notification">
                                        <li class="list-group-item">
                                            <p class="mg-b-0">Comments</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                                <label class="custom-control-label" for="customSwitch1">&nbsp;</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <p class="mg-b-0">Updates From People</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                                <label class="custom-control-label" for="customSwitch2">&nbsp;</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <p class="mg-b-0">Reminders</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch3">
                                                <label class="custom-control-label" for="customSwitch3">&nbsp;</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <p class="mg-b-0">Events</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch4">
                                                <label class="custom-control-label" for="customSwitch4">&nbsp;</label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <p class="mg-b-0">Pages You Follow</p>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch5">
                                                <label class="custom-control-label" for="customSwitch5">&nbsp;</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div><!-- form-group -->
                            </div><!-- form-setting -->
                        </div><!-- tab-pane -->
                        <div id="paneBilling"
                            class="tab-pane {{ $active === $user::ACTIVE_PANEL['perm'] ? 'active show' : '' }}">
                            <h6 class="tx-uppercase tx-semibold tx-color-01 mg-b-0">Billing Settings</h6>
                            <hr>
                            <div class="form-settings mx-wd-100p">
                                <div class="form-group">
                                    <input type="text" name='panel' hidden value="{{ $user::ACTIVE_PANEL['perm'] }}">
                                    <label class="form-label mg-b-2">Payment Method</label>
                                    <p class="tx-color-04 tx-13">You have not added a payment method</p>
                                    <button class="btn btn-brand-02 btn-sm">Add Payment Method</button>
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <label class="form-label">Payment History</label>
                                    <div class="bd bg-gray-100 pd-20 tx-center">
                                        <p class="tx-13 mg-b-0">You have not made any payment.</p>
                                    </div>
                                </div><!-- form-group -->
                            </div><!-- form-settings -->
                        </div><!-- tab-pane -->
                    </div><!-- tab-content -->
                </div><!-- card -->
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- content-body -->
@endsection
@section('scripts')
    <script>
        $(function() {
            'use strict'
            // File Browser
            $('#customFile').on('change', function() {
                var va = $(this).val().split('\\');
                $(this).next().text(va[2]);
            })
        });
    </script>
@endsection
