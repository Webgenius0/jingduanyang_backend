<div id="kt_aside" class="aside aside-default  aside-hoverable " data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_toggle">

    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto px-10 pt-9 pb-5" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('admin.dashboard') }}">
            <img alt="Logo" src="{{ asset($systemSetting->logo ?? 'backend/media/logos/logo-default.svg') }}"
                class="max-h-50px logo-default theme-light-show" />


        </a>
        <!--end::Logo-->
    </div>
    <!--end::Brand-->

    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid ps-3 pe-1">
        <!--begin::Aside Menu-->

        <!--begin::Menu-->
        <div class="menu menu-sub-indention menu-column menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-active-bg menu-state-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 mt-lg-2 mb-lg-0"
            id="kt_aside_menu" data-kt-menu="true">

            <div class="hover-scroll-y mx-4" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="20px"
                data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer">

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-element-11 fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.inactive-doctors.index') ? 'active' : '' }}"
                        href="{{ route('admin.inactive-doctors.index') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Inactive Doctor</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.doctors.index') ? 'active' : '' }}"
                        href="{{ route('admin.doctors.index') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Active Doctor</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.clients.index') ? 'active' : '' }}"
                        href="{{ route('admin.clients.index') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Client List</span>
                    </a>
                </div>

                <div class="menu-item">
                    <div class="menu-content">
                        <div class="separator mx-1 my-2"></div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item {{ request()->routeIs(['admin.product_categories.*', 'admin.products.*']) ? 'active show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="24" height="24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor">
                                <path d="M3 21l18 0"></path>
                                <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"></path>
                                <path d="M5 21l0 -10.15"></path>
                                <path d="M19 21l0 -10.15"></path>
                                <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Products</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('admin.product_categories.index') }}"
                                class="menu-link {{ request()->routeIs(['admin.product_categories.*']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Product Category</span>
                            </a>
                            <a href="{{ route('admin.products.index') }}"
                                class="menu-link {{ request()->routeIs(['admin.products.*']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Product</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}"
                        href="{{ route('admin.courses.index') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                <path d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z"></path>
                                <path d="M3 6m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Courses</span>
                    </a>
                </div>

                {{-- <div data-kt-menu-trigger="click"
                    class="menu-item {{ request()->routeIs(['admin.teams.*']) ? 'active show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="fa-regular fa-file fs-2"></i>
                        </span>
                        <span class="menu-title">Teams</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('admin.teams.index') }}"
                                class="menu-link {{ request()->routeIs(['admin.teams.*']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Team</span>
                            </a>

                        </div>
                    </div>
                </div> --}}

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}"
                        href="{{ route('admin.faq.index') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z"></path>
                                <path d="M12 16v.01"></path>
                                <path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Faq</span>
                    </a>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item {{ request()->routeIs(['admin.quizze_categories.*', 'admin.quizze_questions.*']) ? 'active show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z"></path>
                                <path d="M12 8v4"></path>
                                <path d="M12 16h.01"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Quizzes</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('admin.quizze_categories.index') }}"
                                class="menu-link {{ request()->routeIs(['admin.quizze_categories.*']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Quizze Category</span>
                            </a>
                            <a href="{{ route('admin.quizze_questions.index') }}"
                                class="menu-link {{ request()->routeIs(['admin.quizze_questions.*']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Quizze Question</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item {{ request()->routeIs(['admin.blog_categories.*', 'admin.blogs.*']) ? 'active show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                                <path d="M7 8h10"></path>
                                <path d="M7 12h10"></path>
                                <path d="M7 16h10"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Blogs</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('admin.blog_categories.index') }}"
                                class="menu-link {{ request()->routeIs(['admin.blog_categories.*']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Blog Category</span>
                            </a>
                            <a href="{{ route('admin.blogs.index') }}"
                                class="menu-link {{ request()->routeIs(['admin.blogs.*']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Blog</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                        href="{{ route('admin.services.index') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                <path d="M4 13c.325 2.532 1.881 4.781 4 6"></path>
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2"></path>
                                <path d="M4 5v4h4"></path>
                                <path d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2"></path>
                                <path d="M18 15v2a1 1 0 0 0 1 1h1"></path>
                                <path d="M21 15v6"></path>
                              </svg>
                        </span>
                        <span class="menu-title">Service</span>
                    </a>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item {{ request()->routeIs(['cms.home.hero_section','cms.about_us.*','cms.why_choose_us.*','cms.home.help_section.*','cms.home.education.index','cms.home.consultation.index','cms.track_record.*']) ? 'active show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="fa-regular fa-file fs-2"></i>
                        </span>
                        <span class="menu-title">CMS</span>
                        <span class="menu-arrow"></span>
                    </span>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('cms.home.hero_section') }}"
                                class="menu-link {{ request()->routeIs(['cms.home.hero_section']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Hero Section</span>
                            </a>
                        </div>
                    </div>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('cms.home.education.index') }}"
                                class="menu-link {{ request()->routeIs(['cms.home.education.index']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Education Section</span>
                            </a>
                        </div>
                    </div>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('cms.home.consultation.index') }}"
                                class="menu-link {{ request()->routeIs(['cms.home.consultation.index']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Consultation Section</span>
                            </a>
                        </div>
                    </div>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('cms.home.help_section.index') }}"
                                class="menu-link {{ request()->routeIs(['cms.home.help_section.index']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Help Section</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('cms.about_us.index') }}"
                                class="menu-link {{ request()->routeIs(['cms.about_us.index']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">About Us</span>
                            </a>
                        </div>
                    </div>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('cms.track_record.index') }}"
                                class="menu-link {{ request()->routeIs(['cms.track_record.index']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Track Record</span>
                            </a>
                        </div>
                    </div>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('cms.why_choose_us.index') }}"
                                class="menu-link {{ request()->routeIs(['cms.why_choose_us.index']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Why Choose Us</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-item">
                    <div class="menu-content">
                        <div class="separator mx-1 my-2"></div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item {{ request()->routeIs(['faq.*', 'dynamic_page.*']) ? 'active show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="fa-regular fa-file fs-2"></i>
                        </span>
                        <span class="menu-title">Pages</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('dynamic_page.index') }}"
                                class="menu-link {{ request()->routeIs(['dynamic_page.index', 'dynamic_page.create', 'dynamic_page.update']) ? 'active show' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Dynamic Page</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item {{ request()->routeIs(['profile.setting', 'system.index', 'mail.setting', 'social.index']) ? 'active show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="fa-solid fa-gear fs-2"></i>
                        </span>
                        <span class="menu-title">Setting</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a href="{{ route('profile.setting') }}"
                                class="menu-link {{ request()->routeIs('profile.setting') ? 'active' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Profile Setting</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('system.index') }}"
                                class="menu-link {{ request()->routeIs('system.index') ? 'active' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">System Setting</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('mail.setting') }}"
                                class="menu-link {{ request()->routeIs('mail.setting') ? 'active' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Mail Setting</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('social.index') }}"
                                class="menu-link {{ request()->routeIs('social.index') ? 'active' : '' }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Social Media</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
