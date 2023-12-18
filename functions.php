<?php

function nombreProduitsSession(){

    if(isset($_SESSION['products'])){

        return count($_SESSION['products']);

    }else {
        
        return 0;
    }

}