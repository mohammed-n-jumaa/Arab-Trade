<?php session_start(); ?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Add Post</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="assets/font/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/font/font.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/style2.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/jquery.bxslider.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/news.css">
  <link rel="stylesheet" type="text/css" href="assets/css/modules-widgets.css">

  
</head>

<body>
  <div class="body_wrapper">
    <div class="center">
      <?php include 'headerUser.php'; ?>

      <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing  ">
        <div class=" widget-table-two" style="margin-top: 20px;">

          <div style="margin-top: 20px;" class="widget-heading ">

            <h2> <strong> Stocks</strong></h2>
          </div>
          <br>
          <div class="widget-content">

            <table class="table">
              <thead>
                <tr>
                  <th>
                    <div class="th-content">Coin</div>
                  </th>
                  <th>
                    <div class="th-content">Symbol</div>
                  </th>
                  <th>
                    <div class="th-content th-heading">Price</div>
                  </th>
                  <th>
                    <div class="th-content">High Price</div>
                  </th>
                  <th>
                    <div class="th-content">Total supply</div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="td-content customer-name"><img src="assets\css\images\btc-logo.png" alt="avatar">Btcion
                    </div>
                  </td>
                  <td>
                    <div class="td-content product-brand">Btc</div>
                  </td>
                  <td>
                    <div class="td-content">-API-</div>
                  </td>
                  <td>
                    <div class="td-content pricing"><span class="">$69.000</span></div>
                  </td>
                  <td>
                    <div class="td-content"><span class="badge outline-badge-success ">21 M</span></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="td-content customer-name"><img src="assets\css\images\eth_logo.jpg"
                        alt="avatar">Ethereum
                    </div>
                  </td>
                  <td>
                    <div class="td-content product-brand">Eth</div>
                  </td>
                  <td>
                    <div class="td-content">-API-</div>
                  </td>
                  <td>
                    <div class="td-content pricing"><span class="">$4.800</span></div>
                  </td>
                  <td>
                    <div class="td-content"><span class="badge outline-badge-success">120 M</span></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="td-content customer-name"><img src="assets\css\images\bnb_logo.jpg" alt="avatar">Bnb
                    </div>
                  </td>
                  <td>
                    <div class="td-content product-brand">Bnb</div>
                  </td>
                  <td>
                    <div class="td-content">-API-</div>
                  </td>
                  <td>
                    <div class="td-content pricing"><span class="">$680</span></div>
                  </td>
                  <td>
                    <div class="td-content"><span class="badge outline-badge-success">158 M</span></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="td-content customer-name"><img src="assets\css\images\ada_logo.jpg" alt="avatar">Cardano
                    </div>
                  </td>
                  <td>
                    <div class="td-content product-brand">Ada</div>
                  </td>
                  <td>
                    <div class="td-content">-API-</div>
                  </td>
                  <td>
                    <div class="td-content pricing"><span class="">$3</span></div>
                  </td>
                  <td>
                    <div class="td-content"><span class="badge outline-badge-success">45 P</span></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="td-content customer-name"><img src="assets\css\images\sol_logo.jpg" alt="avatar">Solana
                    </div>
                  </td>
                  <td>
                    <div class="td-content product-brand">Sol</div>
                  </td>
                  <td>
                    <div class="td-content">-API-</div>
                  </td>
                  <td>
                    <div class="td-content pricing"><span class="">$260</span></div>
                  </td>
                  <td>
                    <div class="td-content"><span class="badge outline-badge-success">545 M</span></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="td-content customer-name"><img src="assets\css\images\matic_logo.jpg"
                        alt="avatar">Polygon
                    </div>
                  </td>
                  <td>
                    <div class="td-content product-brand">Matic</div>
                  </td>
                  <td>
                    <div class="td-content">-API-</div>
                  </td>
                  <td>
                    <div class="td-content pricing"><span class="">$2.9</span></div>
                  </td>
                  <td>
                    <div class="td-content"><span class="badge outline-badge-success">1.3 P</span></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="td-content customer-name"><img src="assets\css\images\dot_logo.jpg" alt="avatar">Polkdot
                    </div>
                  </td>
                  <td>
                    <div class="td-content product-brand">Dot</div>
                  </td>
                  <td>
                    <div class="td-content">-API-</div>
                  </td>
                  <td>
                    <div class="td-content pricing"><span class="">$54</span></div>
                  </td>
                  <td>
                    <div class="td-content"><span class="badge outline-badge-success">1.3 P</span></div>
                  </td>
                </tr>

              </tbody>
            </table>

          </div>
        </div>
      </div>

      <?php include 'footerUser.php'; ?>
    </div>
  </div>
</body>

</html>