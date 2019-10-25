<!DOCTYPE html>
<html lang="en" >

<head>

  <meta charset="UTF-8">
  
  <title>Print Transaksi # {{ $data->kode }}</title>

  <style>
p {
  margin: 0;padding:0;
}


@media print {
    .page-break { display: block; page-break-before: always; }
}
      #invoice-POS {
  /* box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); */
  padding: 1mm;
  width: 72mm;
  background: #FFF;
}
#invoice-POS ::selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS ::moz-selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS h1 {
  font-size: 1.5em;
  color: #222;
}
#invoice-POS h2 {
  font-size: .9em;
}
#invoice-POS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
#invoice-POS p {
  font-size: .8em;
  /* color: #666; */
  line-height: 1.2em;
}
#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
  /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}
#invoice-POS #top {
  min-height: auto;
}
#invoice-POS #mid {
  min-height: auto;
}
#invoice-POS #bot {
  min-height: 50px;
}


#invoice-POS .info {
  display: block;
  margin-left: 0;
}
#invoice-POS .title {
  float: right;
}
#invoice-POS .title p {
  text-align: right;
}
#invoice-POS table {
  width: 100%;
  border-collapse: collapse;
}
#invoice-POS .tabletitle {
  font-size: 0.75em;
  /* background: #EEE; */
  border-bottom: 1px solid #000;
  border-top: 1px solid #000;
}
#invoice-POS .total {
  font-size: 0.75em;
  /* background: #EEE; */
  border-top: 1px solid #000; 
}
#invoice-POS .bayar {
  font-size: 0.75em;
  /* background: #EEE; */
 
}
#invoice-POS .kembali {
  font-size: 0.75em;
  /* background: #EEE; */
  border-bottom: 1px solid #000; 
}
#invoice-POS .guide {
  font-size: 0.65em;
  /* background: #EEE; */

}


#invoice-POS .service {

  /* border-bottom: 1px solid #EEE; */
}
#invoice-POS .item {
  width: 24mm;
}
#invoice-POS .itemtext {
  font-size: 0.76em;
  margin-top:5px;
  margin-bottom:5px;
}
#invoice-POS #legalcopy {
  margin-top: 2.5mm;
}

    </style>

<script>
  window.addEventListener('load',function(){
    window.print()
  })
</script>



</head>

<body translate="no" >


  <div id="invoice-POS">

    <center id="top">
      <div class="info"> 
        <h2>SBISTechs Inc</h2>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->

    <div id="mid">
      <div class="info">
        <!-- <h2>Contact Info</h2> -->
        
        <p> 
            Address : street city, state 0000</br>
            Email   : JohnDoe@gmail.com</br>
            Phone   : 555-555-5555</br>
            Date     : {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s')}}
        </p>
        
      </div>
    </div><!--End Invoice Mid-->
    <div id="legalcopy">
   <p class="legal"> <strong>Trx ID: {{ $data->kode }}</strong></p>
    </div>
    <div id="bot">

                    <div id="table">
                        <table>
                            <tr class="tabletitle">
                                <td class="item"><h2>Item</h2></td>
                                <td class="Hours"><h2>Qty</h2></td>
                                <td class="Rate"><h2>Sub Total</h2></td>
                            </tr>
                            @foreach($data->produk as $produk)
                            <tr class="service">
                                <td class="tableitem"><p class="itemtext">{{ $produk->nama }}  </p></td>
                                <td class="tableitem"><p class="itemtext">{{ "x ".$produk->pivot->jumlah }}</p></td>
                                <td class="tableitem"><p class="itemtext">Rp {{ number_format($produk->subtotal,0,"",".") }}</p></td>
                            </tr>
                            @endforeach
                            <tr class="total">
                                <td></td>
                                <td class="Rate"><h2>Total</h2></td>
                                <td class="payment"><h2>Rp {{ number_format($total,0,"",".") }}</h2></td>
                               
                            </tr>
                            <tr class="bayar">
                              <td></td>
                                <td class="Rate"><h2>Bayar</h2></td>
                                <td class="payment"><h2>Rp {{ number_format($byr,0,"",".") }}</h2></td>                              
                            </tr>
                            <tr class="kembali">
                            <td></td>
                                <td class="Rate"><h2>Kembali</h2></td>
                                <td class="payment"><h2>Rp {{ number_format($byr-$total,0,"",".") }}</h2></td>
                            </tr>                          
                        </table>
                    </div><!--End Table-->

                    <div id="legalcopy">
                        <p class="legal"><strong>Note:</strong>  </p>
                    </div>

                </div><!--End InvoiceBot-->
               
  </div><!--End Invoice-->
  <div class="page-break"></div>
</body>

</html>