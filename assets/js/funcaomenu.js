$(function(){

    //$('#btnMinimizarMenu').click();

    $(document).on("mouseover","#sidebar",function(){
        $('#sidebar').removeClass("c-sidebar-minimized");
    });

    $(document).on("mouseout","#sidebar",function(){
        $('#sidebar').addClass("c-sidebar-minimized");
    });

});