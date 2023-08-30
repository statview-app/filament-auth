<!DOCTYPE html>
<html lang="en">
<head>
    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::head.start') }}

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @if ($favicon = filament()->getFavicon())
        <link rel="icon" href="{{ $favicon }}" />
    @endif

    <title>
        {{ filament()->getBrandName() }}
    </title>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::styles.before') }}

    <style>
        [x-cloak=''],
        [x-cloak='x-cloak'],
        [x-cloak='1'] {
            display: none !important;
        }

        @media (max-width: 1023px) {
            [x-cloak='-lg'] {
                display: none !important;
            }
        }

        @media (min-width: 1024px) {
            [x-cloak='lg'] {
                display: none !important;
            }
        }
    </style>

    @filamentStyles
    {{ filament()->getTheme()->getHtml() }}
    {{ filament()->getFontHtml() }}

    <style>
        :root {
            --font-family: {!! filament()->getFontFamily() !!};
            --sidebar-width: {{ filament()->getSidebarWidth() }};
            --collapsed-sidebar-width: {{ filament()->getCollapsedSidebarWidth() }};
        }
    </style>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::styles.after') }}

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::head.end') }}
</head>
<body class="fi-body min-h-screen overscroll-y-none bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white passport-authorize">

<div class="fi-simple-layout flex min-h-screen flex-col items-center">
    <div
            class="fi-simple-main-ctn flex w-full flex-grow items-center justify-center"
    >
        <main
                class="fi-simple-main my-16 w-full bg-white px-6 py-12 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 sm:max-w-lg sm:rounded-xl sm:px-12"
        >
            <section class="grid auto-cols-fr gap-y-6">
                <x-filament-panels::header.simple
                        :logo="true"
                />

                <div class="space-y-5">
                    <!-- Introduction -->
                    <p class="text-lg"><strong>{{ $client->name }}</strong> is asking for access to your account.</p>

                    <!-- Scope List -->
                    @if (count($scopes) > 0)
                        <div class="scopes">
                            <p><strong>The application will get access to the following data:</strong></p>

                            <ul class="ml-5">
                                @foreach ($scopes as $scope)
                                    <li class="list-disc">{{ $scope->description }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="buttons flex space-x-3">
                        <form class="w-full" method="post" action="{{ route('filament-auth.sso.authorizations.approve') }}">
                            @csrf

                            <input type="hidden" name="state" value="{{ $request->state }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <input type="hidden" name="auth_token" value="{{ $authToken }}">

                            <x-filament::button type="submit" class="w-full" color="success" icon="heroicon-o-check">
                                Accept
                            </x-filament::button>
                        </form>

                        <!-- Cancel Button -->
                        <form class="w-full" method="post" action="{{ route('filament-auth.sso.authorizations.deny') }}">
                            @csrf
                            @method('DELETE')

                            <input type="hidden" name="state" value="{{ $request->state }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <input type="hidden" name="auth_token" value="{{ $authToken }}">

                            <x-filament::button type="submit" class="w-full" color="danger" icon="heroicon-o-x-mark">
                                Deny
                            </x-filament::button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
</body>
</html>
