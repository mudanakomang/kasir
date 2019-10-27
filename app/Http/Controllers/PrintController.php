<?php

namespace App\Http\Controllers;

use App\Transaksi;
use Illuminate\Http\Request;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use App\Item;

class PrintController extends Controller
{
    //
    // public function testprint(){
      
    //     $connector = new WindowsPrintConnector("Microsoft XPS Document Writer"); // Add connector for your printer here.
    //     $printer = new Printer($connector);
    //     $items = array(
    //         new item("Example item #1", "4.00"),
    //         new item("Another thing", "3.50"),
    //         new item("Something else", "1.00"),
    //         new item("A final item", "4.45"),
    //     );
    //     $subtotal = new item('Subtotal', '12.95');
    //     $tax = new item('A local tax', '1.30');
    //     $total = new item('Total', '14.25', true);
    //     $date = "Monday 6th of April 2015 02:56:25 PM";      

    //     $printer -> setJustification(Printer::JUSTIFY_CENTER);      
    //     /* Name of shop */
    //     $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    //     $printer -> text("ExampleMart Ltd.\n");
    //     $printer -> selectPrintMode();
    //     $printer -> text("Shop No. 42.\n");
    //     $printer -> feed();
    //     /* Title of receipt */
    //     $printer -> setEmphasis(true);
    //     $printer -> text("SALES INVOICE\n");
    //     $printer -> setEmphasis(false);
    //     /* Items */
    //     $printer -> setJustification(Printer::JUSTIFY_LEFT);
    //     $printer -> setEmphasis(true);
    //     $printer -> text(new item('', 'Rp'));
    //     $printer -> setEmphasis(false);
    //     foreach ($items as $item) {
    //         $printer -> text($item);
    //     }
    //     $printer -> setEmphasis(true);
    //     $printer -> text($subtotal);
    //     $printer -> setEmphasis(false);
    //     $printer -> feed();
    //     /* Tax and total */
    //     $printer -> text($tax);
    //     $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    //     $printer -> text($total);
    //     $printer -> selectPrintMode();
    //     /* Footer */
    //     $printer -> feed(2);
    //     $printer -> setJustification(Printer::JUSTIFY_CENTER);
    //     $printer -> text("Thank you for shopping at ExampleMart\n");
    //     $printer -> text("For trading hours, please visit example.com\n");
    //     $printer -> feed(2);
    //     $printer -> text($date . "\n");
    //     /* Cut the receipt and open the cash drawer */
    //     $printer -> cut();
    //     $printer -> pulse();
    //     $printer -> close();

    // }

    public function line($str){    
        return str_pad("",40,$str)."\n";
      
    }
    public function rows($left='',$mid='',$right='',$alignright=false){
      
        if($alignright){
            if($left===''){
                $l=str_pad($left,11);     
            }  else{
                $l=str_pad($left,20); 
            }     
            $m=str_pad($mid,15," ",STR_PAD_LEFT);
            $r=str_pad($right,14," ",STR_PAD_LEFT);
        }else{   
            if($left===''){
                $l=str_pad($left,20);     
            }  else{
                $l=str_pad($left,25); 
            }   
            
            $m=str_pad($mid,5);
            $r=str_pad($right,10," ",STR_PAD_LEFT);
        }        
        return $l.$m.$r."\n";
    }
    public function kasir($connector,$content,$total,$byr,$konter=false){    
        $con=$connector = new WindowsPrintConnector($connector);
        $printer = new Printer($con);
        // Header
        //$printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);        
        $printer -> setJustification(Printer::JUSTIFY_CENTER); 
        $printer -> text("INTAN SARI LUWAK COFFEE GARDEN \n& BALI SWING\n");        
       // $printer -> text("GARDEN & BALI SWING \n");
       // $printer -> selectPrintMode();
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("Jl. RAYA TAMPAK SIRING\n");
        $printer -> text("GIANYAR BALI\n");
        $printer -> text("Telp/WA 08164701597/081246109766\n");
        $printer->text($this->line('='));
           
        //$printer -> feed();
        // kode transaksi
        //$printer -> setJustification(Printer::JUSTIFY_CENTER);      
       // $printer -> setEmphasis(true);
        $printer -> text($this->rows($content->kode,"",""));
        if(!$konter){
            $printer -> text($this->rows($content->nopol,"",""));
        }else{
            $printer -> text($this->rows($content->nopol,"",$content->guide->name));
        }
       // $printer -> setEmphasis(false);
        // item
      //  $printer -> setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text(new Item($content->nopol,'',''));
        $printer->text($this->line('='));
        $printer->text($this->rows('Item','Qty','Subtotal'));
        $printer->text($this->line('='));  
        $tkomisi=0;
        foreach($content->produk as $produk){    
            $totalkomisi=0;          
            if($konter){             
                $printer->text($this->rows($produk->nama," X".$produk->pivot->jumlah,number_format($produk->subtotal,0,"",".")));
               
                if($produk->pivot->diskon>0){
                    $harga=$produk->harga;
                    $kms=$produk->komisi;                    
                    $harga_after_diskon=$harga-($harga*$produk->pivot->diskon/100);                                 
                    //$totalh=$harga_after_diskon*$produk->pivot->jumlah;
                    
                    if($produk->tipe_komisi==='fix'){
                        $persen=$kms/$harga;
                        $komisi=($harga_after_diskon-($harga_after_diskon*$persen)*$produk->pivot->jumlah);
                        //$komisi=($produk->komisi*$produk->pivot->jumlah)-$totalh;
                        $totalkomisi+=$komisi;                       
                    }else{
                        //$awal=$harga*$produk->pivot->jumlah-(($harga*$produk->komisi/100)*$produk->pivot->jumlah);
                        //$komisi=$totalh-$awal;
                        $komisi=$produk->pivot->jumlah*($harga_after_diskon-($harga_after_diskon*$kms/100));                                       
                        $totalkomisi+=$komisi;                        
                    }      
                    $tkomisi+=$totalkomisi;           
                    $harga=number_format(($produk->harga*$produk->pivot->jumlah)-($produk->pivot->jumlah*($produk->harga-($produk->harga*$produk->pivot->diskon/100))),0,"",".");               
                    $printer->text($this->rows('','Disc ('.$produk->pivot->diskon.'%)',"-".$harga));
                    $printer->text($this->rows('','Komisi :', "Rp ".number_format($totalkomisi,0,"","."),true));
                }else{
                    
                    if($produk->tipe_komisi==='fix'){
                        $komisi=$produk->komisi*$produk->pivot->jumlah;   
                        $totalkomisi+=$komisi;                 
                    }else{
                        $komisi=($produk->harga*$produk->komisi/100)*$produk->pivot->jumlah;
                        $totalkomisi+=$komisi;
                    }
                    $tkomisi+=$totalkomisi;
                    $printer->text($this->rows('','Komisi :', "Rp ".number_format($totalkomisi,0,"","."),true));
                } 
            }else{
            $printer->text($this->rows($produk->nama," X".$produk->pivot->jumlah,number_format($produk->subtotal,0,"",".")));
            if($produk->pivot->diskon>0){               
                    $harga=number_format(($produk->harga*$produk->pivot->jumlah)-($produk->pivot->jumlah*($produk->harga-($produk->harga*$produk->pivot->diskon/100))),0,"",".");               
                    $printer->text($this->rows('','Disc ('.$produk->pivot->diskon.'%)',"-".$harga));
                }
             }
            $printer->text($this->line('-'));  
        }        
        $printer->feed();
       // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
       if($konter){         
        $printer -> text($this->rows('','Total Belanja:', "Rp ".number_format($total,0,"","."),true));
        //$printer -> selectPrintMode();
        //$printer -> feed();
        //$printer -> setEmphasis(true);       
        //$printer -> setEmphasis(false);
       // $printer -> setEmphasis(true);
        $printer -> text($this->rows('','Total Komisi:', "Rp ".number_format($tkomisi,0,"","."),true));
       }else{        
        $printer -> text($this->rows('','Total :', "Rp ".number_format($total,0,"","."),true));
        //$printer -> selectPrintMode();
        //$printer -> feed();
        //$printer -> setEmphasis(true);
        $printer -> text($this->rows('','Paid :', "Rp ".number_format($byr,0,"","."),true));
        //$printer -> setEmphasis(false);
       // $printer -> setEmphasis(true);
        $printer -> text($this->rows('','Change :', "Rp ".number_format($byr-$total,0,"","."),true));
        //$printer -> setEmphasis(false);
       }

        //$printer -> feed(2);
       // $printer -> setJustification(Printer::JUSTIFY_CENTER);
       $printer->text($this->line('='));  
       $printer->feed();
       if(!$konter){         
             $printer -> text("Items that have been purchased cannot be\nreturned unless there is an agreement\n");
        }
        $printer -> feed(2);
        $printer -> text(\Carbon\Carbon::now('Asia/Makassar')->format('d/m/Y H:i') . " by ".\Illuminate\Support\Facades\Auth::user()->name."\n");
        /* Cut the receipt and open the cash drawer */
        $printer->feed();
        $printer -> cut();
        $printer -> pulse();
        $printer -> close();


    }
    public function konter($connector,$content,$total,$byr){
        
    }

    public function printtrx(Request $request){      
        $totalbelanja=0;
        $trx=Transaksi::with(['produk'=>function($q){
            $q->selectRaw('produk.*,jumlah * harga as subtotal');
        }])->with('guide')->where('kode','=',$request->kode)->first();
       foreach($trx->produk as $produk){
           $totalbelanja+=$produk->subtotal;          
       }   
        
       Transaksi::where('kode','=',$request->kode)->update(['total'=>$request->total,'jumlah_byr'=>$request->byr,'tipe_byr'=>$request->tipe,'print'=>'1']);
       $this->kasir('EPSON TM-U220',$trx,$request->total,$request->byr);
       $this->kasir('EPSON TM-U220',$trx,$request->total,$request->byr,true);
        // $html=view('kasir.transaksi.print',['data'=>$trx,'total'=>$totalbelanja,'byr'=>$byr,'tipe'=>$tipe])->render();
        // file_put_contents('testfile', $html);
        // return $html;
        return response('OK');
    }
}
