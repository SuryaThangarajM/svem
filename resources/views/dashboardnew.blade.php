<!DOCTYPE html>
<html lang="en">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>SVEM</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- bootstrap css -->
   <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
   <!-- style css -->
   <link rel="stylesheet" type="text/css" href="assets/css/style.css">
   <!-- Responsive-->
   <link rel="stylesheet" href="assets/css/responsive.css">
   <!-- fevicon -->
   <!-- <link rel="icon" href="assets/images/fevicon.png" type="image/gif" /> -->
   <link rel="icon" type="image/gif" href="assets/images/JCB.ico">
   <!-- Scrollbar Custom CSS -->
   <link rel="stylesheet" href="assets/css/jquery.mCustomScrollbar.min.css">
   <!-- Tweaks for older IEs-->
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <!-- owl stylesheets -->
   <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
   <link rel="stylesoeet" href="assets/css/owl.theme.default.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body>
   <!-- header section start -->
   <div class="header_section">
      <div class="container-fluid header_main">
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- <a class="logo" href="index.html" style="font-size: 1000;">SRI VINAYAGA EARTH MOVERS</a> -->
            <a class="navbar-brand" href="index.html" style="font-weight: bold; color: red; font-size: 20px;">
               SRI VINAYAGA EARTH MOVERS
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link" href="">Home</a>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="generalDropdown" role="button" data-bs-toggle="dropdown">
                        General
                     </a>
                     <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('getcus') }}">Customer Entry</a></li>
                        <li><a class="dropdown-item" href="{{ route('getopr') }}">Operator Entry</a></li>
                        <li><a class="dropdown-item" href="{{ route('getVehi') }}">Vehicle Entry</a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="generalDropdown" role="button" data-bs-toggle="dropdown">
                        Billing
                     </a>
                     <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('getbill') }}">Bill Entry</a></li>
                        <li><a class="dropdown-item" href="{{ route('expentry') }}">Expense Entry</a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="generalDropdown" role="button" data-bs-toggle="dropdown">
                        Reports
                     </a>
                     <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('getbillall') }}">BillReports</a></li>
                        <li><a class="dropdown-item" href="{{ route('getincomeexpense') }}">Income/Expense Reports</a></li>
                        <li><a class="dropdown-item" href="{{ route('getvehireport') }}">Vehicle's Report</a></li>
                     </ul>
                  </li>
                  <!-- <li class="nav-item">
                     <a class="nav-link" href="contact.html">Contact Us</a>
                  </li> -->
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                     </a>
                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                           <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <x-dropdown-link :href="route('logout')"
                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                 {{ __('Log Out') }}
                              </x-dropdown-link>
                           </form>
                        </li>
                     </ul>
                  </li>
                  <!-- <li class="nav-item">
                     <a class="nav-link" href="#"><img src="assets/images/serach-icon.png"></a>
                  </li> -->
               </ul>
            </div>
         </nav>
      </div>
      <!-- banner section start -->
      <div class="container-fluid">
         <div class="banner_section layout_padding">


         </div>
      </div>
      <!-- banner section end -->
   </div>

   <!-- header section end -->
   <!-- Javascript files-->
   <script src="assets/js/jquery.min.js"></script>
   <script src="assets/js/popper.min.js"></script>
   <script src="assets/js/bootstrap.bundle.min.js"></script>
   <script src="assets/js/jquery-3.0.0.min.js"></script>
   <script src="assets/js/plugin.js"></script>
   <!-- sidebar -->
   <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
   <script src="assets/js/custom.js"></script>
   <!-- javascript -->
   <script src="assets/js/owl.carousel.js"></script>
   <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>