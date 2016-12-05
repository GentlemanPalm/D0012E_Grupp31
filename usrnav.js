function usrnav() {
$.ajax({
  url: "getusrnav.php"
}).done(function(data) {
  $("#usrnav").html(data);
});
}