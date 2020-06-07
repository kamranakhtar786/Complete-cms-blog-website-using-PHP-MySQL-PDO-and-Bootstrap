<?php
session_start();

function ErrorMessage(){
if(isset($_SESSION["ErrorMessage"])){
    $Output = "<div class=\"alert alert-danger\">";
    $Output .= htmlentities($_SESSION["ErrorMessage"]);
    $Output .= "</div>";
    $_SESSION["ErrorMessage"] = null;
    return $Output;
}

}

function SuccessMessage(){
    if(isset($_SESSION["SuccessMessage"])){
        $Output = "<div class=\"alert alert-success\">";
        $Output .= htmlentities($_SESSION["SuccessMessage"]);
        $Output .= "</div>";
        $_SESSION["SuccessMessage"] = null;
        return $Output;
    }
    
    }

    function InfoMessage(){
        if(isset($_SESSION["InfoMessage"])){
            $Output = "<div class=\"alert alert-info\">";
            $Output .= htmlentities($_SESSION["InfoMessage"]);
            $Output .= "</div>";
            $_SESSION["InfoMessage"] = null;
            return $Output;
        }
        
        }

        function WelcomeMessage(){
            if(isset($_SESSION["username"])){
                $Output = "<div class=\"alert alert-success\"> Welcome ";
                $Output .= htmlentities($_SESSION["username"]);
                $Output .= "</div>";
               
                return $Output;
            }  
        }
        function NotFoundMessage(){
            if(isset($_SESSION["NotFoundMessage"])){
                $Output = "<div class=\"alert alert-danger text-center text-black\"> <span style=\"font-size:30px\">Sorry , Page Not Found! <i class=\"fas fa-frown\"></i></span> ";
                $Output .= "<hr><img src='../uploads/notFound.jpg' style='width:100%;'>";
                $Output .="<hr><span style=\"font-size:25px\">Try another posts &nbsp; <span class='fa fa-arrow-down'></span></span>";
                $Output .= "</div>";
               $_SESSION["NotFoundMessage"]= null;
                return $Output;
            }  
        }

?>