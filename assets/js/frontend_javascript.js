jQuery(function($) {

 
var id = $(".starting_bbhover").attr("id");
$(".custom_add_to_cart_hidden_button").val(id);
var img = $(".starting_bbhover").attr("img");
var product_price = $(".starting_bbhover").attr("product_price");
var description_strong = $(".starting_bbhover").attr("description");
var product_name = $(".starting_bbhover").attr("product_name");
var short_description_strong = $(".starting_bbhover").attr("product_description_short");
var sku_strong = $(".starting_bbhover").attr("product_sku");
var product_type = $(".starting_bbhover").attr("product_type");
var url = $(".starting_bbhover").attr("url");



$("#main_img_con").attr("src",img);
$("#description_strong").text(description_strong);
$("#price_div").text(product_price);
$("#name_div").text(product_name);
$("#short_description_strong").text(short_description_strong);
$("#sku_strong").text(sku_strong);
$("#product_type").text(product_type);


$(".bbhover").hover(function(){

    var id = $(this).attr("id");
    $(".custom_add_to_cart_hidden_button").val(id);
    var img = $(this).attr("img");
    var product_price = $(this).attr("product_price");
    var description_strong = $(this).attr("description");
    var product_name = $(this).attr("product_name");
    var short_description_strong = $(this).attr("product_description_short");
    var sku_strong = $(this).attr("product_sku");
    var product_type = $(this).attr("product_type");
    var url = $(this).attr("url");
   
    $("#main_img_con").attr("src",img);
    $("#description_strong").text(description_strong);
    $("#price_div").text(product_price);
    $("#name_span").text(product_name);
    $("#name_div").text(product_name);
    $("#short_description_strong").text(short_description_strong);
    $("#sku_strong").text(sku_strong);
    $("#product_type").text(product_type);
   
});


});

