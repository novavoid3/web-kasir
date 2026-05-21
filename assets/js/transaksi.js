$(document).ready(function(){

$('.qty').keyup(function(){

let harga = $('.harga').val();
let qty   = $(this).val();

let subtotal = harga * qty;

$('.subtotal').val(subtotal);

});

});