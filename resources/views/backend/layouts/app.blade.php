<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{asset('assets/dist/css/tabler.min.css?v=').env('APP_VERSION')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-flags.min.css?v=').env('APP_VERSION')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-payments.min.css?v=').env('APP_VERSION')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-vendors.min.css?v=').env('APP_VERSION')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body >
    <script src="{{asset('assets/dist/js/demo-theme.min.js?v=').env('APP_VERSION')}}"></script>
    <div class="page">
      <!-- Sidebar -->
      @include('backend.layouts.sidebar')
      <!-- Navbar -->
      @include('backend.layouts.header')
      <div class="page-wrapper">
        @yield('content')
        </div>
        @include('backend.layouts.footer')
      </div>
    </div>
    <!-- Tabler Core -->
    <script src="{{asset('assets/dist/js/tabler.min.js?v=').env('APP_VERSION')}}" defer></script>
    @livewireScripts
  </body>
</html>