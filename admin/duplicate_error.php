<?php if(isset($_SESSION['duplicate'])){
    echo '<script>$(document).ready(function (){duplicate();});</script>';
    unset($_SESSION['duplicate']);
    } 
echo '<div class="alert alert-duplicate alert-autocloseable-duplicate" style="background: #d9534f; position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
     Duplicate record !
</div>';
?>

<?php if(isset($_SESSION['duplicateuser'])){
    echo '<script>$(document).ready(function (){duplicateuser();});</script>';
    unset($_SESSION['duplicateuser']);
    } 
echo '<div class="alert alert-duplicateuser alert-autocloseable-duplicateuser" style="background: #d9534f; position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
     Username Already Exists !
</div>';
?>
