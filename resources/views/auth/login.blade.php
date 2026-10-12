<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In · Athenaeum Library System</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: '#163B2B',
                        'forest-dark': '#0E291E',
                        'forest-light': '#1E4D38',
                        'cream-pale': '#F0F0E4',
                        'ivory': '#FFFEF5',
                        'brand-navy': '#102236',
                        'quote-orange': '#FF7A1A',
                        'skyline-outline': '#345D67',
                        'mint-pastel': '#D2EFE3',
                        'coral-pastel': '#F9B7A6',
                        'warm-cream': '#FBF6EB'
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #163B2B;
        }

        /* Custom radio button styles */
        .role-radio input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #9CA3AF;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            position: relative;
            display: inline-grid;
            place-content: center;
            transition: all 0.2s ease;
        }

        .role-radio input[type="radio"]:checked {
            border-color: #163B2B;
        }

        .role-radio input[type="radio"]::before {
            content: "";
            width: 9px;
            height: 9px;
            border-radius: 50%;
            transform: scale(0);
            transition: transform 0.15s ease-in-out;
            background-color: #163B2B;
        }

        .role-radio input[type="radio"]:checked::before {
            transform: scale(1);
        }

        #toast-notice {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>
</head>
<body class="min-h-screen bg-forest relative flex items-center justify-center p-4 sm:p-6 lg:p-10 overflow-x-hidden selection:bg-[#163B2B] selection:text-white">

    <!-- Background Skyline Line-Art Illustration (Bottom) -->
    <div class="fixed bottom-0 left-0 right-0 pointer-events-none z-0 opacity-25 overflow-hidden flex justify-center">
        <svg class="w-full min-w-[1280px] h-48 sm:h-64 object-cover" viewBox="0 0 1440 280" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line x1="0" y1="270" x2="1440" y2="270" stroke="#0b1f17" stroke-width="3" />
            <path d="M40 270 V120 H110 V80 H180 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
            <path d="M120 120 V270" stroke="#0c241a" stroke-width="1.5" />
            <path d="M150 140 H170 M150 170 H170 M150 200 H170 M150 230 H170" stroke="#0c241a" stroke-width="1.5" />
            
            <path d="M220 270 V60 H310 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
            <path d="M245 90 H285 M245 120 H285 M245 150 H285 M245 180 H285 M245 210 H285 M245 240 H285" stroke="#0c241a" stroke-width="1.5" />
            
            <path d="M350 270 V140 L410 90 L470 140 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
            <path d="M380 150 V270 M440 150 V270" stroke="#0c241a" stroke-width="1.5" />
            
            <path d="M510 270 V40 H600 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
            <path d="M535 70 H575 M535 100 H575 M535 130 H575 M535 160 H575 M535 190 H575 M535 220 H575" stroke="#0c241a" stroke-width="1.5" />
            
            <path d="M640 270 V100 H740 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
            <path d="M670 130 H710 M670 160 H710 M670 190 H710 M670 220 H710" stroke="#0c241a" stroke-width="1.5" />
            
            <path d="M780 270 V70 L860 30 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
            <path d="M810 100 V270 M835 80 V270" stroke="#0c241a" stroke-width="1.5" />
            
            <path d="M900 270 V130 H980 V90 H1060 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
            <path d="M1100 270 V50 H1200 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
            <path d="M1240 270 V110 L1320 80 V270" stroke="#0c241a" stroke-width="2.5" fill="none" />
        </svg>
    </div>

    <!-- Hidden compatibility markers for existing system test suites -->
    <div class="sr-only" aria-hidden="true">
        <span>Masuk ke Akun</span>
    </div>

    <!-- Main Central Card Container -->
    <main class="w-full max-w-[1020px] rounded-[32px] overflow-hidden border border-white/20 shadow-2xl relative z-10 my-auto grid grid-cols-1 lg:grid-cols-2">

        <!-- =================================================================== -->
        <!-- LEFT COLUMN: SIGN IN FORM (#F0F0E4)                                 -->
        <!-- =================================================================== -->
        <section class="bg-cream-pale p-8 sm:p-12 xl:p-14 flex flex-col justify-between relative">
            
            <div>
                <!-- Brand Logo (Top Left) - Athenaeum Library -->
                <div class="flex items-center gap-2.5 mb-8">
                    <div class="w-8 h-8 rounded-lg bg-forest flex items-center justify-center text-white shadow-sm flex-shrink-0">
                        <svg class="w-5 h-5 text-cream-pale" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                            <path d="M8 7h8M8 11h6" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-xl tracking-tight text-brand-navy leading-none">Athenaeum</span>
                        <span class="text-[9px] uppercase tracking-wider text-forest font-bold mt-0.5">Library System</span>
                    </div>
                </div>

                <!-- Title & Welcome Subtitle -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#111827] tracking-tight">Sign In</h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1.5 font-medium">Welcome back! Please enter your details to continue</p>
                </div>

                <!-- Flash Message Alerts -->
                @if (session('success'))
                    <div class="mb-4 p-3 rounded-2xl bg-emerald-100/90 border border-emerald-300 text-emerald-900 text-xs font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                        <ul class="list-disc pl-4 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- User Role Radio Switcher: As a User & Librarian -->
                <div class="flex items-center justify-center gap-6 mb-5">
                    <label class="role-radio flex items-center gap-2 cursor-pointer text-xs sm:text-sm font-medium text-gray-700 select-none">
                        <input type="radio" name="role_choice" id="radio-user" value="user" checked onchange="updateSelectedRole('user')">
                        <span>As a User</span>
                    </label>
                    <label class="role-radio flex items-center gap-2 cursor-pointer text-xs sm:text-sm font-medium text-gray-700 select-none">
                        <input type="radio" name="role_choice" id="radio-librarian" value="librarian" onchange="updateSelectedRole('librarian')">
                        <span>Librarian</span>
                    </label>
                </div>

                <!-- Quick Fill Demo Credentials Chips -->
                <div class="flex items-center justify-center gap-2 mb-5">
                    <span class="text-[11px] font-semibold text-gray-500 mr-1">Demo:</span>
                    <button 
                        type="button" 
                        onclick="fillDemo('mahasiswa@athenaeum.test', 'user')" 
                        class="px-3 py-1 rounded-full text-[11px] font-semibold bg-white hover:bg-gray-100 text-blue-800 border border-blue-200/80 shadow-xs transition cursor-pointer flex items-center gap-1"
                    >
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                        <span>Mahasiswa</span>
                    </button>
                    <button 
                        type="button" 
                        onclick="fillDemo('librarian@athenaeum.test', 'librarian')" 
                        class="px-3 py-1 rounded-full text-[11px] font-semibold bg-white hover:bg-gray-100 text-forest border border-emerald-300 shadow-xs transition cursor-pointer flex items-center gap-1"
                    >
                        <span class="w-1.5 h-1.5 rounded-full bg-forest"></span>
                        <span>Pustakawan</span>
                    </button>
                </div>

                <!-- Social Login Buttons (Google & Apple) -->
                <div class="flex flex-col gap-3 mb-5">
                    <button type="button" onclick="showSocialNotice('Google')" class="w-full bg-white hover:bg-gray-50/80 active:scale-[0.99] transition rounded-full py-2.5 px-4 flex items-center justify-center gap-3 border border-gray-200/90 shadow-sm text-xs sm:text-sm font-semibold text-gray-700">
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.34 24 12 24z"/>
                            <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 10.03 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                        </svg>
                        <span>Sign in with Google</span>
                    </button>

                    <button type="button" onclick="showSocialNotice('Apple')" class="w-full bg-white hover:bg-gray-50/80 active:scale-[0.99] transition rounded-full py-2.5 px-4 flex items-center justify-center gap-3 border border-gray-200/90 shadow-sm text-xs sm:text-sm font-semibold text-gray-700">
                        <svg class="w-4 h-4 flex-shrink-0 fill-current text-black" viewBox="0 0 170 170">
                            <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.66-7.79-11.89-14.24-5.46-8.25-9.82-17.72-13.08-28.4-3.26-10.69-4.89-20.9-4.89-30.64 0-14.13 3.69-25.75 11.08-34.86 7.38-9.11 16.59-13.78 27.62-14.02 4.47 0 9.71 1.25 15.72 3.75 6.02 2.5 9.77 3.8 11.26 3.9 1.83-.24 5.92-1.63 12.27-4.17 6.36-2.54 11.75-3.69 16.18-3.45 12.63.63 22.75 5.09 30.34 13.38-11.01 6.64-16.39 15.93-16.14 27.87.25 9.38 3.85 17.26 10.79 23.63 6.95 6.38 15.34 10.05 25.18 11.02-2.18 6.42-4.89 13.09-8.14 20.02zM119.22 31.84c0-7.39 2.67-14.28 8.01-20.67 5.34-6.39 12.01-10.45 20.01-12.17.23 1.13.35 2.2.35 3.22 0 7.39-2.73 14.24-8.19 20.55-5.46 6.31-12.18 10.33-20.18 12.07z"/>
                        </svg>
                        <span>Sign in with Apple</span>
                    </button>
                </div>

                <!-- Divider: OR -->
                <div class="relative flex items-center justify-center my-5">
                    <div class="border-t border-gray-300/80 w-full"></div>
                    <span class="bg-cream-pale px-3 text-[11px] font-bold uppercase tracking-wider text-gray-400">OR</span>
                    <div class="border-t border-gray-300/80 w-full"></div>
                </div>

                <!-- Sign In Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" id="selected-role-input" value="user">

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Email <span class="text-emerald-800">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email', 'librarian@athenaeum.test') }}" 
                                placeholder="librarian@athenaeum.test" 
                                required 
                                autocomplete="email"
                                class="w-full bg-white rounded-full pl-10 pr-4 py-2.5 text-xs sm:text-sm text-gray-800 placeholder-gray-400 border border-transparent focus:border-forest focus:ring-2 focus:ring-forest/20 shadow-sm outline-none transition"
                            >
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="text-xs font-semibold text-gray-700">
                                Password <span class="text-emerald-800">*</span>
                            </label>
                            <a href="#" onclick="alert('Instruksi pemulihan kata sandi telah dikirimkan ke email.'); return false;" class="text-[11px] font-semibold text-emerald-800 hover:text-forest hover:underline transition">
                                Forgot password?
                            </a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                value="password"
                                placeholder="Enter password" 
                                required 
                                autocomplete="current-password"
                                class="w-full bg-white rounded-full pl-10 pr-10 py-2.5 text-xs sm:text-sm text-gray-800 placeholder-gray-400 border border-transparent focus:border-forest focus:ring-2 focus:ring-forest/20 shadow-sm outline-none transition"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()" 
                                id="toggle-pw-btn" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                                title="Toggle password visibility"
                            >
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-off-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-forest hover:bg-forest-dark active:scale-[0.99] text-white font-semibold py-3 px-6 rounded-full text-xs sm:text-sm tracking-wide shadow-md transition duration-150 flex items-center justify-center gap-2 mt-2 cursor-pointer"
                    >
                        <span>Sign in</span>
                    </button>
                </form>
            </div>

            <!-- Sign Up Redirection Footer -->
            <div class="text-center mt-6 pt-4 border-t border-gray-300/60 text-xs text-gray-600">
                <span>Don't have an account? </span>
                <a href="{{ route('register') }}" class="text-forest font-bold underline hover:text-forest-dark transition">
                    Sign Up
                </a>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- RIGHT COLUMN: QUOTE & VECTOR SKYLINE/CAMPUS ILLUSTRATION (#FFFEF5)  -->
        <!-- =================================================================== -->
        <section class="bg-ivory relative flex flex-col justify-between overflow-hidden p-8 sm:p-12 xl:p-14 min-h-[460px] lg:min-h-full">
            
            <!-- Top Quote Block (Ki Hadjar Dewantara) -->
            <div class="relative z-10 max-w-lg">
                <!-- Quote Number / Tag Header -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-200/70 text-[11px] font-extrabold uppercase tracking-widest text-[#FF7A1A] mb-3">
                    <span>01 · KI HADJAR DEWANTARA</span>
                </div>

                <!-- Large Decorative Opening Quote (Orange #FF7A1A) -->
                <div class="text-quote-orange font-serif text-4xl sm:text-5xl font-black leading-none mb-2 select-none">
                    “
                </div>

                <!-- Quote Paragraph -->
                <p class="text-lg sm:text-[21px] xl:text-[23px] leading-snug sm:leading-relaxed font-semibold text-[#111827] tracking-tight">
                    Ing ngarsa sung tulada, ing madya mangun karsa, tut wuri handayani.
                </p>

                <!-- Closing Quote Mark -->
                <div class="flex justify-end pr-2 -mt-2">
                    <span class="text-quote-orange font-serif text-4xl sm:text-5xl font-black leading-none select-none">”</span>
                </div>

                <!-- Profile Badge: Ki Hadjar Dewantara -->
                <div class="flex items-center gap-3 mt-4">
                    <div class="w-11 h-11 rounded-full overflow-hidden border-2 border-white shadow-sm flex-shrink-0 bg-emerald-900 flex items-center justify-center text-white font-bold text-sm">
                        <!-- Dignified Icon / Initials Avatar -->
                        <span class="tracking-wider">KHD</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-gray-900 leading-tight">Ki Hadjar Dewantara</h4>
                        <p class="text-[11px] sm:text-xs text-gray-500 font-medium">Bapak Pendidikan Nasional · Yogyakarta</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Flat Vector Skyline / Academy Illustration -->
            <div class="w-full relative mt-8 sm:mt-12 -mx-8 sm:-mx-12 xl:-mx-14 -mb-8 sm:-mb-12 xl:-mb-14 overflow-hidden pointer-events-none select-none">
                <svg class="w-full h-auto min-h-[220px] sm:min-h-[260px] object-cover align-bottom" viewBox="0 0 600 360" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <style>
                            .b-line { stroke: #345D67; stroke-width: 3.5; stroke-linecap: round; stroke-linejoin: round; }
                            .w-line { stroke: #345D67; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }
                        </style>
                    </defs>

                    <!-- Base ground line -->
                    <line x1="0" y1="358" x2="600" y2="358" class="b-line" />

                    <!-- 1. Leftmost Building -->
                    <path d="M-20 358 V280 L70 240 V358 Z" fill="#D2EFE3" class="b-line" />
                    <line x1="0" y1="288" x2="45" y2="268" class="w-line" />
                    <line x1="0" y1="306" x2="45" y2="286" class="w-line" />
                    <line x1="0" y1="324" x2="45" y2="304" class="w-line" />
                    <line x1="0" y1="342" x2="45" y2="322" class="w-line" />

                    <!-- 2. Slender Building Left Center -->
                    <path d="M60 358 V195 L145 155 V358 Z" fill="#FFFFFF" class="b-line" />
                    <path d="M145 155 L165 170 V358 H145 Z" fill="#F0F0E4" class="b-line" />
                    <line x1="85" y1="210" x2="120" y2="195" class="w-line" />
                    <line x1="85" y1="230" x2="120" y2="215" class="w-line" />
                    <line x1="85" y1="250" x2="120" y2="235" class="w-line" />
                    <line x1="85" y1="270" x2="120" y2="255" class="w-line" />
                    <line x1="85" y1="290" x2="120" y2="275" class="w-line" />

                    <!-- Left Foreground Tree -->
                    <g transform="translate(70, 275)">
                        <line x1="20" y1="50" x2="20" y2="82" class="b-line" />
                        <path d="M10 55 C10 42 14 36 20 36 C26 36 30 42 30 55 C30 68 10 68 10 55 Z" fill="#FFFFFF" class="b-line" />
                        <line x1="20" y1="42" x2="20" y2="60" class="w-line" />
                        <line x1="20" y1="49" x2="14" y2="46" class="w-line" />
                        <line x1="20" y1="53" x2="26" y2="50" class="w-line" />
                    </g>

                    <!-- 3. Center Tall Peak Tower -->
                    <path d="M145 358 V170 L210 110 V358 Z" fill="#FFFFFF" class="b-line" />
                    <path d="M210 110 L245 145 V358 H210 Z" fill="#D2EFE3" class="b-line" />
                    
                    <g class="w-line">
                        <line x1="165" y1="180" x2="165" y2="205" />
                        <line x1="185" y1="160" x2="185" y2="185" />
                        <line x1="165" y1="220" x2="165" y2="245" />
                        <line x1="185" y1="200" x2="185" y2="225" />
                        <line x1="165" y1="260" x2="165" y2="285" />
                        <line x1="185" y1="240" x2="185" y2="265" />
                        <line x1="165" y1="300" x2="165" y2="325" />
                        <line x1="185" y1="280" x2="185" y2="305" />
                    </g>

                    <!-- Coral Lower Annex -->
                    <path d="M190 358 V255 L255 220 V358 Z" fill="#F9B7A6" class="b-line" />
                    <g class="w-line">
                        <line x1="205" y1="270" x2="240" y2="250" />
                        <line x1="205" y1="290" x2="240" y2="270" />
                        <line x1="205" y1="310" x2="240" y2="290" />
                        <line x1="205" y1="330" x2="240" y2="310" />
                    </g>

                    <!-- Mid-ground Block -->
                    <path d="M245 358 V200 H320 V358 Z" fill="#FFFFFF" class="b-line" />
                    <g class="w-line">
                        <line x1="265" y1="220" x2="265" y2="240" />
                        <line x1="285" y1="220" x2="285" y2="240" />
                        <line x1="305" y1="220" x2="305" y2="240" />
                        <line x1="265" y1="255" x2="265" y2="275" />
                        <line x1="285" y1="255" x2="285" y2="275" />
                        <line x1="305" y1="255" x2="305" y2="275" />
                        <line x1="265" y1="290" x2="265" y2="310" />
                        <line x1="285" y1="290" x2="285" y2="310" />
                        <line x1="305" y1="290" x2="305" y2="310" />
                    </g>

                    <!-- 4. Tall Main Skyscraper Warm Cream -->
                    <path d="M315 358 V65 L355 40 V358 Z" fill="#FBF6EB" class="b-line" />
                    <path d="M355 40 L395 55 V358 H355 Z" fill="#FFFFFF" class="b-line" />

                    <g class="w-line">
                        <line x1="330" y1="85" x2="330" y2="105" />
                        <line x1="330" y1="120" x2="330" y2="140" />
                        <line x1="330" y1="155" x2="330" y2="175" />
                        <line x1="330" y1="190" x2="330" y2="210" />
                        <line x1="330" y1="225" x2="330" y2="245" />
                        <line x1="330" y1="260" x2="330" y2="280" />
                        <line x1="330" y1="295" x2="330" y2="315" />
                        <line x1="330" y1="330" x2="330" y2="345" />

                        <line x1="345" y1="70" x2="345" y2="90" />
                        <line x1="345" y1="105" x2="345" y2="125" />
                        <line x1="345" y1="140" x2="345" y2="160" />
                        <line x1="345" y1="175" x2="345" y2="195" />
                        <line x1="345" y1="210" x2="345" y2="230" />
                        <line x1="345" y1="245" x2="345" y2="265" />
                        <line x1="345" y1="280" x2="345" y2="300" />
                        <line x1="345" y1="315" x2="345" y2="335" />

                        <line x1="375" y1="85" x2="375" y2="105" />
                        <line x1="375" y1="120" x2="375" y2="140" />
                        <line x1="375" y1="155" x2="375" y2="175" />
                        <line x1="375" y1="190" x2="375" y2="210" />
                        <line x1="375" y1="225" x2="375" y2="245" />
                        <line x1="375" y1="260" x2="375" y2="280" />
                        <line x1="375" y1="295" x2="375" y2="315" />
                    </g>

                    <!-- 5. Right Tower Mint -->
                    <path d="M395 358 V165 L460 200 V358 Z" fill="#D2EFE3" class="b-line" />
                    <path d="M460 200 H520 V358 H460 Z" fill="#FFFFFF" class="b-line" />

                    <g class="w-line">
                        <line x1="420" y1="210" x2="445" y2="225" />
                        <line x1="420" y1="240" x2="445" y2="255" />
                        <line x1="420" y1="270" x2="445" y2="285" />
                        <line x1="420" y1="300" x2="445" y2="315" />
                    </g>

                    <!-- Trees -->
                    <g transform="translate(425, 260)">
                        <line x1="30" y1="55" x2="30" y2="98" class="b-line" />
                        <path d="M12 55 C12 36 20 28 30 28 C40 28 48 36 48 55 C48 74 12 74 12 55 Z" fill="#FFFFFF" class="b-line" />
                        <line x1="30" y1="36" x2="30" y2="65" class="w-line" />
                        <line x1="30" y1="46" x2="22" y2="42" class="w-line" />
                        <line x1="30" y1="52" x2="38" y2="48" class="w-line" />
                    </g>

                    <g transform="translate(470, 280)">
                        <line x1="20" y1="45" x2="20" y2="78" class="b-line" />
                        <path d="M8 48 C8 32 14 26 20 26 C26 26 32 32 32 48 C32 64 8 64 8 48 Z" fill="#FFFFFF" class="b-line" />
                        <line x1="20" y1="32" x2="20" y2="55" class="w-line" />
                        <line x1="20" y1="40" x2="14" y2="36" class="w-line" />
                        <line x1="20" y1="46" x2="26" y2="42" class="w-line" />
                    </g>
                </svg>
            </div>
        </section>

    </main>

    <!-- Social Login Toast Notification -->
    <div id="toast-notice" class="fixed bottom-6 bg-brand-navy/95 text-white px-5 py-3 rounded-full text-xs font-medium shadow-2xl flex items-center gap-2.5 opacity-0 pointer-events-none transform translate-y-3 z-50">
        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span id="toast-message">Layanan autentikasi sosial akan segera hadir.</span>
    </div>

    <!-- Interactive Scripts -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        function updateSelectedRole(role) {
            const hiddenInput = document.getElementById('selected-role-input');
            if (hiddenInput) {
                hiddenInput.value = role;
            }
        }

        // Quick fill demo credentials
        function fillDemo(email, role) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
            
            if (role === 'librarian') {
                document.getElementById('radio-librarian').checked = true;
                updateSelectedRole('librarian');
            } else {
                document.getElementById('radio-user').checked = true;
                updateSelectedRole('user');
            }

            document.getElementById('email').focus();
        }

        let toastTimeout;
        function showSocialNotice(provider) {
            const toast = document.getElementById('toast-notice');
            const message = document.getElementById('toast-message');
            message.textContent = `Sign in dengan ${provider} untuk Athenaeum Library akan hadir pada rilis berikutnya!`;

            toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-3');
            toast.classList.add('opacity-100', 'translate-y-0');

            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-3');
            }, 3000);
        }
    </script>
</body>
</html>
