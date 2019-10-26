<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>'web'],function(){
Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes(['register'=>false]);
Route::group(['middleware'=>['auth']],function (){
    Route::get('kendaraan','KendaraanController@index')->name('kendaraan');
    Route::post('listnopol','KendaraanController@listnopol')->name('listnopol');
    Route::post('savenopol','KendaraanController@savenopol')->name('savenopol');
    Route::post('deletenopol','KendaraanController@deletenopol')->name('deletenopol');

    Route::get('transaksi/t/{tipe}','TransaksiController@index')->name('transaksi');
    Route::get('transaksi/detail/{kode}','TransaksiController@detail')->name('detail');
    Route::post('listtransaksi','TransaksiController@listtransaksi')->name('listtransaksi');
    Route::get('transaksi/add','TransaksiController@add')->name('addtransaksi');
    Route::post('transaksi/lanjuttrx','TransaksiController@lanjuttrx')->name('lanjuttrx');
    Route::post('transaksi/store','TransaksiController@store')->name('storetransaksi');
    Route::post('transaksi/getkodetrx','TransaksiController@getkodetrx')->name('getkodetrx');
    Route::post('transaksi/updatetrx','TransaksiController@updatetrx')->name('updatetrx');
    Route::post('transaksi/updatetotal','TransaksiController@updatetotal')->name('updatetotal');
    Route::post('transaksi/loadtrx','TransaksiController@loadtrx')->name('loadtrx');
    Route::post('transaksi/updatejumlah','TransaksiController@updatejumlah')->name('updatejumlah');
    Route::post('transaksi/updatediskon','TransaksiController@updatediskon')->name('updatediskon');
    Route::post('transaksi/hapusproduk','TransaksiController@hapusproduk')->name('hapusproduk');
    Route::post('transaksi/updateguideid','TransaksiController@updateguideid')->name('updateguideid');
    Route::post('transaksi/updatenopol','TransaksiController@updatenopol')->name('updatenopol');
    Route::post('transaksi/pendingtrx','TransaksiController@pendingtrx')->name('pendingtrx');
    Route::post('transaksi/canceltrx','TransaksiController@canceltrx')->name('canceltrx');
    Route::post('transaksi/printtrx','PrintController@printtrx')->name('printtrx');
    Route::get('transaksi/testprint','PrintController@testprint')->name('testprint');
    Route::post('transaksi/finish','TransaksiController@finish')->name('finish');

});
Route::group(['prefix'=>'admin','middleware'=>['auth']],function(){
    Route::get('/', function(){
        return view('home');
    })->name('admin');
    Route::get('karyawan','KaryawanController@index')->name('karyawan');
    Route::post('karyawan/list','KaryawanController@listkaryawan')->name('listkaryawan');
    Route::post('deleteuser','KaryawanController@delete')->name('deleteuser');
    Route::get('karyawan/edit/{id}','KaryawanController@edit')->name('edit');
    Route::get('karyawan/add','KaryawanController@add')->name('add');
    Route::post('karyawan/store','KaryawanController@store')->name('store');
    Route::match(['put','patch'],'karyawan/update','KaryawanController@update')->name('update');

    Route::get('guide','GuideController@index')->name('guide');
    Route::post('guide/list','GuideController@listguide')->name('listguide');
    Route::post('deleteguide','GuideController@delete')->name('deleteguide');
    Route::get('guide/edit/{id}','GuideController@edit')->name('edit');
    Route::get('guide/add','GuideController@add')->name('add');
    Route::post('guide/store','GuideController@store')->name('storeguide');
    Route::post('guide/update/{id}','GuideController@update')->name('updateguide');

    Route::post('getkategorikode','KategoriController@getkategorikode')->name('getkategorikode');
    Route::get('produk/kategori','KategoriController@index')->name('kategori');
    Route::post('produk/kategori/list','KategoriController@listkategori')->name('listkategori');
    Route::post('produk/kategori/deletekategori','KategoriController@deletekategori')->name('deletekategori');
    Route::get('produk/kategori/add','KategoriController@add')->name('addkategori');
    Route::post('produk/kategori/store','KategoriController@store')->name('storekategori');
    Route::get('produk/kategori/edit/{id}','KategoriController@edit')->name('editkategori');
    Route::post('produk/kategori/update/{id}','KategoriController@update')->name('updatekategori');

    Route::get('produk','ProdukController@index')->name('produk');
    Route::post('produk/list','ProdukController@listproduk')->name('listproduk');
    Route::post('produk/delete','ProdukController@delete')->name('deleteproduk');
    Route::get('produk/add','ProdukController@add')->name('addproduk');
    Route::post('produk/store','ProdukController@store')->name('storeproduk');
    Route::get('produk/edit/{id}','ProdukController@edit')->name('editproduk');
    Route::post('produk/update/{id}','ProdukController@update')->name('updateproduk');
    Route::post('getkodeproduk','ProdukController@getkodeproduk')->name('getkodeproduk');

});
Route::group(['prefix'=>'kasir','middleware'=>['auth']],function(){
    Route::get('/', function(){
        return view('home');
    })->name('kasir');
});
Route::group(['prefix'=>'konter','middleware'=>['auth']],function(){
    Route::get('/', function(){
        return view('home');
    })->name('konter');



});
Route::get('/home', 'HomeController@index')->name('home');
});
Route::get('test',function (){
 
});
Route::get('trx',function (){
    $trx=\App\Transaksi::find(1);
    foreach ($trx->produk as $item) {
        dd($item->pivot->value('jumlah'));
   }
});
Route::get('print','PrintController@testptint');

Route::get('tmuprint',function(){
    $left=38;
    $right=10;
    $test=str_pad('Item 1 example',$left).str_pad('5',$right,' ',STR_PAD_LEFT);
    dd($test);
});