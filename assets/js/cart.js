// function is called when the website is loaded.It's loads
function loadCart(){
$.ajax({
    url:`server.php?action=cart`,
    type:"GET",
    dataType:"json",
    success:function(data){
        if(data.length>0){
            
            $('#cart').html()
        }
        else{
            $('#cart').text("Your cart is empty.")
        }
    },
    error: function(xhr, status, error) {
        // handle errors
        console.log(error);
    }
})
}



$(document).ready(function(){
    loadCart()

})