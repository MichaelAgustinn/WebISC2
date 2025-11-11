 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="{{ route('dashboard') }}" class="app-brand-link">
             <img src="{{ asset('landing/assets/img/logo-isc.webp') }}" style="max-width: 40px" alt="">
             <span class="app-brand-text demo menu-text fw-bolder ms-2">isc</span>
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
             <i class="bx bx-chevron-left bx-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1">
         <!-- Dashboard -->
         <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
             <a href="{{ route('dashboard') }}" class="menu-link">
                 <i class="menu-icon tf-icons bx bx-home-circle"></i>
                 <div data-i18n="Analytics">Dashboard</div>
             </a>
         </li>


         @if (Auth::user()->role === 'Admin' || Auth::user()->role === 'Pengurus')
             <li class="menu-item {{ Route::is('verif.index') ? 'active' : '' }}">
                 <a href="{{ route('verif.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-contact"></i>
                     <div data-i18n="Analytics">Verifikasi Anggota</div>
                 </a>
             </li>

             {{-- ? landing page form --}}
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">form input</span>
             </li>

             <li class="menu-item {{ Route::is('form.landing') ? 'active' : '' }}">
                 <a href="{{ route('form.landing') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-collection"></i>
                     <div data-i18n="Basic">Landing Page</div>
                 </a>
             </li>

             <li class="menu-item {{ Route::is('blog.create') ? 'active' : '' }}">
                 <a href="{{ route('blog.create') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                     <div data-i18n="Basic">Form Blog</div>
                 </a>
             </li>
         @endif

         @if (Auth::user()->role != 'None')
             {{-- ? karya area --}}
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">form karya</span>
             </li>

             <li class="menu-item {{ Route::is('creation.index') ? 'active' : '' }}">
                 <a href="{{ route('creation.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-collection"></i>
                     <div data-i18n="Basic">Lihat Karya</div>
                 </a>
             </li>

             <li class="menu-item {{ Route::is('creation.create') ? 'active' : '' }}">
                 <a href="{{ route('creation.create') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                     <div data-i18n="Basic">Form Karya</div>
                 </a>
             </li>
             {{-- ? karya area end --}}
         @endif

         @if (Auth::user()->role === 'Admin' || Auth::user()->role === 'Pengurus')
             {{-- ? information area --}}
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">form information</span>
             </li>

             {{-- ? fungsi lihat surat --}}
             <li class="menu-item {{ Route::is('letters.index') ? 'active' : '' }}">
                 <a href="{{ route('letters.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-file-archive"></i>
                     <div data-i18n="Basic">Lihat Surat</div>
                 </a>
             </li>
             {{-- ? fungsi lihat surat end --}}

             {{-- ? untuk lihat document di landingpage --}}
             <li class="menu-item {{ Route::is('information.index') ? 'active' : '' }}">
                 <a href="{{ route('information.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-file-archive"></i>
                     <div data-i18n="Basic">Lihat Document Information</div>
                 </a>
             </li>

             <li class="menu-item {{ Route::is('information.create') ? 'active' : '' }}">
                 <a href="{{ route('information.create') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-file-plus"></i>
                     <div data-i18n="Basic">Form Document Information</div>
                 </a>
             </li>
             {{-- ? untuk lihat document di landingpage end --}}


             {{-- ? FAQ Area --}}
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">FAQ - Landing</span>
             </li>

             <li class="menu-item {{ Route::is('faq.index') ? 'active' : '' }}">
                 <a href="{{ route('faq.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-question-mark"></i>
                     <div data-i18n="Basic">FAQ - Lihat</div>
                 </a>
             </li>
             <li class="menu-item {{ Route::is('faq.landing') ? 'active' : '' }}">
                 <a href="{{ route('faq.landing') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                     <div data-i18n="Basic">FAQ - Tambah</div>
                 </a>
             </li>
             {{-- ? FAQ Area End --}}

             {{-- ? Logo Area --}}
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Logo - Landing</span>
             </li>

             <li class="menu-item {{ Route::is('logo.index') ? 'active' : '' }}">
                 <a href="{{ route('logo.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-collection"></i>
                     <div data-i18n="Basic">Logo - Lihat</div>
                 </a>
             </li>
             <li class="menu-item {{ Route::is('logo.landing') ? 'active' : '' }}">
                 <a href="{{ route('logo.landing') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                     <div data-i18n="Basic">logo - Tambah</div>
                 </a>
             </li>
             {{-- ? Logo Area End --}}

             {{-- ? testimonial form area --}}
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Testimonial - Landing</span>
             </li>
             <li class="menu-item {{ Route::is('testimonial.index') ? 'active' : '' }}">
                 <a href="{{ route('testimonial.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-collection"></i>
                     <div data-i18n="Basic">Testimonial - Lihat</div>
                 </a>
             </li>
             <li class="menu-item {{ Route::is('testimonial.create') ? 'active' : '' }}">
                 <a href="{{ route('testimonial.create') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                     <div data-i18n="Basic">Testimonial - Tambah</div>
                 </a>
             </li>
             {{-- ? testimonial form area end --}}

             {{-- ? mentor area --}}
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Pimpinan - Form</span>
             </li>
             <li class="menu-item {{ Route::is('mentor.index') ? 'active' : '' }}">
                 <a href="{{ route('mentor.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-collection"></i>
                     <div data-i18n="Basic">Pembimbing - Lihat</div>
                 </a>
             </li>
             <li class="menu-item {{ Route::is('mentor.create') ? 'active' : '' }}">
                 <a href="{{ route('mentor.create') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                     <div data-i18n="Basic">Pembimbing - Tambah</div>
                 </a>
             </li>
             <li class="menu-item {{ Route::is('pengurus.index') ? 'active' : '' }}">
                 <a href="{{ route('pengurus.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-collection"></i>
                     <div data-i18n="Basic">Pengurus - Lihat</div>
                 </a>
             </li>
             <li class="menu-item {{ Route::is('pengurus.create') ? 'active' : '' }}">
                 <a href="{{ route('pengurus.create') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                     <div data-i18n="Basic">Pengurus - Tambah</div>
                 </a>
             </li>
             {{-- ? mentor area end --}}

             {{-- ? footer form area --}}
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Footer - Landing</span>
             </li>
             <li class="menu-item {{ Route::is('footer.index') ? 'active' : '' }}">
                 <a href="{{ route('footer.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                     <div data-i18n="Basic">Footer - Lihat</div>
                 </a>
             </li>
             {{-- ? footer form area end --}}
         @endif
     </ul>
 </aside>
