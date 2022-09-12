
<?php 
if(isset($_GET['submit'])){
  if($_GET['submit']=="Reset"){
    $this->view('Admin/index');
  }
}
?>
<script>
$(document).ready(function(){
  $(".reset-btn").click(function(){
        $("#myForm").trigger("reset");
    });
});
</script>