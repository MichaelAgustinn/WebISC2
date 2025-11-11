 <ul class="nav nav-pills flex-column flex-md-row mb-3">
     <li class="nav-item">
         <a class="nav-link {{ Route::is('profile.index') ? 'active' : '' }}" href="{{ route('profile.index') }}"><i
                 class="bx bx-user me-1"></i> Pengaturan Akun</a>
     </li>
     <li class="nav-item">
         <a class="nav-link {{ Route::is('creation.index') ? 'active' : '' }}" href="{{ route('creation.index') }}"><i
                 class="bx bx-link-alt me-1"></i> Lihat Karya</a>
     </li>
     @if (Auth::user()->role == 'Pengurus')
         <li class="nav-item">
             <a class="nav-link {{ Route::is('creation.divisi') ? 'active' : '' }}"
                 href="{{ route('creation.divisi', Auth::user()->profile->divisi) }}"><i
                     class="bx bx-link-alt me-1"></i>
                 Karya Divisi</a>
         </li>
     @endif
 </ul>
