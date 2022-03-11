 <div class="sidebar">
     <div class="sidebar-header">
         <div>
             <a href="{{ url('/') }}" class="sidebar-logo"><span>Gesmar</span></a>
             <small class="sidebar-logo-headline">(site user)</small>
         </div>
     </div><!-- sidebar-header -->
     <div id="dpSidebarBody" class="sidebar-body">
         <ul class="nav nav-sidebar">
             {{-- <li class="nav-label"><label class="content-label">Parametres</label></li> --}}
             <li class="nav-item">
                 <a class="nav-link with-sub {{ request()->is('exploitation*') ? 'active' : '' }}"><i
                         data-feather="activity"></i>Exploitation</a>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Biens & Propriété</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Locataire & Client</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Locations & Baux</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Abonnement Équipement/CIE</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Réservations</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Réservations</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">États des lieux</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Interventions & Réparations</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Inventaires</a>
                 </nav>
             </li>
             <li class="nav-item">
                 <a class="nav-link with-sub">
                     <i data-feather="dollar-sign"></i>Finances & quittancement</a>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Facturation Générale</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Facturation Equipements</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Facturation Charges Copropriété</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Recettes & Dépenses</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Appels de Loyers/Pas-de-porte</a>
                 </nav>
             </li>
             <li class="nav-item">
                 <a class="nav-link with-sub">
                     <i data-feather="file-text"></i>Comptabilité & Paiement</a>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Encaissement/Paiement</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Encaissement Mobile & TPE</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Export/Import SAGE</a>
                 </nav>
             </li>
             <li class="nav-item">
                 <a class="nav-link with-sub">
                     <i data-feather="cpu"></i>Outils & Taches</a>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Quittancement Automatique</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Génération d’Emplacements</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Génération d’Emplacements</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Devis de Location</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Révision de Loyers & Indice</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Forums</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Répertoire</a>
                 </nav>
             </li>
             <li class="nav-item {{ request()->is('parametres*') ? 'show' : '' }}">
                 <a href="" class="nav-link with-sub {{ request()->is('parametres*') ? 'active' : '' }}"><i
                         data-feather="settings"></i>Paramètres</a>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Tarification</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Réglages financiers</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="{{ route('admin.user.index') }}"
                         class="nav-sub-link {{ request()->is('parametres/administration*') ? 'active' : '' }}">Utilisateur
                         & fonctions</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Architecture du marché</a>
                 </nav>
                 <nav class="nav nav-sub">
                     <a href="" class="nav-sub-link">Produits Annexes</a>
                 </nav>
             </li>
         </ul>
     </div><!-- sidebar-body -->
 </div><!-- sidebar -->
