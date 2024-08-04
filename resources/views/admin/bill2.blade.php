<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
    <style>

@page {
                 size: 5.0in 8.5in;

                  margin-top:-150px;
               margin-right:0%;
                margin-left:3%;
             }



        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            /* border: 1px solid #000; */
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
        }
        .header h1 {
            margin: 0;
            font-size: 36px;
            color: #e74c3c;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        .charges {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details {
            width: 170%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details td, .charges th, .charges td {
            /* border: 1px solid #000; */
            padding: 8px;
        }
        .details td {
            width: 50%;
        }

        .info, .charges {
            /* width: 100%; */
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info td, .charges th, .charges td {
            /* border: 1px solid #000; */
            padding: 8px;
        }
        .info td {
            width: 50%;
        }


        .charges th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
            margin-right: 60px;
        }
        .notes {
            font-size: 12px;
            margin-top: 20px;
        }
        .notes li {
            list-style-type: none;
        }
    </style>
</head>
<body>
    <div class="container">

        <table class="details">
            <tr>
                <td>Bill No: <strong id="bill-no"></strong></td>
                <td>Date: <span id="bill-date"></span></td>
            </tr>
        </table>
        <div class="header">
            {{-- <h1 style="margin-bottom: 20px; margin-top: 80px;">HOTEL GALAXY</h1> --}}
            <h1 id="restro-name" style="margin-bottom: 20px; margin-top: 80px;"></h1>

            <!-- <p>Since 1972</p> -->
            {{-- <p style="margin-bottom: 80px;">10/1A/2, Opp. Shivajinagar S.T. Stand, next to railway station, shivajinagar, pune-411005.<br>
            Tel: 020-25536058/25510074 E-mail: hotelpark.pune@gmail.com</p> --}}
            <p id="restro-address" style="margin-bottom: 80px;"></p>

        </div>
        <table class="info"  id="order-info" style="width: 40%; ">
            <!-- <tr>
                <td>Name: <input type="text" style="width: 100%;"></td>
            </tr> -->
            {{-- <tr style="padding: 80px;">
                <td>Number :</td>
                <td>H2P2364545</td>
            </tr>
            <tr>
                <td>Name: </td>
                <td> Shubham Shukla </td>
            </tr>
            <tr>
                <td>Invoice Date: </td>
                <td>29/05/2024</td>
            </tr>

            <tr>
                <td>Order Id: </td>
                <td>1122</td>
            </tr> --}}
            <!-- <tr>
                <td>Rate Rs <input type="number" style="width: 50%;"> for <input type="number" style="width: 50%;"> days as per Rs <input type="number" style="width: 50%;"></td>
            </tr> -->
        </table>
        <table class="charges" id="order-items" style="text-align: center;">
            <tr>
                <th>Items</th>
                <th>Quantity</th>
                <th>Price (in Rs.)</th>
                <th>Total</th>
            </tr>

                        <!-- Order items will be inserted here -->

            {{-- <tr>
                <td>Paneer Tikka</td>
                <td>2</td>
                <td>100</td>
                <td>200</td>
            </tr>
            <tr>
                <td>Paneer Tikka</td>
                <td>2</td>
                <td>100</td>
                <td>200</td>
            </tr>
            <tr>
                <td>Paneer Tikka</td>
                <td>2</td>
                <td>100</td>
                <td>200</td>
            </tr>
            <tr>
                <td>Paneer Tikka</td>
                <td>2</td>
                <td>100</td>
                <td>200</td>
            </tr> --}}

            <!-- <tr>
                <th>Total</th>
                <th>8</th>
                <th>400</th>
                <th>800</th>
            </tr> -->
        </table>

        <hr>
        <div class="footer" id="order-total">
            <!-- <p>Sub Total :   &nbsp;          800</p>
            <p>Tax (10%) :   &nbsp;&nbsp;   80</p> -->
            {{-- <p>Total     :   &nbsp;   880</p> --}}

                        <!-- Order total will be inserted here -->


        </div>
        <div class="notes">
            <!-- <p>Note:</p> -->
            <ul>
                <li>Address : 3184 Spruce Drive Pittsburgh, PA 15201</li>
                <li>Email : info@gmail.com</li>
            </ul>
        </div>

        <button onclick="fetchOrderDetails()">Print Bill</button>

    </div>


    <script>
      function fetchOrderDetails() {
          const orderId = 15; // Replace with actual order ID

          fetch(`/order-details/${orderId}`)
              .then(response => response.json())
              .then(data => {

                  // Populate restaurant name
                  document.getElementById('restro-name').innerText = data.restroName;

                    // Populate restaurant address
                    document.getElementById('restro-address').innerText = data.restroAddress;

                  // Populate bill details
                  document.getElementById('bill-no').innerText = data.orderId2;
                    document.getElementById('bill-date').innerText = data.invoiceDate;

                  // Populate order information
                  const orderInfo = `

                  <tr>
                          <td>Customer Name:</td>
                          <td>${data.customerName}</td>
                      </tr>
                      <tr>
                          <td>Invoice Date:</td>
                          <td>${data.invoiceDate}</td>
                      </tr>
                      <tr>
                          <td>Order Id:</td>
                          <td>${data.orderId}</td>
                      </tr>
                  `;
                  document.getElementById('order-info').innerHTML = orderInfo;

                  // Populate order items
                  let orderItems = '';
                  data.items.forEach(item => {
                      orderItems += `
                          <tr>
                              <td>${item.recipe}</td>
                              <td>${item.quantity}</td>
                              <td>${item.price}</td>
                              <td>${item.total}</td>
                          </tr>
                      `;
                  });
                  document.getElementById('order-items').innerHTML += orderItems;

                  // Populate order total
                  const orderTotal = `<p>Total: &nbsp; ${data.total}</p>`;
                  document.getElementById('order-total').innerHTML = orderTotal;

                  // Print the bill
                  window.print();
              })
              .catch(error => {
                  console.error('Error fetching order details:', error);
              });
      }
  </script>
</body>
</html>
