
<!DOCTYPE html>
<html lang="en">
 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<meta http-equiv="refresh" content="15">-->
    <link rel="icon" href="imgs/smartcard-icon-6.ico">
    <title>pkhosp_eclaim_import</title>
    <link href="dist/css/bootstrap.min.css">
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/css/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">



    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even) {
          background-color: #dddddd;

        }

        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
    </style>
</head>
<body>

      <header class="navbar navbar-dark bg-dark fixed-top">
                  <div class="container-fluid">
                      <a class="navbar-brand" href="index.php">ระบบ Authen Eclaim : โรงพยาบาลผาขาว  V1.65.11.11</a>
                      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                      <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                      <div class="offcanvas-header">
                          <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">เลือกเมนู</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                      </div>
                      <div class="offcanvas-body">
                          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                          <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="index.php">หน้าแรก</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="index_import.php">นำเข้าข้อมูลจากโปรแกรม</a>
                          </li>
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Dropdown
                              </a>
                              <ul class="dropdown-menu dropdown-menu-dark">
                              <li><a class="dropdown-item" href="#">Action</a></li>
                              <li><a class="dropdown-item" href="#">Another action</a></li>
                              <li>
                                  <hr class="dropdown-divider">
                              </li>
                              <li><a class="dropdown-item" href="#">Something else here</a></li>
                              </ul>
                          </li>
                          </ul>
                          <form class="d-flex mt-3" role="search">
                          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                          <button class="btn btn-success" type="submit">Search</button>
                          </form>
                      </div>
                      </div>
                  </div>
      </header>