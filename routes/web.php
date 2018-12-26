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


Route::get('/', 'Landing@index');
Route::get('/kasir', 'KasirDashboard@index');

// cart
Route::get('/kasir/dashboard-kasir', 'KasirDashboard@index')->name('dashboard.kasir');
Route::get('/kasir/dashboard-kasir/add-to-cart/{id}', 'KasirDashboard@AddToCart')->name('addtocart.kasir');
Route::post('/kasir/dashboard-kasir/remove-from-cart', 'KasirDashboard@RemoveFromCart')->name('removefromcart.kasir');
Route::post('/kasir/dashboard-kasir/update-cart', 'KasirDashboard@UpdateCart')->name('updatecart.kasir');
Route::get('/kasir/dashboard-kasir/remove-all', 'KasirDashboard@removecart')->name('removecart.kasir');


Route::get('/kasir/transaksi-kasir', 'KasirTransaksi@index')->name('transaksi.kasir');
Route::post('/kasir/transaksi-kasir/nota', 'KasirTransaksi@Nota')->name('nota.kasir');
Route::get('/kasir/transaksi-kasir/detail-transaksi/{nomor_nota}', 'KasirTransaksi@DetailTransaksi')->name('detailtransaksi.kasir');
Route::get('/kasir/cek', 'KasirTransaksi@Cek')->name('cek.kasir');

Route::post('/kasir/transaksi-kasir/delete', 'KasirTransaksi@DeleteTransaksi')->name('deletetransaksi.kasir');
Route::post('/kasir/transaksi-kasir/restore', 'KasirTransaksi@RestoreTransaksi')->name('restoretransaksi.kasir');

Route::get('/admin', 'AdminDashboard@index');
Route::get('/admin/dashboard-admin', 'AdminDashboard@index')->name('dashboard.admin');

//produk
Route::get('/admin/produk-admin', 'AdminProduk@index')->name('produk.admin');
Route::get('/admin/produk-admin/delete/{id_kat}', 'AdminProduk@DeleteKategori')->name('deletekategori.admin');
Route::post('/admin/produk-admin/add-kategori', 'AdminProduk@AddKategori')->name('addkategori.admin');
Route::post('/admin/produk-admin/add', 'AdminProduk@AddProduk')->name('addproduk.admin');
Route::post('/admin/produk-admin/delete', 'AdminProduk@DeleteProduk')->name('deleteproduk.admin');
Route::post('/admin/produk-admin/update', 'AdminProduk@UpdateProduk')->name('updateproduk.admin');
// supplier
Route::get('/admin/supplier-admin', 'AdminSupplier@index')->name('supplier.admin');
Route::post('/admin/supplier-admin/add', 'AdminSupplier@AddSupplier')->name('addsupplier.admin');
Route::post('/admin/supplier-admin/delete', 'AdminSupplier@DeleteSupplier')->name('deletesupplier.admin');
Route::post('/admin/supplier-admin/update', 'AdminSupplier@UpdateSupplier')->name('updatesupplier.admin');

//laporan admin
Route::get('/admin/laporan-admin', 'AdminLaporan@index')->name('laporan.admin');
Route::post('/admin/laporan-admin/download', 'AdminLaporan@Download')->name('downloadlaporan.admin');
Route::get('/admin/laporan-admin-harian', 'AdminLaporanHarian@index')->name('laporanharian.admin');
Route::post('/admin/laporan-admin-harian/download', 'AdminLaporanHarian@Download')->name('downloadlaporanharian.admin');

Route::get('/admin/penjualan-admin', 'AdminPenjualan@index')->name('penjualan.admin');

Route::get('/admin/pembelian-admin', 'AdminPembelian@index')->name('pembelian.admin');
Route::post('/admin/pembelian-admin/add-pembelian', 'AdminPembelian@AddPembelian')->name('addpembelian.admin');
Route::get('/admin/pembelian-admin/detail-pembelian/{id_pembelian}', 'AdminPembelian@DetailPembelian')->name('detailpembelian.admin');
Route::post('/admin/pembelian-admin/detail-pembelian/update', 'AdminPembelian@UpdatePembelian')->name('updatepembelian.admin');